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

{{--@include('globales.entete')--}}

<h2>liste de rapprots</h2>
@if($classe != '')
    @php
        $classes= \App\Models\Classe::find($classe);
    @endphp
    <h4>Classe:{{$classes->libelle_fr}}</h4>

@endif
@if($date_debut !='' && $date_fin !='')
    <h4>periode du {{$date_debut}} ou {{$date_fin}} </h4>
@endif
<table class="table table-bordered"   id="pointage">
    <thead>
    <tr>

        <th scope="col">nom</th>
        <th scope="col">nni</th>
        <th>nbre present</th>
        <th>nbre absent</th>
        <th>nbre absent justifier</th>
        {{--        <th scope="col">libelle_fr</th>--}}

    </tr>
    </thead>
    <tbody>
    @foreach($stagaires->get() as $stagaire)
        <tr>
{{--            <td>{{$dpointage->id}}</td>--}}
            <td>{{$stagaire->nom}} {{$stagaire->prenom}}</td>
            <td>{{$stagaire->nni}}</td>
{{--            <td>{{$dpointage->pointage->date}}</td>--}}
            @php
                 $count_present=$stagaire->details_pointages->where('ref_etats_presence_id',1)->count();
                 $count_absent = $stagaire->details_pointages->where('ref_etats_presence_id',2)->count();
                 $count_abs_jus =$stagaire->details_pointages->where('ref_etats_presence_id',3)->count();
            @endphp
            <td>{{$count_present}}</td>
            <td>{{$count_absent}}</td>
            <td>{{$count_abs_jus}}</td>

        </tr>
    @endforeach
    </tbody>
</table>

