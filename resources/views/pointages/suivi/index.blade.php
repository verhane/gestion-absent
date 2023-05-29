@extends('layouts.admin')
@section('page-content')
    <x-page-header>
    <x-slot name="title">
        suivi presénce des eleves
    </x-slot>
    </x-page-header>
<x-card>

    <x-slot name="heading">

        <div class="row ">
            <div class="col-12" style="position: relative;clear: both
       ">
                <form>
                <x-forms.input
                     label="{{ trans('suivis.recherche')}} " id="nom" name="recherche" placeholder="entrer"

                    onkeyup="getEleve(this.value)"
                     style="padding-left: 35px"
                />

                </form>
                <i class="fa fa-search"style="position: absolute;top: 48%;left:35px"></i>
                <ul class="list-group p-0" style="position: absolute;top: 68px; width: 97%;overflow-y: auto;max-height: 250px ">
                </ul>
            </div>


        </div>

        <form method="POST" id="export_pdf_suivi">
            @csrf
            <input type="hidden" value="" id="eleve_id" name="eleve_id">
    <div class="row my-2 form_periode" style="display: none">
        <div class="col-md-6">
            <x-filtres.element >
                <x-slot name="label">
                    @lang('pointage.date debut')
                </x-slot>
                <x-forms.input
                    type="date"
                    name="date_debut"
                    id="date_debut"
                    class="{{$errors->has('date_debut')}}"
                    onchange="onDateChage()"
                    value="{{date('m-d-Y')}}"
                />

                    <span class="help-block">
                        <strong></strong>
                    </span>

            </x-filtres.element>
        </div>
        <div class="col-md-6 ">
            <x-filtres.element>
                <x-slot name="label">
                    @lang('pointage.date fin')
                </x-slot>
                <x-forms.input
                    type="date"
                    value="{{date('Y-m-d')}}"
                onchange="onDateChage()"
                    name="date_fin" id="date_fin"/>
            </x-filtres.element>
        </div>
    </div>
        <div class="export_pdf" style="display: none">
            @if(auth()->user()->hasAccess(30,4))
            <x-export-container>
                 <x-buttons.btn-export
                     onclick="getExport('export_pdf_suivi', 'pointages/suivis/exportPdf')"
                     link='#!'
                     class="btn-sm btn-primary shadow-sm"
                     icon="file-pdf"
                     id="expotPDF"
                     text="{{ trans('pointage.exportPdf')}}"
                 >

                 </x-buttons.btn-export>
             </x-export-container>
            @endif
        </div>
     </form>
    <div id="cont">

    </div>
    </x-slot>
</x-card>
@endsection

<script>
    function getEleve(val) {
        let valeur = "all";
        if(val != '')
            valeur = val;
        $('.form_periode').hide();
        $('#date_debut').val('');
        $('#date_fin').val('');
        $('.export_pdf').hide();
        if(val.length >= 3){
            getTheContent("pointages/suivis/getEleve/"+valeur ,'.list-group');
            $('.list-group').css('display','block');
        }

    }
    function getDetEleve(eleve_id){
        let dateDebut = $('#date_debut').val();
        let dateFin = $('#date_fin').val();
        let url="pointages/suivis/getDetEleve/"+eleve_id;
        let eleve_input = $('#eleve_id') ;
        eleve_input.val(eleve_id);
        // alert(eleve_input.val());
        if (dateDebut !==undefined){
            url+='/'+dateDebut;
        }
        if (dateFin !==undefined){
            url+='/' + dateFin;
        }
        $.ajax({
            type: "GET",
            url:racine + url,
            success: function(data){
                $("#cont").html(data);

            },
            error: function (request, error) {
                console.log(error);
                // alert(" date fin doit etre superieur ou egale date debut: ");
            }
        })
        // getTheContent(url ,'#cont');
        $('.list-group').css('display','none');
        $('.form_periode').show();
        $('.export_pdf').show();



    }


    function onDateChage() {
        getDetEleve( $('#eleve_id').val())
    }
</script>
