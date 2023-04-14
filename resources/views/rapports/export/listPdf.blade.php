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
        <th scope="col">date</th>
        <th>nombre present</th>
        <th>nombre absent</th>
        <th>nombre absent justifier</th>
        {{--        <th scope="col">libelle_fr</th>--}}

    </tr>
    </thead>
    <tbody>
    @foreach($detailsPointage->get() as $dpointage)
        <tr>
{{--            <td>{{$dpointage->id}}</td>--}}
            <td>{{$dpointage->pr_stagaire->nom}} {{$dpointage->pr_stagaire->prenom}}</td>
            <td>{{$dpointage->pr_stagaire->nni}}</td>
            <td>{{$dpointage->pointage->date}}</td>
            @php
                 $count_present=\App\Models\DetailsPointage::query()->where('Eleves_id',$dpointage->Eleves_id)
                    ->where('presence_id',1)->count();
                 $count_absent = \App\Models\DetailsPointage::query()->where('Eleves_id',$dpointage->Eleves_id)
                ->where('presence_id',2)->count();
                 $count_abs_jus =\App\Models\DetailsPointage::query()->where('Eleves_id',$dpointage->Eleves_id)
                ->where('presence_id',3)->count();
            @endphp
            <td>{{$count_present}}</td>
            <td>{{$count_absent}}</td>
            <td>{{$count_abs_jus}}</td>

        </tr>
    @endforeach
    </tbody>
</table>

