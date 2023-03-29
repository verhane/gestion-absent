<?php

namespace App\Http\Controllers;

use App\Models\ClassesPrStagiaire;
use App\Models\DetailsPointage;
use App\Models\RefPresent;
use Dcs\Admin\Models\SysUser;
use Illuminate\Http\Request;
use  App\Models\Pointage ;
use   App\Models\Classe;
use Yajra\DataTables\Facades\DataTables;
use Mpdf\Mpdf;
class PointageController extends Controller
{
    public function index()
    {
        $pointages = Pointage::all();
        $classes = Classe::all();
        $surveillant = SysUser::query()->whereIn('id',Pointage::query()->select('personne'))->get();
        return view('pointages.index', ['pointages' => $pointages ,'classes'=>$classes,'surveillant'=>$surveillant]);
    }

    public function getDT($classe_id='all' ,$admin='all',$date_debut='all',$date_fin='all' ,$selected = 'all')
    {

        $pointages = Pointage::query()->with('classes')->with('pointeur');
        if($classe_id !='all'){
             $pointages = $pointages->where('classe_id',$classe_id);
        }
        if($date_debut !='all' && $date_fin !='all'){
              $pointages = $pointages->whereBetween('date',[$date_debut, $date_fin]);
        }
        if($admin !='all'){
            $pointages = $pointages->where('personne',$admin);
        }
        return DataTables::of($pointages)
            ->addColumn('actions', function ($pointage) {
                $deleteLink = 'pointages/delete/' . $pointage->id;
                $actions = collect();
                $actions->push([
                    'icon' => 'show',
                    'href' => "#!",
                    'onClick' => "openObjectModal(" . $pointage->id . ",'pointages','#datatableshow','main',1,'xl')",
                    'class' => 'btn-dark btn-sm',
                    'title' => trans('text.visualiser')
                ]);
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
    public function ExportPdf($classe_id='all' ,$admin='all',$date_debut='all',$date_fin='all'){
        $pointages = Pointage::query()->with('classes');
        if($classe_id !='all'){
            $pointages = $pointages->where('classe_id',$classe_id);
//            $classe =Classe::find($classe_id) ;
        }
        if($date_debut !='all' && $date_fin !='all'){
            $pointages = $pointages->whereBetween('date',[$date_debut, $date_fin]);
        }
        if($admin != 'all'){
            $pointages = $pointages->where('personne',$admin);
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
            'pointages' => $pointages

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
        $tablink = 'pointages/getTab/' . $id;
        $tabs = [
            '<i class="fa fa-info-circle"></i> info' => $tablink . '/1',
//            '<i class="fa fa-user"></i> details ' => $tablink . '/2',

        ];

        $modal_title = 'pointeur ' .'<b>'. $pointage->pointeur->name.'</b>';

        return view('tabs', [
            'tabs' => $tabs,
            'modal_title' => $modal_title,
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
                    'eleves' => $pointage->classes->pr_stagieres,
                    'presences'=>RefPresent::all(),
                ];
                break;
            case '2':
                $parametres = [
                    'pointage' => $pointage,
                    'eleves' => $pointage->classes->pr_stagieres,
                    'presences'=>RefPresent::all(),


                ];
                break;
            default :
                $parametres = [
                    'pointage' => $pointage,

                ];
                break;
        }
        return view('pointages.tabs.tab' . $tab, $parametres);
    }

    public function formAdd()
    {
        $classes = Classe::all();
        return view('pointages.add', ['classes' => $classes]);
    }

    public function add(Request $request)
    {

        $this->validate($request, [
             'classe_id' => 'required',
//             'pointeurName' => 'required',
//            'date' => 'required',
             'date'=>'required|after_or_equal:' . date('Y-m-d'),
             'time' => 'required',

        ]);
        $pointage = new Pointage();
        $pointage->classe_id = request('classe_id');
        $pointage->personne = auth()->id();
        $pointage->date = request('date');
        $pointage->heures = request('time');
        $pointage->save();
        return response()->json($pointage->id, 200);
    }

    public function edit(Request $request)
    {
        $pointage = Pointage::find(request('idPointage'));
//        $pointage->classe_id = request('classe_id');
        $pointage->personne = auth()->id();
        $pointage->date = request('date');
        $pointage->heures = request('time');
        $pointage->save();
        return response()->json($pointage->id, 200);
    }

    public function addPointageDetails(Request $request, $pointage_id)
    {
        $pointage =Pointage::find($pointage_id);

        foreach (request('eleve_id') as $key => $e) {
            $eleve_id=$request->input('eleve_id')[$key];
            $presence_id = $request->input('present_'.$eleve_id);
            $presnce_deja=$pointage->detailsPointage->firstWhere('Eleves_id',$eleve_id);

            if($presence_id) {
                 if ($presnce_deja){
                     $pointage_detail=DetailsPointage::find($presnce_deja->id);
                     $pointage_detail->presence_id = $presence_id;
                     $pointage_detail->save();

                 }
                     else{
                         $detailsPointage = new DetailsPointage();
                         $detailsPointage->Eleves_id = $eleve_id;
                         $detailsPointage->pointage_id = $pointage->id;
                         $detailsPointage->presence_id = $presence_id;
                         $detailsPointage->save();
                }

            }
        }
    }

    public function delete($id)
    {
        $pointage = Pointage::find($id);
        $pointage->delete();
        return response()->json([
            'success' => 'true',
            'msg' => trans('text.element_well_deleted')
        ], 200);
    }
}
