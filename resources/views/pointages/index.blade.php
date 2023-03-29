@extends('layouts.admin')
@section('page-content')
    <x-page-header>
        <x-slot name="title">
           pointage
        </x-slot>
        <x-buttons.btn-add onclick="openFormAddInModal('pointages')">
            add  pointage
        </x-buttons.btn-add>
    </x-page-header>
    <x-filtres.container>
    <x-filtres.element class="col-md-4 mb-2">
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
        <x-filtres.element class="col-md-4 mb-1">
            <x-slot name="label">
                surveillant
            </x-slot>
            <x-forms.select
                id="surveillant"
                name="surveillant"
                onchange="globalFilter()"
                class="form-control select2"
                title="@lang('text.selectionnez')"
            >
                <option selected value="all">@lang('text.all')</option>
                @foreach($surveillant as $surve)
                    <option value="{{$surve->id}}">{{$surve->name}}</option>
                @endforeach

            </x-forms.select>
        </x-filtres.element>
    </x-filtres.container>

    <x-export-container class="my-2">
        <x-buttons.btn-export
            onclick="globalFilter()"
            link='{{ url("pointages/exportPdf/all/all") }}'
            class="btn-sm btn-primary shadow-sm my-3"
            icon="file-pdf"
            id="expotPDF"
            text="{{ trans('pointage::maintenance.exporter_pdf')}}"
        >

        </x-buttons.btn-export>
    </x-export-container>
    <table class="table table-bordered"   id="datatableshow"
           link="{{url('pointages/getDT/all/all')}}" colonnes="id,classes.libelle_fr,pointeur.name,date,heures,actions">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">libelle</th>
            <th scope="col">personne</th>
            <th scope="col">date</th>
            <th scope="col">heures</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
@endsection

<script>
    function globalFilter(){

        var classe = $('#classe').val();
        var dateDebut = $('#date_debut').val();
        var dateFin = $('#date_fin').val();
        var admin = $('#surveillant').val();
        var btnExport = $('#expotPDF');
        btnExport.attr('href','{{ url("pointages/exportPdf/") }}/'+classe+'/'+admin+'/'+dateDebut+'/'+dateFin) ;
        $("#datatableshow").DataTable().ajax.url("{{url('pointages/getDT/')}}/"+classe+"/"+admin+"/"+dateDebut+"/"+dateFin).load();

    }
</script>
