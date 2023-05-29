<?php

namespace App\Http\Controllers;

use App\Models\DetailsPointage;
use App\Models\Pointage;
use App\Models\PrStagiaire;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use function GuzzleHttp\Promise\all;
use Validator;
class PointageSuiviController extends Controller
{
    private $view="pointages.suivi";

    public function index()
    {
        return view($this->view.'.index');
    }

    public function getEleve($keyword){
        if($keyword != "all")
        {
            $eleves = PrStagiaire::query()->where(function($query) use ($keyword){
                $query->where('prenom' ,'like', '%' .$keyword. '%')->orWhere('nom' ,'like', '%' .$keyword. '%')->orWhere('nni','like','%' . $keyword. '%');
            })->whereHas('details_pointages')->limit(5)->get();
            return view($this->view.'.eleves.deteleve',['eleves'=>$eleves]);
        }
    }

    function getDetEleve($eleve_id ,$date_debut=null , $date_fin=null){
        $validator = Validator::make(request()->route()->parameters(), [
            'date_debut'=>'sometimes|required|date',
            'date_fin' => 'sometimes|required|date|after_or_equal:date_debut',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->messages()], 422);
        }
        $details_eleves = DetailsPointage::query()->where('pr_stagiaire_id',$eleve_id);
//        dd($details_eleves->get());
        $eleve =PrStagiaire::find($eleve_id);
//        $details_eleves = $eleve->details_pointages;
//        dd($details_eleves);
        if($date_debut && $date_fin){
            $details_eleves = $details_eleves->whereIn('pointage_id',Pointage::query()->whereBetween('date',[$date_debut,$date_fin])->select('id'));
        }
        if($date_debut){
            $details_eleves = $details_eleves->whereIn('pointage_id',Pointage::query()->where('date','>=',$date_debut)->select('id'));
        }
        if($date_fin){
            $details_eleves = $details_eleves->whereIn('pointage_id',Pointage::query()->where('date','<=',$date_fin)->select('id'));
        }
        return view($this->view.'.eleves.details',[
            'details_eleve'=>$details_eleves->get() ,
            'eleve'=>$eleve
            ,'date_debut'=>$date_debut ,
            'date_fin'=>$date_fin
        ]);
    }

    public function ExportPdf(Request $request){
        $detailsPointage = DetailsPointage::query()->with(['pointage','pr_stagiaire'])->where('pr_stagiaire_id',$request->get('eleve_id'));

        if($request->get('date_debut') && $request->get('date_fin')){
            $detailsPointage = $detailsPointage->whereIn('pointage_id',Pointage::query()->whereBetween('date',[$request->get('date_debut'), $request->get('date_fin')])->select('id'));
        }
        if($request->get('date_debut')){
            $detailsPointage = $detailsPointage->whereIn('pointage_id',Pointage::query()->where('date','>=',$request->get('date_debut'))->select('id'));
        }
        $mpdf = new Mpdf() ;
        $mpdf->debug = true ;
        $mpdf->SetAuthor(trans('Fiche de presence'));
        $mpdf->SetTitle(trans('Fiche de presence'));
        $mpdf->SetSubject(trans('Fiche de presence'));
        $mpdf->SetFont('Times New Roman', '', 10);
        $mpdf->SetMargins(0, 0, 8, 0);
        $mpdf->showImageErrors = true;
        $mpdf->AddPage('H', 'A4');
        $mpdf->autoScriptToLang=true;
        $mpdf->WriteHTML(view($this->view.'.export.listPdf', [
            'detailsPointage' => $detailsPointage   ,
            'date_debut'=>$request->get('date_debut'),
            'date_fin'=>$request->get('date_fin'),
            'eleve_id'=>$request->get('eleve_id')

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
}
