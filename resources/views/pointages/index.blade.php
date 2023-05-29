@extends('layouts.admin')
@section('page-content')
    <x-page-header>
        <x-slot name="title">
          @lang('pointage.pointage')
        </x-slot>
        @if(auth()->user()->hasAccess(30,2))
            <x-buttons.btn-add onclick="openFormAddInModal('pointages')">
                @lang('pointage.ajouter pointages')
            </x-buttons.btn-add>
        @endif

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
                            id="date_debut"
                            onchange="getDateFinValideRefreshDt()"

                        />
                    </x-filtres.element>
                    <x-filtres.element class="col-md-4 ">
                        <x-slot name="label">
                          @lang('pointage.date fin')
                        </x-slot>
                        <x-forms.input type="date"  onchange="getDateFinValideRefreshDt()" name="date_fin" id="date_fin"/>
                        <span style="display: none ;color: red" class="warning"> date fin doit etre superieur ou egale date debut</span>
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
                            @foreach($surveillants as $surveillant)
                                <option value="{{$surveillant->id}}">{{$surveillant->name}}</option>
                            @endforeach

                        </x-forms.select>
                    </x-filtres.element>
                </x-filtres.container>
                @if(auth()->user()->hasaccess(30,4))
                <x-export-container>
                    <div class="col-md-12 text-right">
                        <x-buttons.btn-export
                            onclick="getExport('pointages_filtres_form', 'pointages/exportPdf')"
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
                @endif
            </form>
        </x-slot>
        <div class="col-md-12">
            <x-table.table class="table table-bordered" id="datatableshow"
                           link="{{url('pointages/getDT')}}"
                           hiddens="0"
                           filtres="filtre_pointages"
                           colonnes="id,classe.libelle_fr,pointeur.name,date,heure,actions">
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

    function getDateFinValideRefreshDt(){

         var date_debut = new Date($('#date_debut').val());
         var date_fin = new Date($('#date_fin').val());
;
        if($('#date_fin').val() && $('#date_debut').val()){

           if(date_debut<= date_fin){
               refreshDatatable();
               $('.warning').hide();
           }else{
            $('.warning').show();
           }
        }else{

            refreshDatatable();
        }
    }
</script>
