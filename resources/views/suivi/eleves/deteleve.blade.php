{{--<div class="row">--}}
{{--    <i class="fa fa-user"></i>--}}
{{--    <p class="personne-name">Sidi Mohamed</p>--}}
{{--</div>--}}
{{--<div class="row">--}}
{{--    <i class="fa fa-user"></i>--}}
{{--    <p class="personne-name">Ahmed Mohamed</p>--}}
{{--</div>--}}
{{--<div class="row">--}}
{{--    <i class="fa fa-user"></i>--}}
{{--    <p class="personne-name">Khadi Mohamed</p>--}}
{{--</div>--}}
{{--<div class="row">--}}
{{--    <i class="fa fa-user"></i>--}}
{{--    <p class="personne-name">Fatimetou sidi</p>--}}
{{--</div>--}}

{{--<div class="col-md-12">--}}
{{--    @foreach($eleves as $eleve)--}}
{{--        @php--}}
{{--        $detpointage = $eleve->detailPointag->firstWhere('Eleves_id',$eleve->id);--}}
{{--        @endphp--}}
{{--        @if($detpointage)--}}
{{--        <div >--}}
{{--            Nom : <span class="font-weight-bold">{{$eleve->nom}}</span>--}}
{{--        </div>--}}
{{--    <x-table.table class="table table-bordered" >--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <x-table.th >date</x-table.th>--}}
{{--            <x-table.th >heure</x-table.th>--}}
{{--            <x-table.th >Etat</x-table.th>--}}

{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @foreach($eleve->detailPointag as $deteleve)--}}
{{--        <x-table.tr>--}}
{{--            <x-table.td>{{$deteleve->pointage->date}}</x-table.td>--}}
{{--            <x-table.td>{{$deteleve->pointage->heures}}</x-table.td>--}}
{{--            <x-table.td>{{$deteleve->presences->libelle_fr}}</x-table.td>--}}
{{--        </x-table.tr>--}}
{{--        @endforeach--}}
{{--        </tbody>--}}
{{--    </x-table.table>--}}
{{--        @endif--}}
{{--    @endforeach--}}


@foreach($eleves as $eleve)
    @php
        $detpointage = $eleve->detailPointag->firstWhere('Eleves_id',$eleve->id);
    @endphp
    @if($detpointage)
            <li class="list-group-item" style="cursor:pointer;" onclick="getDetEleve({{$eleve->id}})">
                <i class="fa fa-user-circle text-primary fa-2x" style="vertical-align: middle;padding-right: 10px"></i>
                <span style="font-size:15px">{{$eleve->nom}} {{$eleve->prenom}}</span>
            </li>
    @endif
@endforeach









{{--</div>--}}
