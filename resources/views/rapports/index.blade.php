@extends('layouts.admin')
@section('page-content')
    <x-page-header>
        <x-slot name="title">
            @lang('rapport.rapport')
        </x-slot>
    </x-page-header>
    <x-card>
    <x-filtres.container>
        <x-filtres.element class="col-md-4 mb-3">
            <x-slot name="label">
            @lang('rapport.classe')
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
                @lang('rapport.date debut')
            </x-slot>
            <div class="col">
                <x-forms.input type="date" name="date_debut" id="date_debut"/>
            </div>
        </x-filtres.element>


        <x-filtres.element class="col-md-4 mb-3">
            <x-slot name="label">
               @lang('rapport.date fin')
            </x-slot>
            <div class="col">
                <x-forms.input type="date" onchange="globalFilter()" name="date_fin" id="date_fin"/>
            </div>
        </x-filtres.element>
    </x-filtres.container>

    <x-export-container class="my-2">
        <x-buttons.btn-export
            onclick="globalFilter()"
            link='{{ url("rapports/exportPdf/all") }}'
            class="btn-sm btn-primary shadow-sm my-3"
            icon="file-pdf"
            id="expotPDF"
            text="{{ trans('rapport::maintenance.exporter_pdf')}}"
        >

        </x-buttons.btn-export>
        <x-buttons.btn-export
            onclick="globalFilter()"
            link='{{ url("rapports/exportExcel/all") }}'
            class="btn-sm btn-warning shadow-sm my-3"
            icon="file-excel"
            id="expotExcel"
            text="{{ trans('rapport::rapport.exporter_excel')}}"
        >

        </x-buttons.btn-export>
    </x-export-container>



    <table class="table table-bordered"   id="datatableshow"
           link="{{url('rapports/getDT/all')}}" colonnes="id,pr_stagaire.id,pr_stagaire.nom,pointage.date,nbr_present,nbr_absents,nbr_absents_justifier">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">@lang('rapport.matircule')</th>
            <th scope="col">@lang('rapport.nom')</th>
            <th scope="col">@lang('rapport.date')</th>
            <th scope="col">@lang('rapport.nombre present')</th>
            <th scope="col">@lang('rapport.nombre absent')</th>
            <th scope="col">@lang('rapport.nombre absent justifie')</th>
{{--            <th scope="col">Actions</th>--}}
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
        // console.log(classe +''+dateDebut + '' +dateFin);
        var btnExport = $('#expotPDF');
        var btn_export_excel = $('#expotExcel');
        btn_export_excel.attr('href','{{ url("rapports/exportExcel/") }}/'+classe+'/'+dateDebut+'/'+dateFin);
        btnExport.attr('href','{{ url("rapports/exportPdf/") }}/'+classe+'/'+dateDebut+'/'+dateFin) ;
        $("#datatableshow").DataTable().ajax.url("{{url('rapports/getDT/')}}/"+classe+"/"+dateDebut+"/"+dateFin).load();

    }
</script>
