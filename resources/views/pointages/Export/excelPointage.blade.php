<table class="table table-bordered"   id="pointage">
    <thead>
    <tr>
        <th scope="col">classe</th>
        <th scope="col">personne</th>
        <th scope="col">date</th>
        <th scope="col">heures</th>
        {{--        <th scope="col">libelle_fr</th>--}}

    </tr>
    </thead>
    <tbody>
    @foreach($pointages->get() as $pointage)
        <tr>
{{--            <td>{{$pointage->id}}</td>--}}
            <td>{{$pointage->classe->libelle_fr}}</td>
            <td>{{$pointage->pointeur->name}}</td>
            <td>{{$pointage->date}}</td>
            <td>{{$pointage->heure}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

