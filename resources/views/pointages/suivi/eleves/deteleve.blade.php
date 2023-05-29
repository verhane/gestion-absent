


{{--@foreach($eleves as $eleve)--}}
{{--            <li class="list-group-item" style="cursor:pointer;" onclick="getDetEleve({{$eleve->id}})">--}}
{{--                <i class="fa fa-user-circle text-primary fa-2x" style="vertical-align: middle;padding-right: 10px"></i>--}}
{{--                <span style="font-size:15px">{{$eleve->nom}} {{$eleve->prenom}}</span>--}}
{{--            </li>--}}
{{--    @endif--}}
{{--@endforeach--}}
@forelse($eleves as $eleve)
    <li class="list-group-item" style="cursor:pointer;" onclick="getDetEleve({{$eleve->id}})">
        <i class="fa fa-user-circle text-primary fa-2x" style="vertical-align: middle;padding-right: 10px"></i>
        <span style="font-size:15px">{{$eleve->nom}} {{$eleve->prenom}}</span>
    </li>
@empty
    <li class="list-group-item">
        <span style="font-size:15px">Aucun resultat</span>
    </li>
@endforelse









{{--</div>--}}
