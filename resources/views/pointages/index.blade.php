@extends('layouts.admin')
@section('page-content')
    <x-page-header>
        <x-slot name="title">
          @lang('pointage.pointage')
        </x-slot>
        <x-buttons.btn-add onclick="openFormAddInModal('pointages')">
            add  pointage
        </x-buttons.btn-add>
    </x-page-header>
    <x-card>
        <x-slot name="heading">
            <form method="post" id="filterPointage">
                @csrf
    <x-filtres.container>

    <x-filtres.element class="col-md-4 ">
        <x-slot name="label">
           @lang('pointage.classe')
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

    <x-filtres.element class="col-md-4">
        <x-slot name="label">
           @lang('pointage.date debut')
        </x-slot>
        <div class="col">
            <x-forms.input type="date" name="date_debut" id="date_debut"/>
        </div>
    </x-filtres.element>


    <x-filtres.element class="col-md-4 ">
        <x-slot name="label">
          @lang('pointage.date fin')
        </x-slot>
        <div class="col">
            <x-forms.input type="date" onchange="globalFilter()" name="date_fin" id="date_fin"/>
        </div>
    </x-filtres.element>
        <x-filtres.element class="col-md-4 ">
            <x-slot name="label">
                @lang('pointage.surveillant')
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
            </form>
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
        <x-buttons.btn-export
            onclick="globalFilter()"
            link='{{ url("pointages/exportExcel/all/all") }}'
            class="btn-sm btn-warning shadow-sm my-3"
            icon="file-excel"
            id="expotExcel"
            text="{{ trans('pointage::pointage.exporter_excel')}}"
        >

        </x-buttons.btn-export>
    </x-export-container>

        </x-slot>
        <div class="col-md-12">
    <table class="table table-bordered"   id="datatableshow"
           link="{{url('pointages/getDT/all/all')}}" colonnes="id,classes.libelle_fr,pointeur.name,date,heures,actions">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">@lang('pointage.libelle')</th>
            <th scope="col">@lang('pointage.personne')</th>
            <th scope="col">@lang('pointage.date')</th>
            <th scope="col">@lang('pointage.heures')</th>
            <th scope="col">@lang('text.actions')</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
        </div>
    </x-card>
@endsection

<script>
    function globalFilter(){

        var classe = $('#classe').val();
        var dateDebut = $('#date_debut').val();
        var dateFin = $('#date_fin').val();
        var admin = $('#surveillant').val();
        var btnExport_pdf = $('#expotPDF');
        var btn_export_excel = $('#expotExcel');
        btnExport_pdf.attr('href','{{ url("pointages/exportPdf/") }}/'+classe+'/'+admin+'/'+dateDebut+'/'+dateFin) ;
        btn_export_excel.attr('href','{{ url("pointages/exportExcel/") }}/'+classe+'/'+admin+'/'+dateDebut+'/'+dateFin) ;

        $("#datatableshow").DataTable().ajax.url("{{url('pointages/getDT/')}}/"+classe+"/"+admin+"/"+dateDebut+"/"+dateFin).load();

    }
</script>
