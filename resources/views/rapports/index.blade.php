@extends('layouts.admin')
@section('page-content')
    <x-page-header>
        <x-slot name="title">
            rapport
        </x-slot>
    </x-page-header>
    <x-filtres.container>
        <x-filtres.element class="col-md-4 mb-3">
            <x-slot name="label">
                classe
            </x-slot>
            <x-forms.select
                id="classe"
                name="classe"
                onchange="globalFilter()"
                class="form-control select2"
                title="@lang('text.selectionnez')"
            >
                <option selected value="all">@lang('text.all')</option>
             @foreach($classes as $classe)
                <option value="{{$classe->id}}">{{$classe->libelle_fr}}</option>
             @endforeach
            </x-forms.select>
        </x-filtres.element>
        <x-filtres.element class="col-md-4 mb-3">
            <x-slot name="label">
                date debut
            </x-slot>
            <div class="col">
                <x-forms.input type="date" name="date_debut" id="date_debut"/>
            </div>
        </x-filtres.element>


        <x-filtres.element class="col-md-4 mb-3">
            <x-slot name="label">
                date fin
            </x-slot>
            <div class="col">
                <x-forms.input type="date" onchange="globalFilter()" name="date_fin" id="date_fin"/>
            </div>
        </x-filtres.element>
    </x-filtres.container>
<x-card>
    <table class="table table-bordered"   id="datatableshow"
           link="{{url('rapports/getDT/all')}}" colonnes="id,pr_stagaire.id,pr_stagaire.nom,pointage.date,nbr_present,nbr_absents,nbr_absents_justifier,actions">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">matricule</th>
            <th scope="col">nom</th>
            <th scope="col">date</th>
            <th scope="col">nombre present</th>
            <th scope="col">nombre absent</th>
            <th scope="col">nombre absent justifie</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</x-card>
@endsection
<script>
    function globalFilter(){

        var classe = $('#classe').val();
        var dateDebut = $('#date_debut').val();
        var dateFin = $('#date_fin').val();
        console.log(classe +''+dateDebut + '' +dateFin);
        // var btnExport = $('#expotPDF');
        {{--btnExport.attr('href','{{ url("pointages/exportPdf/") }}/'+classe+'/'+admin+'/'+dateDebut+'/'+dateFin) ;--}}
        $("#datatableshow").DataTable().ajax.url("{{url('rapports/getDT/')}}/"+classe+"/"+dateDebut+"/"+dateFin).load();

    }
</script>
