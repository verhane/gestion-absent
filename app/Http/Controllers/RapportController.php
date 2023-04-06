<?php

namespace App\Http\Controllers;

use App\Exports\RapportExport;
use App\Models\DetailsPointage;
use Illuminate\Http\Request;
use  App\Models\Pointage ;
use   App\Models\Classe;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Mpdf\Mpdf;
class RapportController extends Controller
{
    //
    public function index(){
        $detailPointages = DetailsPointage::query();
        $classes = Classe::query()->whereIn('id',Pointage::query()->select('classe_id')->distinct())->get();
        return view('rapports.index',["details"=>$detailPointages , 'classes'=>$classes]);
    }

    public function getDT($classe_id='all' ,$date_debut='all',$date_fin='all' ,$selected = 'all')
    {

        $DetailsPointage = DetailsPointage::query()->with(['pointage','pr_stagaire'])->groupBy('Eleves_id');
        if($classe_id !='all'){
            $DetailsPointage = $DetailsPointage->whereIn('pointage_id',Pointage::query()->where('classe_id',$classe_id)->select('id'));
        }
        if($date_debut !='all' && $date_fin !='all'){
            $DetailsPointage = $DetailsPointage->whereIn('pointage_id',Pointage::query()->whereBetween('date',[$date_debut, $date_fin])->select('id'));
        }

        return DataTables::of($DetailsPointage)
//            ->addColumn('actions', function ($dpointage) {
//                $deleteLink = 'rapports/delete/' . $dpointage->id;
//                $actions = collect();
//                $actions->push([
//                    'icon' => 'show',
//                    'href' => "#!",
//                    'onClick' => "openObjectModal(" . $dpointage->id . ",'rapports','#datatableshow','main',1,'xl')",
//                    'class' => 'btn-dark btn-sm',
//                    'title' => trans('text.visualiser')
//                ]);
//                $actions->push([
//                    'icon' => 'delete',
//                    'title' => 'Delete',
//                    'href' => "#!",
//                    'onClick' => "confirmAndRefreshDT('" . url($deleteLink) . "','Are you sure you want to delete this item?')",
//                    'class' => 'btn-warning btn-sm',
//                ]);
//                return view('actions-btn', ["actions" => $actions])->render();
//            })
            ->addColumn('nbr_present',function ($detailsPointage){
                    $count_present=DetailsPointage::query()->where('Eleves_id',$detailsPointage->Eleves_id)
                    ->where('presence_id',1);
                return $count_present->count();
            })
            ->addColumn('nbr_absents',function ($detailsPointage){
                $count_present=DetailsPointage::query()->where('Eleves_id',$detailsPointage->Eleves_id)
                ->where('presence_id',2);
                return $count_present->count();
            })
            ->addColumn('nbr_absents_justifier',function ($detailsPointage){
                $count_present=DetailsPointage::query()->where('Eleves_id',$detailsPointage->Eleves_id)
                ->where('presence_id',3);
                return $count_present->count();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    public function ExportPdf($classe_id='all' , $date_debut='all' , $date_fin='all'){
            $detailsPointage = DetailsPointage::query()->with(['pointage','pr_stagaire'])->groupBy('Eleves_id');
        if($classe_id !='all'){
            $detailsPointage = $detailsPointage->whereIn('pointage_id',Pointage::query()->where('classe_id',$classe_id)->select('id'));
        }
        if($date_debut !='all' && $date_fin !='all'){
            $detailsPointage = $detailsPointage->whereIn('pointage_id',Pointage::query()->whereBetween('date',[$date_debut, $date_fin])->select('id'));
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
        $mpdf->WriteHTML(view( 'rapports.export.listPdf', [
            'detailsPointage' => $detailsPointage

        ])->render());
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
        $mpdf->Output();

    }
    public function exportExcel($classe_id='all' ,$date_debut='all' ,$date_fin='all'){
        $detailsPointage = DetailsPointage::query()->with(['pointage','pr_stagaire'])->groupBy('Eleves_id');
        if($classe_id !='all'){
            $detailsPointage = $detailsPointage->whereIn('pointage_id',Pointage::query()->where('classe_id',$classe_id)->select('id'));
        }
        if($date_debut !='all' && $date_fin !='all'){
            $detailsPointage = $detailsPointage->whereIn('pointage_id',Pointage::query()->whereBetween('date',[$date_debut, $date_fin])->select('id'));
        }
        return Excel::download(new RapportExport($detailsPointage),'rapport.xlsx');
    }
}
