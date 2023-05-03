<?php

namespace App\Http\Controllers;

use App\Models\DetailsPointage;
use App\Models\Pointage;
use App\Models\PrStagiaire;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;

class SuiviController extends Controller
{
    private $view="suivi";
    private $link = "suivi";
    public function index()
    {
        return view($this->view.'.index');
    }
    public function getEleve($nom){


        $eleves = PrStagiaire::query()->orWhere('nom' ,'like', '%' .$nom. '%',)->orWhere('id','like','%' . $nom. '%')->whereIn('id',DetailsPointage::query()->select('Eleves_id'))->get();
        $det_eleves = DetailsPointage::query()->whereIn('Eleves_id' ,PrStagiaire::query()->orWhere('nom' ,'like', '%' . $nom. '%',)->orWhere('id','like','%' . $nom. '%')->select('id'))->get();
        $search_details = DetailsPointage::query()->whereHas('pr_stagaire',function($q)use($nom){
            $q->Where('nom' ,'like', '%' .$nom. '%');
        })->limit(5)->get()
        ;
//        dd($det_eleves);
//        if (empty($det_eleves[0])){
//            return "hello world ";
//        }
//         \   dd($search);

            return view($this->view.'.eleves.deteleve',['deteleves'=>$det_eleves,'eleves'=>$eleves]);

//        }


    }
    function getDetEleve($eleve_id ,$date_debut=null , $date_fin=null){
//        dd($eleve_id, $date_fin ,$date_debut);
      /*  \Validator::make(request()->route()->parameters(),[
            'date_debut'=>'sometimes|required|date',
            'date_fin' => 'sometimes|required|date|after_or_equal:date_debut',
        ])->validate();*/
        $details_eleves = DetailsPointage::query()->where('Eleves_id',$eleve_id);
        $eleve =PrStagiaire::find($eleve_id);
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
            'details_eleve'=>$details_eleves->get() ,'eleve'=>$eleve
            ,'date_debut'=>$date_debut ,
            'date_fin'=>$date_fin
        ]);
    }
}
