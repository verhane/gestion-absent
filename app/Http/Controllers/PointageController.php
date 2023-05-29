<?php

namespace App\Http\Controllers;

use App\Exports\PointageExport;
use App\Http\Requests\editPointageRequest;
use App\Http\Requests\PointageRequest;
use App\Models\ClassesPrStagiaire;
use App\Models\DetailsPointage;
use App\Models\RefPresent;
use Carbon\Carbon;
use Dcs\Admin\Models\SysUser;
use Illuminate\Http\Request;
use  App\Models\Pointage ;
use   App\Models\Classe;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Mpdf\Mpdf;
class PointageController extends Controller
{
    private $view="pointages";
    private $link = "pointages";

    public function index()
    {
        $classes = Classe::all();
        $surveillants = SysUser::query()->whereIn('id', Pointage::query()->select('sys_user_id'))->get();
        return view($this->view.'.index', ['classes'=>$classes, 'surveillants'=>$surveillants]);
    }

    public function getDT(Request $request)
    {
        $pointages = Pointage::query()->orderBy('created_at', 'desc')->with('classe', 'pointeur');

        if ($request->get('date_debut')){
            $pointages = $pointages->where('date' ,'>=',$request->get('date_debut'));
        }
        if ($request->get('date_fin')){
            $pointages = $pointages->where('date' ,'<=',$request->get('date_fin'));
        }
        if($request->get('surveillant')){
            $pointages = $pointages->where('sys_user_id',$request->get('surveillant'));
        }
        if($request->get('classe')){
            $pointages = $pointages->where('classe_id', $request->get('classe'));
        }

        return DataTables::of($pointages)
            ->editColumn('date',function ($pointage){
                $formattedDate = Carbon::parse($pointage->date)->format('d/m/Y');
                return $formattedDate ;
            })
            ->editColumn('heure',function ($pointage){
                $formattedDate = Carbon::parse($pointage->heure)->format('H:i');
                return $formattedDate ;
            })
            ->addColumn('actions', function ($pointage) {
                $deleteLink = $this->link.'/delete/' . $pointage->id;
                $actions = collect();
                $actions->push([
                    'icon' => 'show',
                    'href' => "#!",
                    'onClick' => "openObjectModal(" . $pointage->id . ",'pointages','#datatableshow','main',1,'xl')",
                    'class' => 'btn-dark btn-sm',
                    'title' => trans('text.visualiser')
                ]);
                if (auth()->user()->hasAccess(30,5))
                $actions->push([
                    'icon' => 'delete',
                    'title' => 'Delete',
                    'href' => "#!",
                    'onClick' => "confirmAndRefreshDT('" . url($deleteLink) . "','Are you sure you want to delete this item?')",
                    'class' => 'btn-warning btn-sm',
                ]);
                return view('actions-btn', ["actions" => $actions])->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function getElevesDT($selected = 'all', $pointage_id)
    {
        $pointage = Pointage::find($pointage_id);

        return DataTables::of($pointage->details_pointages()->with('pr_stagiaire'))
            ->addColumn('presence',function ($detail){
                $isDisabled = '';
                if($detail->pointage->ref_etats_pointage_id == 2)
                    $isDisabled='disabled';
                if (!auth()->user()->hasAccess(30,2)){
                    $isDisabled='disabled';
                }
                $html = '<input type="hidden" name="detail_presences[]" value="'.$detail->id.'">';
                $html .= '<input name="presence_'.$detail->id.'" value="1" type="radio"'.($detail->ref_etats_presence_id == 1 ? 'checked' : '').' '.$isDisabled.'/> <span class="mr-1">'. trans("pointage.present") .'</span>';
                $html .= '<input name="presence_'.$detail->id.'" value="2" type="radio"'.($detail->ref_etats_presence_id == 2 ? 'checked' : '').' '.$isDisabled.'/> <span class="mr-1">'.trans("pointage.absent").'</span>';
                $html .= '<input name="presence_'.$detail->id.'" value="3" type="radio"'.($detail->ref_etats_presence_id == 3 ? 'checked' : '').' '.$isDisabled.'/> <span class="mr-1"> '.trans("pointage.absent_justifie").' </span>';
                return $html;
            })
            ->addColumn('full_name', function ($detail) {
                if($detail->pr_stagiaire->nni_checked && file_exists('anrpts/photos/'.$detail->pr_stagiaire->nni.'.jpg'))
                        $img_link = 'anrpts/photos/'.$detail->pr_stagiaire->nni.'.jpg';
                else
                        $img_link = 'img/avatar_2x.png';
                $img = '<img style="width:35px" class="img img-thumbnail border-light" src="'. asset($img_link) .'"/>';
                $full_name = $img.' '.$detail->pr_stagiaire->prenom . " " . $detail->pr_stagiaire->nom;
                return $full_name;
            })
//            ->filterColumn('full_name', function ($query, $keyword) {
//                $query->whereRaw("prenom LIKE ?", ["%$keyword%"])->orWhereRaw("nom LIKE ?", ["%$keyword%"]);
//            })
            ->rawColumns(['full_name','presence'])
            ->make(true);

    }

    public function ExportPdf(Request $request){
        $pointages = Pointage::query()->with('classe');
        if($request->get('classe')){
            $pointages = $pointages->where('classe_id',$request->get('classe'));
        }
        if($request->get('date_debut') && $request->get('date_fin')){
            $pointages = $pointages->whereBetween('date',[$request->get('date_debut'), $request->get('date_fin')]);
        }
        if($request->get('surveillant')){
            $pointages = $pointages->where('sys_user_id',$request->get('surveillant'));
        }
        $mpdf = new Mpdf() ;
        $mpdf->debug = true ;
        $mpdf->SetAuthor(trans('Fiche des eleves'));
        $mpdf->SetTitle(trans('Fiche des eleves'));
        $mpdf->SetSubject(trans('Fiche des eleves'));
        $mpdf->SetFont('Times New Roman', '', 10);
        $mpdf->SetMargins(0, 0, 8, 0);
        $mpdf->showImageErrors = true;
        $mpdf->AddPage('H', 'A4');
        $mpdf->WriteHTML(view( 'pointages.Export.listPointage', [
            'pointages' => $pointages,
            'classe_id'=>$request->get('classe') ,
            'date_debut'=>$request->get('date_debut'),
            'date_fin'=>$request->get('date_fin')

        ])->render());
        $mpdf->SetHTMLFooter(
            '
                 <table style="border: 0; width:100%" cellspacing="0">
                    <tr class="tR">
                        <td style="text-align: left;border: 0px" class="tr">' . trans('Imprimer le ') . '{DATE j-m-Y H:m:s}</td>
                        <td style="text-align: center;border: 0px" class="tr">Page {PAGENO}/{nbpg}</td>
                        <td class="tr" style="text-align: right;border: 0px">' . trans('Fiche de pointage') . '</td>
                    </tr>
                </table>'
        );
        $mpdf->Output();
    }


    public function get($id)
    {
        $pointage = Pointage::findOrFail($id);
        $tablink = $this->link.'/getTab/' . $id;
        $tabs = [
            '<i class="fa fa-info-circle"></i> info' => $tablink . '/1',
        ];

        $modal_title = 'pointage des absnets de la classe ' .'<b>'. $pointage->classe->libelle_fr.'</b>';

        return view('tabs', [
            'tabs' => $tabs,
            'modal_title' => $modal_title,
            'module' => $this->link
        ]);
    }

    public function getTab($id, $tab)
    {
        $pointage = Pointage::find($id);

        switch ($tab) {
            case '1':
                $parametres = [
                    'pointage' => $pointage,
                    'classes' => Classe::all(),
                    'eleves' => $pointage->classe->pr_stagieres,
                    'presences'=>RefPresent::all(),
                ];
                break;
            case '2':
                $parametres = [
                    'pointage' => $pointage,
                    'eleves' => $pointage->classe->pr_stagieres,
                    'presences'=>RefPresent::all(),
                ];
                break;
            default :
                $parametres = [
                    'pointage' => $pointage,
                ];
                break;
        }
        return view($this->view.'.tabs.tab' . $tab, $parametres);
    }

    public function formAdd()
    {
        $classes = Classe::all();
        return view('pointages.add', ['classes' => $classes]);
    }

    public function add(PointageRequest $request)
    {
        $pointages_exists = Pointage::query()->where('classe_id' ,request('classe_id'))
            ->where('date',request('date'))
            ->where('heure',request('time'))->exists();
        if($pointages_exists){
            return response()->json(['time'=>[trans('pointage.pointage_exists')]],422);
        }else{
            $pointages_exist = Pointage::query()->where('classe_id' ,request('classe_id'))->exists();
            if($pointages_exist){
                $pointage = Pointage::query()->where('classe_id' ,request('classe_id'))->latest()->limit(1)->get();
                $pointage_valide = Pointage::findOrFail($pointage[0]->id) ;
                $pointage_valide->ref_etats_pointage_id = 2;
                $pointage_valide->save();
            }

            $pointage = new Pointage();
            $pointage->classe_id = request('classe_id');
            $pointage->sys_user_id = auth()->id();
            $pointage->date = request('date');
            $pointage->heure = request('time');
            $pointage->ref_etats_pointage_id = 1 ;
            $pointage->save();
//            dd($pointage->classe->pr_stagiaires);
            foreach ($pointage->classe->pr_stagiaires as $eleve) {
                $detailsPointage = new DetailsPointage();
                $detailsPointage->pr_stagiaire_id = $eleve->id;
                $detailsPointage->pointage_id = $pointage->id;
                $detailsPointage->ref_etats_presence_id = 1; // present
                $detailsPointage->save();
            }

            return response()->json($pointage->id, 200);
        }
    }

    public function edit(editPointageRequest $request)
    {
        $pointage = Pointage::find(request('idPointage'));
        $pointage->sys_user_id = auth()->id();
        $pointage->date = request('date');
        $pointage->heure = request('time');
        $pointage->save();
        $data=array('date'=>$pointage->date ,'time'=> $pointage->heure);
        return response()->json($data, 200);
    }

    public function addPointageDetails(Request $request, $pointage_id)
    {
        foreach (request('detail_presences') as $detail_presence_id) {
            $detail_pointage = DetailsPointage::findOrFail($detail_presence_id);
            $detail_pointage ->ref_etats_presence_id = $request->input('presence_'.$detail_presence_id);
            $detail_pointage ->save();
        }
    }

    public function exportExcel(Request $request){

         $pointages = Pointage::query()->with('classe');
         if($request->get('classe')){
             $pointages = $pointages->where('classe_id',$request->get('classe'));
         }
         if($request->get('date_debut') && $request->get('date_fin')){
             $pointages = $pointages->whereBetween('date',[$request->get('date_debut'),$request->get('date_fin')]);
         }
         if($request->get('surveillant')){
             $pointages = $pointages->where('personne',$request->get('surveillant'));
         }
        return Excel::download(new PointageExport($pointages),'pointage.xlsx');
     }
    public function delete($id)
    {
        if (auth()->user()->hasAccess(30,5)){
            $pointage = Pointage::find($id);
            $pointage->delete();
            return response()->json([
                'success' => 'true',
                'msg' => trans('text.element_well_deleted')
            ], 200);
        }

    }

//    public function addPresence($persone_id,$presence_id,$pointage_id)
//    {
//        $pointage =Pointage::find($pointage_id);
//        $presnce_deja=$pointage->detailsPointage->firstWhere('Eleves_id',$persone_id);
//        if ($presnce_deja){
//            $pointage_detail=DetailsPointage::find($presnce_deja->id);
//            $pointage_detail->presence_id = $presence_id;
//            $pointage_detail->save();
//        }else{
//            $detailsPointage = new DetailsPointage();
//            $detailsPointage->Eleves_id = $persone_id;
//            $detailsPointage->pointage_id = $pointage->id;
//            $detailsPointage->presence_id = $presence_id;
//            $detailsPointage->save();
//        }
//        return response()->json($pointage->id, 200);
//    }

  public function validerPointage($pointage_id){
        $pointage = Pointage::find($pointage_id) ;
        $pointage->ref_etats_pointage_id = 2 ;
        $pointage->save();
  }
}
