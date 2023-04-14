<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>


<table class="table table-bordered"   id="pointage">
    <thead>
    <tr>
{{--        <th scope="col">#</th>--}}
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
    @foreach($detailspointages->get() as $dpointage)
        <tr>
{{--            <td>{{$dpointage->id}}</td>--}}
            <td>{{$dpointage->pr_stagaire->nom}}</td>
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


</body>
</html>
