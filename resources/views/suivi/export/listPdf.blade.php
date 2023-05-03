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
        background-color: #04AA6D;
        color: white;
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
@endphp
<h2 style="text-align: left">Nom:{{$eleve->nom}} {{$eleve->prenom}}</h2>
<table class="table table-bordered"   id="pointage">
    <thead>
    <tr>


        <th>Date</th>
        <th>Heure</th>
        <th>Etat</th>

        {{--        <th scope="col">libelle_fr</th>--}}

    </tr>
    </thead>
    <tbody>
    @foreach($detailsPointage->get() as $dpointage)
        <tr>
            {{--            <td>{{$dpointage->id}}</td>--}}
            <td>{{$dpointage->pointage->date}}</td>
            <td>{{$dpointage->pointage->heures}}</td>
            <td>{{$dpointage->presences->libelle_fr}}</td>





        </tr>
    @endforeach
    </tbody>
</table>

