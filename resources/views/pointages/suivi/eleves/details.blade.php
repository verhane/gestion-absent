
<div class="mb-2">Nom : <span class="font-weight-bold">{{$eleve->nom}} {{$eleve->prenom}}</span></div>
    <x-table.table class="table table-bordered" >
        <thead>
        <tr>
            <x-table.th>@lang('suivis.classe')</x-table.th>
            <x-table.th >@lang('suivis.date')</x-table.th>
                <x-table.th >@lang('suivis.heure')</x-table.th>
            <x-table.th >@lang('suivis.etat')</x-table.th>

        </tr>
        </thead>
        <tbody>
        @php
//        dd($details_eleve)
        @endphp
        @foreach($details_eleve as $detail_eleve)
        <x-table.tr>

                <x-table.td>{{$detail_eleve->pointage->classe->libelle_fr}}</x-table.td>

            <x-table.td>{{$detail_eleve->pointage->date}}</x-table.td>
            <x-table.td>{{$detail_eleve->pointage->heure}}</x-table.td>

            <x-table.td>{{$detail_eleve->ref_etats_presence->libelle_fr}}</x-table.td>
        </x-table.tr>
        @endforeach
        </tbody>
    </x-table.table>
