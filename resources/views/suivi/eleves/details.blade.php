{{--<div class="row my-2">
    <div class="col-md-6">
        <x-filtres.element >
            <x-slot name="label">
                @lang('pointage.date debut')
            </x-slot>
            <x-forms.input
                type="date"
                name="date_debut"
                id="date_debut"
                onchange="getDetEleve({{$eleve->id}})"
                value="{{$date_debut}}"
            />
        </x-filtres.element>
    </div>
    <div class="col-md-6">
        <x-filtres.element>
            <x-slot name="label">
                @lang('pointage.date fin')
            </x-slot>
            <x-forms.input
                type="date" value="{{$date_fin}}"
                onchange="getDetEleve({{$eleve->id}})"
                name="date_fin" id="date_fin"/>
        </x-filtres.element>
    </div>
</div>--}}
<div class="mb-2">Nom : <span class="font-weight-bold">{{$eleve->nom}} {{$eleve->prenom}}</span></div>
    <x-table.table class="table table-bordered" >
        <thead>
        <tr>
            <x-table.th>classe</x-table.th>
            <x-table.th >date</x-table.th>
            <x-table.th >heure</x-table.th>
            <x-table.th >Etat</x-table.th>

        </tr>
        </thead>
        <tbody>
        @foreach($details_eleve as $deteleve)
        <x-table.tr>
            <x-table.td>{{$deteleve->pointage->classes->libelle_fr}}</x-table.td>
            <x-table.td>{{$deteleve->pointage->date}}</x-table.td>
            <x-table.td>{{$deteleve->pointage->heures}}</x-table.td>
            <x-table.td>{{$deteleve->presences->libelle_fr}}</x-table.td>
        </x-table.tr>
        @endforeach
        </tbody>
    </x-table.table>
