@extends('layouts.admin')
@section('page-content')
    <x-page-header>
        <x-slot name="title">
            @lang('rapport.rapport')
        </x-slot>
    </x-page-header>
        <x-card>
            <x-slot name="heading">
                <form method="post" id="rapport_filtres_form">
                    @csrf
                    <x-filtres.container id="filter_rapport">
                        <x-filtres.element class="col-md-4 ">
                          <x-slot name="label">
                                   @lang('rapport.classe')
                          </x-slot>
                            <x-forms.select
                             id="classe"
                              name="classe"
                               onchange="refreshDatatable()"
                                class="form-control select2"
                                   title="@lang('text.selectionnez')"
                                                                     >
                <option selected value="">@lang('text.all')</option>
             @foreach($classes as $classe)
                <option value="{{$classe->id}}">{{$classe->libelle_fr}}</option>
             @endforeach
            </x-forms.select>
        </x-filtres.element>
                      <x-filtres.element class="col-md-4 mb-1">
                        <x-slot name="label">
                           @lang('rapport.date debut')
                        </x-slot>
                       <div class="col">
                       <x-forms.input type="date" onchange="refreshDatatable()" name="date_debut" id="date_debut"/>
                       </div>
                      </x-filtres.element>

                        <x-filtres.element class="col-md-4 mb-1">
                          <x-slot name="label">
                             @lang('rapport.date fin')
                             </x-slot>
                       <div class="col">
                           <x-forms.input type="date" onchange="refreshDatatable()" name="date_fin" id="date_fin"/>
                       </div>
        </x-filtres.element>
    </x-filtres.container>

                    <x-export-container>
        <x-buttons.btn-export
            onclick="getExport('rapport_filtres_form', 'rapports/exportPdf')"
            link='#!'
            class="btn-sm btn-primary shadow-sm my-3"
            icon="file-pdf"
            id="expotPDF"
            text="{{ trans('pointage.exportPdf')}}"
        >

        </x-buttons.btn-export>
        <x-buttons.btn-export
            onclick="getExport('rapport_filtres_form', 'rapports/exportExcel')"
            link='#!'
            class="btn-sm btn-warning shadow-sm my-3"
            icon="file-excel"
            id="expotExcel"
            text="{{ trans('pointage.exportExcel')}}"
        >

        </x-buttons.btn-export>
    </x-export-container>

{{--        ,pointage.date--}}
                </form>
            </x-slot>
    <x-table.table class="table table-bordered"   id="datatableshow"
                   hiddens="0"
                   filtres="filter_rapport"
           link="{{url('rapports/getDT')}}" colonnes="id,pr_stagaire.id,pr_stagaire.nom,pr_stagaire.prenom,nbr_present,nbr_absents,nbr_absents_justifier">
        <thead>
        <tr>
            <x-table.th>#</x-table.th>
            <x-table.th >@lang('rapport.matircule')</x-table.th>
            <x-table.th >@lang('rapport.nom')</x-table.th>
            <x-table.th >@lang('rapport.prenom')</x-table.th>
            <x-table.th >@lang('rapport.nombre present')</x-table.th>
            <x-table.th >@lang('rapport.nombre absent')</x-table.th>
            <x-table.th >@lang('rapport.nombre absent justifie')</x-table.th>
{{--            <th scope="col">Actions</th>--}}
        </tr>
        </thead>
        <tbody>

        </tbody>
    </x-table.table>
</x-card>
@endsection
<script>
    {{--function globalFilter(){--}}
    {{--    var classe = $('#classe').val();--}}
    {{--    var dateDebut = $('#date_debut').val();--}}
    {{--    var dateFin = $('#date_fin').val();--}}
    {{--    // console.log(classe +''+dateDebut + '' +dateFin);--}}
    {{--    var btnExport = $('#expotPDF');--}}
    {{--    var btn_export_excel = $('#expotExcel');--}}
    {{--    btn_export_excel.attr('href','{{ url("rapports/exportExcel/") }}/'+classe+'/'+dateDebut+'/'+dateFin);--}}
    {{--    btnExport.attr('href','{{ url("rapports/exportPdf/") }}/'+classe+'/'+dateDebut+'/'+dateFin) ;--}}
    {{--    $("#datatableshow").DataTable().ajax.url("{{url('rapports/getDT/')}}/"+classe+"/"+dateDebut+"/"+dateFin).load();--}}

    {{--}--}}
</script>
