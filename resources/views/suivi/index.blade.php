@extends('layouts.admin')
@section('page-content')
<x-card>
    <x-slot name="title">
       suivi presénce des eleves
    </x-slot>

        <div class="row ">
            <div class="col-6 ml-auto" style="position: relative">
                <form>
                <x-forms.input
                     label="recherche " id="nom" name="recherche" placeholder="entrer"
                    onchange="getEleve(this.value)"
                />

                </form>
{{--                <i class="fa fa-search"style="position: absolute;top: 48%;left: 7%"></i>--}}
                <ul class="list-group p-0" style="position: relative;top: -23px">
                </ul>
            </div>


        </div>
<input type="hidden" value="" id="eleve_id">
    <div class="row my-2 filter_date">
        <div class="col-md-6">
            <x-filtres.element >
                <x-slot name="label">
                    @lang('pointage.date debut')
                </x-slot>
                <x-forms.input
                    type="date"
                    name="date_debut"
                    id="date_debut"
                    onchange="onDateChage()"
{{--                    value="{{$date_debut}}"--}}
                />
            </x-filtres.element>
        </div>
        <div class="col-md-6">
            <x-filtres.element>
                <x-slot name="label">
                    @lang('pointage.date fin')
                </x-slot>
                <x-forms.input
                    type="date"
{{--                    value="{{$date_fin}}"--}}
                onchange="onDateChage()"
                    name="date_fin" id="date_fin"/>
            </x-filtres.element>
        </div>
    </div>

    <div id="cont">

    </div>
</x-card>
@endsection

<script>
    function getEleve(val) {

        getTheContent("suivis/getEleve/"+val ,'.list-group')
        // console.log(typeof(nom));
        // $.ajax({
        //     type: "GET",
        //     url:racine+ "suivis/getEleve/"+nom,
        //     success: function(data){
        //         $("#cont").html(data);
        //         console.log(data)
        //     }
        // })
        $('.list-group').css('display','block');
        $('#date_debut').val('')
        $('#date_fin').val('')
        $('.filter_date').css('display','none')
    }
    function getDetEleve(eleve_id){
        let dateDebut = $('#date_debut').val();
        let dateFin = $('#date_fin').val();
        let url="suivis/getDetEleve/"+eleve_id;
        let eleve_input = $('#eleve_id') ;
        eleve_input.val(eleve_id);
        // alert(eleve_input.val());

   if (dateDebut !==undefined){
      url+='/'+dateDebut;
   }
        if (dateFin !==undefined){
            url+='/' + dateFin;
        }

        getTheContent(url ,'#cont');
        $('.list-group').css('display','none');



    }


    function onDateChage() {
        getDetEleve( $('#eleve_id').val())
    }
</script>
