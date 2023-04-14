@extends('layouts.admin')
@section('page-content')
    <x-page-header>
        <x-slot name="title">
          @lang('pointage.pointage')
        </x-slot>
        <x-buttons.btn-add onclick="openFormAddInModal('pointages')">
          @lang('pointage.ajouter pointages')
        </x-buttons.btn-add>
    </x-page-header>
    <x-card>
        <x-slot name="heading">
            <form method="post" id="pointages_filtres_form">
                    @csrf
               <x-filtres.container id="filtre_pointages">

    <x-filtres.element class="col-md-4 ">
        <x-slot name="label">
           @lang('pointage.classe')
        </x-slot>
        <x-forms.select
            id="classe"
            name="classe"
{{--            onchange="globalFilter()"--}}
            onchange="refreshDatatable()"
            class="select2"
            title="@lang('text.selectionnez')"
        >
            <option value="">@lang('text.all')</option>
            @foreach($classes as $classe)
                <option value="{{$classe->id}}">{{$classe->libelle_fr}}</option>
            @endforeach

        </x-forms.select>
    </x-filtres.element>

    <x-filtres.element class="col-md-4">
        <x-slot name="label">
           @lang('pointage.date debut')
        </x-slot>
            <x-forms.input
                type="date"
                name="date_debut"
                id="date_debut"/>
    </x-filtres.element>

    <x-filtres.element class="col-md-4 ">
        <x-slot name="label">
          @lang('pointage.date fin')
        </x-slot>
            <x-forms.input type="date"  onchange="refreshDatatable()" name="date_fin" id="date_fin"/>
    </x-filtres.element>
        <x-filtres.element class="col-md-4 ">
            <x-slot name="label">
                @lang('pointage.surveillant')
            </x-slot>
            <x-forms.select
                id="surveillant"
                name="surveillant"
                onchange="refreshDatatable()"
                class="select2"
                title="@lang('text.selectionnez')"
            >
                <option value="">@lang('text.all')</option>
                @foreach($surveillant as $surve)
                    <option value="{{$surve->id}}">{{$surve->name}}</option>
                @endforeach

            </x-forms.select>
        </x-filtres.element>

    </x-filtres.container>
{{--            </form>--}}
{{--            <form method="post" id="p   ointages_filtres_form">--}}
                <x-export-container>
                @csrf
                <div class="col-md-12 text-right">
                <x-buttons.btn-export
                    onclick="getExport('pointages_filtres_form', 'pointages/exportPdf')"
{{--                    onclick="globalFilter()"--}}
                    link='#!'
                    class="btn-sm btn-primary shadow-sm my-1"
                    icon="file-pdf"
                    id="expotPDF"
                    text="{{ trans('pointage.exportPdf')}}"
                >
                </x-buttons.btn-export>

                <x-buttons.btn-export
                    onclick="getExport('pointages_filtres_form', 'pointages/exportExcel')"
                    link='#!'
                    class="btn-sm btn-warning shadow-sm my-1"
                    icon="file-excel"
                    id="expotExcel"
                    text="{{ trans('pointage.exportExcel')}}"
                >

                </x-buttons.btn-export>
                </div>


    </x-export-container>
            </form>
        </x-slot>
        <div class="col-md-12">
            <x-table.table class="table table-bordered" id="datatableshow"
                           link="{{url('pointages/getDT')}}"
                           hiddens="0"
                           filtres="filtre_pointages"
                           colonnes="id,classes.libelle_fr,pointeur.name,date,heures,actions">
        <thead>
        <tr>
            <x-table.th >#</x-table.th>
            <x-table.th >@lang('pointage.libelle')</x-table.th>
            <x-table.th>@lang('pointage.personne')</x-table.th>
            <x-table.th>@lang('pointage.date')</x-table.th>
            <x-table.th>@lang('pointage.heures')</x-table.th>
            <x-table.th>@lang('text.actions')</x-table.th>
        </tr>
        </thead>
        <tbody>

        </tbody>
            </x-table.table>
        </div>
    </x-card>
@endsection

<script>
    {{--function globalFilter(){--}}

    {{--    var classe = $('#classe').val();--}}
    {{--    var dateDebut = $('#date_debut').val();--}}
    {{--    var dateFin = $('#date_fin').val();--}}
    {{--    var admin = $('#surveillant').val();--}}
    {{--    var btnExport_pdf = $('#expotPDF');--}}
    {{--    var btn_export_excel = $('#expotExcel');--}}
    {{--    btnExport_pdf.attr('href','{{ url("pointages/exportPdf/") }}/'+classe+'/'+admin+'/'+dateDebut+'/'+dateFin) ;--}}
    {{--    btn_export_excel.attr('href','{{ url("pointages/exportExcel/") }}/'+classe+'/'+admin+'/'+dateDebut+'/'+dateFin) ;--}}

    {{--    $("#datatableshow").DataTable().ajax.url("{{url('pointages/getDT/')}}/"+classe+"/"+admin+"/"+dateDebut+"/"+dateFin).load();--}}

    {{--}--}}
</script>
