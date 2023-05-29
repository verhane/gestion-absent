<x-card class="bg-light my-2">
    <div class="row">
        <div class="col">
            <p id="classe">Classe:<span id="Classe"><b>{{$pointage->classe->libelle_fr}}</b></span></p>
        </div>
        <div class="col">
            <p id="date">Date: <span ><b id="dates">{{$pointage->date}}</b></span></p>
        </div>
        <div class="col">
            <p id="heure">Heure: <span ><b id="heures">{{$pointage->heure}}</b></span></p>
        </div>
        <div class="col">
            <p id="pointeur">Pointeur: <span id="point"><b>{{$pointage->pointeur->name}}</b></span></p>
        </div>
    </div>
    <div class="row ">
        <div class="col">
{{--       <button class="btn pull-right" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"--}}
{{--               style="background-color: #28d094;color: white;">--}}
            @if($pointage->ref_etats_pointage_id == 1)
                @if(auth()->user()->hasAccess(30,2))
                <a href="#" class="pull-right" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fas fa-edit fa-2x" style="color: #1e293b;"></i>
                </a>
                @endif
            @endif
        </div>
    </div>
</x-card>
<div class="collapse" id="collapseExample">
    <x-card>
        <div id="formEditPointage2" class="p-2">
            <form action="{{ url('pointages/edit') }}" method="POST">
              @csrf
                <div class="row">
                    <div class="col-md-5">
                        <x-forms.input type="date"  value="{{$pointage->date}}"  label="Date" name="date"/>
                    </div>
                    <div class="col-md-5">
                        <x-forms.input type="time"  value="{{$pointage->heure}}"  label="Heure" name="time"/>
                    </div>
                    <div class="col-md-2"style="align-self: center" >
                        @if(auth()->user()->hasAccess(30,2))
                        <x-buttons.btn-save
                            onclick="saveform(this,modifierPointage)"
                            container="formEditPointage2">
                            @lang('text.enregistrer')
                        </x-buttons.btn-save>
                        @endif
                    </div>
                <input type="hidden" name="idPointage" value="{{$pointage->id}}">
                </div>
            </form>
        </div>


     </x-card>
</div>

{{--Details poingtage is down--}}
<div class="col-md-6 " id="formEditPointage3" style="margin-left: auto">
    <form action="{{ url('pointages/validerPointge',[$pointage->id]) }}" method="POST">
        @if($pointage->ref_etats_pointage_id == 1)
            @if(auth()->user()->hasAccess(30,3))
            <x-buttons.btn-save
                onclick="saveform(this)"
                container="formEditPointage3">
                @lang('pointage.valide')
            </x-buttons.btn-save>
            @endif
        @endif
    </form>

</div>
<div id="formEditPointage" class="p-2">
    <form action="{{ url('pointages/addPointageDetails',[$pointage->id]) }}" method="POST">
        <x-table.table
            class="table table-bordered"
            id="datatableshow1"
            link="{{url('pointages/getElevesDT/all',[$pointage->id])}}"
            nbr="100"
            {{-- hiddens="0" --}}
            colonnes="full_name,pr_stagiaire.nni,presence">
            <thead>
            <tr>
                <x-table.th>@lang('pointage.nom')</x-table.th>
                <x-table.th>@lang('pointage.nni')</x-table.th>
                <x-table.th>@lang('pointage.presence')</x-table.th>
            </tr>
            </thead>
        </x-table.table>
        @if($pointage->ref_etats_pointage_id == 1)
            @if(auth()->user()->hasAccess(30,2))
        <x-buttons.btn-save
            onclick="saveform(this)"
            container="formEditPointage">
            @lang('text.enregistrer')
        </x-buttons.btn-save>
            @endif
        @endif
    </form>

</div>


<script>
    // function addPresence(personne_id,presence_id,pointage_id)
    // {
    //     if($('#present_'+presence_id+'_'+personne_id).is(':checked'))
    //     {
    //         var value_presence = $('#present_'+presence_id+'_'+personne_id).val();
    //         $.ajax({
    //             type: 'get',
    //             url: racine +'pointages/addPresence/' + personne_id+'/'+value_presence+'/'+pointage_id,
    //             success: function (data) {
    //                 resetInit();
    //             },
    //             error: function () {
    //                 $.alert('error ');
    //             }
    //         });
    //         return false;
    //     }
    //     return false;
    // }


    function modifierPointage(data)
    {
        let saa = document.querySelector('#dates');
        let heuress = document.querySelector('#heures');
        saa.textContent = data.date ;
        heuress.textContent = data.time ;
        // console.log(dates.textContent  + ' '+heures.textContent);

    }
</script>
