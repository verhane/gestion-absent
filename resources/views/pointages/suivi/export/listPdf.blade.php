<style>
    #pointage {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #pointage td, #pointage th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #pointage tr:nth-child(even){background-color: #f2f2f2;}

    #pointage tr:hover {background-color: #ddd;}

    #pointage th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        /*background-color: #04AA6D;*/
        color: black;
    }
    h2 ,h4{
        font-weight: 300    ;
        text-align: center;
    }
</style>

@include('globales.entete')

<h2>suivi de presénce </h2>

@if($date_debut !='' && $date_fin !='')
    <h4>periode du {{$date_debut}} ou {{$date_fin}} </h4>
@endif
@php
$eleve = \App\Models\PrStagiaire::find($eleve_id) ;
$absence_count = \App\Models\DetailsPointage::query()->where('pr_stagiaire_id',$eleve_id)->where('ref_etats_presence_id',2)->count();
$pointage_count = \App\Models\DetailsPointage::query()->where('pr_stagiaire_id',$eleve_id)->count();
$taux_absence =  $absence_count / $pointage_count ;
$taux_absence_format = number_format($taux_absence, 2);
@endphp
<h2 style="text-align: left">Nom:{{$eleve->nom}} {{$eleve->prenom}}</h2>
<h2 style="text-align: left">Taux absence: {{$taux_absence_format}}%</h2>
<table class="table table-bordered"   id="pointage">
    <thead>
    <tr>

        <th>Classe</th>
        <th>Date</th>
        <th>Heure</th>
        <th>Etat</th>

        {{--        <th scope="col">libelle_fr</th>--}}

    </tr>
    </thead>
    <tbody>
    @foreach($detailsPointage->get() as $dpointage)
        <tr>
            <td>{{$dpointage->pointage->classe->libelle_fr}}</td>
            <td>{{$dpointage->pointage->date}}</td>
            <td>{{$dpointage->pointage->heure}}</td>
            <td>{{$dpointage->ref_etats_presence->libelle_fr}}</td>





        </tr>
    @endforeach
    </tbody>
</table>

