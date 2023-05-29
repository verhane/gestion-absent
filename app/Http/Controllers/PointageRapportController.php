<?php

namespace App\Http\Controllers;

use App\Exports\PointageRapportExport;
use App\Models\DetailsPointage;
use App\Models\PrStagiaire;
use Illuminate\Http\Request;
use  App\Models\Pointage ;
use   App\Models\Classe;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Mpdf\Mpdf;
class PointageRapportController extends Controller
{
    //
    public function index(){
        $detailPointages = DetailsPointage::query();
        $classes = Classe::query()->whereIn('id',Pointage::query()->select('classe_id')->distinct())->get();
        return view('pointages.rapports.index',["details"=>$detailPointages , 'classes'=>$classes]);
    }

//    public function getDT(Request $request,$selected = 'all')
//    {
//
//        $DetailsPointage = DetailsPointage::query()->with(['pointage','pr_stagaire'])->get()->groupBy('Eleves_id');
//
//
//
//        return DataTables::of($DetailsPointage)
//
//            ->addColumn('nbr_present',function ($detailsPointage){
//                    $count_present=DetailsPointage::query()->where('Eleves_id',$detailsPointage->Eleves_id)
//                    ->where('presence_id',1);
//                return $count_present->count();
//            })
//            ->addColumn('nbr_absents',function ($detailsPointage){
//                $count_present=DetailsPointage::query()->where('Eleves_id',$detailsPointage->Eleves_id)
//                ->where('presence_id',2);
//                return $count_present->count();
//            })
//            ->addColumn('nbr_absents_justifier',function ($detailsPointage){
//                $count_present=DetailsPointage::query()->where('Eleves_id',$detailsPointage->Eleves_id)
//                ->where('presence_id',3);
//                return $count_present->count();
//            })->filter(function ($DetailsPointage) use ($request) {
//
//                if($request->get('date_debut') && $request->get('date_fin')){
//                    $DetailsPointage = $DetailsPointage->whereIn('pointage_id',Pointage::query()->whereBetween('date',[$request->get('date_debut'),$request->get('date_fin')])->select('id'));
//                }
//                if($request->get('classe')){
//                    $DetailsPointage = $DetailsPointage->whereIn('pointage_id',Pointage::query()->where('classe_id',$request->get('classe'))->select('id'));
//                }
//                if($request->get('date_debut')){
//                    $DetailsPointage = $DetailsPointage->whereIn('pointage_id',Pointage::query()->where('date','>=',$request->get('date_debut'))->select('id'));
//                }
//                if($request->get('date_fin')){
//                    $DetailsPointage = $DetailsPointage->whereIn('pointage_id',Pointage::query()->where('date','<=',$request->get('date_fin'))->select('id'));
//                }
//            })
//            ->rawColumns(['actions'])
//            ->make(true);
//    }
//
    public function getDT(Request $request,$selected = 'all')
    {
        $stagiaires = PrStagiaire::whereHas('details_pointages')->with('details_pointages')
            ->withCount('details_pointages')->orderBy('details_pointages_count', 'desc');

        if($request->get('classe')){
            $stagiaires = $stagiaires->whereHas('details_pointages', function($query) use($request){
                $query->whereHas('pointage', function($q) use($request){
                    $q->where('classe_id',$request->get('classe'));
                });
            });
        }
        if($request->get('date_debut')){
            $stagiaires = $stagiaires->whereHas('details_pointages', function($query) use($request){
                $query->whereHas('pointage', function($q) use($request){
                    $q->where('date','>=',$request->get('date_debut'));
                });
            });
        }
        if($request->get('date_fin')){
            $stagiaires = $stagiaires->whereHas('details_pointages', function($query) use($request){
                $query->whereHas('pointage', function($q) use($request){
                    $q->where('date','<=',$request->get('date_fin'));
                });
            });
        }
        return DataTables::of($stagiaires)
            ->addColumn('nbr_presents',function ($stagiaire){
                return $stagiaire->details_pointages->where('ref_etats_presence_id', 1)->count();
            })
            ->addColumn('nbr_absents',function ($stagiaire){
                return $stagiaire->details_pointages->where('ref_etats_presence_id', 2)->count();
            })
            ->addColumn('nbr_absents_justifier',function ($stagiaire){
                return $stagiaire->details_pointages->where('ref_etats_presence_id', 3)->count();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }


    public function ExportPdf(Request $request){
        $stagiaires = PrStagiaire::whereHas('details_pointages')->with('details_pointages')
            ->withCount('details_pointages')->orderBy('details_pointages_count', 'desc');

        if($request->get('classe')){
            $stagiaires = $stagiaires->whereHas('details_pointages', function($query) use($request){
                $query->whereHas('pointage', function($q) use($request){
                    $q->where('classe_id',$request->get('classe'));
                });
            });
        }
        if($request->get('date_debut')){
            $stagiaires = $stagiaires->whereHas('details_pointages', function($query) use($request){
                $query->whereHas('pointage', function($q) use($request){
                    $q->where('date','>=',$request->get('date_debut'));
                });
            });
        }
        if($request->get('date_fin')){
            $stagiaires = $stagiaires->whereHas('details_pointages', function($query) use($request){
                $query->whereHas('pointage', function($q) use($request){
                    $q->where('date','<=',$request->get('date_fin'));
                });
            });
        }

        $mpdf = new Mpdf() ;
        $mpdf->debug = true ;
        $mpdf->SetAuthor(trans('Fiche des rapport'));
        $mpdf->SetTitle(trans('Fiche des rapport'));
        $mpdf->SetSubject(trans('Fiche des rapport'));
        $mpdf->SetFont('Times New Roman', '', 10);
        $mpdf->SetMargins(0, 0, 8, 0);
        $mpdf->showImageErrors = true;
        $mpdf->AddPage('H', 'A4');
        $mpdf->autoScriptToLang=true;
        $mpdf->SetHTMLFooter(
            '
                 <table style="border: 0; width:100%" cellspacing="0">
                    <tr class="tR">
                        <td style="text-align: left;border: 0px" class="tr">' . trans('Imprimer le ') . '{DATE j-m-Y H:m:s}</td>
                        <td style="text-align: center;border: 0px" class="tr">Page {PAGENO}/{nbpg}</td>
                        <td class="tr" style="text-align: right;border: 0px">' . trans('Fiche de rapport') . '</td>
                    </tr>
                </table>'
        );
        $mpdf->WriteHTML(view( 'pointages.rapports.export.listPdf', [
            'stagaires' => $stagiaires,
            'classe'=>$request->get('classe'),
            'date_debut'=>$request->get('date_debut'),
            'date_fin'=>$request->get('date_fin')

        ])->render());

        $mpdf->Output();

    }
    public function exportExcel(Request $request){
            $stagiaires = PrStagiaire::whereHas('details_pointages')->with('details_pointages')
            ->withCount('details_pointages')->orderBy('details_pointages_count', 'desc');

        if($request->get('classe')){
            $stagiaires = $stagiaires->whereHas('details_pointages', function($query) use($request){
                $query->whereHas('pointage', function($q) use($request){
                    $q->where('classe_id',$request->get('classe'));
                });
            });
        }
        if($request->get('date_debut')){
            $stagiaires = $stagiaires->whereHas('details_pointages', function($query) use($request){
                $query->whereHas('pointage', function($q) use($request){
                    $q->where('date','>=',$request->get('date_debut'));
                });
            });
        }
        if($request->get('date_fin')){
            $stagiaires = $stagiaires->whereHas('details_pointages', function($query) use($request){
                $query->whereHas('pointage', function($q) use($request){
                    $q->where('date','<=',$request->get('date_fin'));
                });
            });
        }
        return Excel::download(new PointageRapportExport($stagiaires),'rapport.xlsx');
    }
}
