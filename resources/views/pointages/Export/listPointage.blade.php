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
    .tete{
        text-align: center ;
    }
    h2,h4{
        font-weight: 300;
    }
</style>
<div class="tete">

 <h2>liste de poiontages</h2>
@if($classe_id != '')
    @php
        $classe= \App\Models\Classe::find($classe_id);
    @endphp
      <h4>Classe:{{$classe->libelle_fr}}</h4>

@endif
    @if($date_debut !='' && $date_fin !='')
        <h4>periode du {{$date_debut}} ou {{$date_fin}} </h4>
    @endif
</div>
<table class="table table-bordered"   id="pointage">
    <thead>
    <tr>
{{--        <th scope="col">#</th>--}}
         @if($classe_id == '')
            <th scope="col">Classe</th>
         @endif


        <th scope="col">Pointeur</th>
        <th scope="col">Date</th>
        <th scope="col">Heure</th>
        {{--        <th scope="col">libelle_fr</th>--}}

    </tr>
    </thead>
    <tbody>
    @foreach($pointages->get() as $pointage)
        <tr>
{{--            <td>{{$pointage->id}}</td>--}}
            @if($classe_id == '')
            <td>{{$pointage->classe->libelle_fr}}</td>
            @endif
            <td>{{$pointage->pointeur->name}}</td>
            <td>{{$pointage->date}}</td>
            <td>{{$pointage->heure}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
