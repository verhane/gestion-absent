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
</style>

<table class="table table-bordered"   id="pointage">
    <thead>
    <tr>
        <th scope="col">#</th>
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
            <td>{{$pointage->id}}</td>
            <td>{{$pointage->classes->libelle_fr}}</td>
            <td>{{$pointage->pointeur->name}}</td>
            <td>{{$pointage->date}}</td>
            <td>{{$pointage->heures}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
