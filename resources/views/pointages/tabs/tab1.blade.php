<div id="formEditPointage" class="p-2">
    <form action="{{ url('pointages/edit') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col">
                {{--                    <x-forms.input  field-required label="classe" name="classe_name"/>--}}

                <x-forms.select
                    id="classe"
                    name="classe_id"
                    class="form-control select2"
                    title="@lang('text.selectionnez')"
                    label="classe"
                    field-required
                >
                    {{--                        <option selected value="all">@lang('text.all')</option> --}}
                    @foreach($classes as $classe)
                        <option @if($pointage->classe_id==$classe->id) selected @endif
                       disabled value="{{$classe->id}}">{{$classe->libelle_fr}}</option>
                    @endforeach

                </x-forms.select>
            </div>
            <div class="col">
                <x-forms.input type="date"  value="{{$pointage->date}}"  label="date" name="date"/>
            </div>
            <div class="col">
                <x-forms.input type="time"  value="{{$pointage->heures}}"  label="heure" name="time"/>
            </div>
            <div class="col">
                <x-forms.input type="text" disabled value="{{ $pointage->pointeur->name}}"  label="pointeur" name="pointeurName"/>
            </div>
            <input type="hidden" name="idPointage" value="{{$pointage->id}}">

        </div>
    </form>
    <x-buttons.btn-save
        onclick="saveform(this)"
        container="formEditPointage">
       @lang('text.enregistrer')
    </x-buttons.btn-save>

</div>



{{--Details poingtage is down--}}

<div id="formEditPointage" class="p-2">
    <form action="{{ url('pointages/addPointageDetails',[$pointage->id]) }}" method="POST">
        <table class="table table-bordered" id="datatableshow">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">nni</th>
                <th scope="col">present</th>
                <th scope="col">absent</th>
                <th scope="col">absente justifier</th>
            </tr>
            </thead>

            <tbody>

            @foreach($eleves as $eleve)
                <tr>
{{--                               <td >{{$eleve->matricule}}</td>--}}
                    <td>{{$eleve->id}}</td>
                    <td>{{$eleve->nom}} {{$eleve->prenom}}</td>
                    <td>{{$eleve->nni}}</td>
                    <input type="hidden" name="eleve_id[]" value="{{$eleve->id}}">
                    @php
                        $value_present=$pointage->detailsPointage->firstWhere('Eleves_id',$eleve->id)?$pointage->detailsPointage->firstWhere('Eleves_id',$eleve->id)->presence_id:null;
                        $checked=$pointage->detailsPointage->firstWhere('Eleves_id',$eleve->id)?'checked':'';

                    @endphp
                    @foreach($presences as $presence)
                        <td>
                            <input
                                name="present_{{$eleve->id}}"
                                value="{{$presence->id}}"
                                type="radio"
                                @if($value_present==$presence->id) checked @elseif($presence->id=='1') checked  @endif
                            /></td>
                    @endforeach

                </tr>
            @endforeach

            </tbody>

        </table>

    </form>
    <x-buttons.btn-save
        onclick="saveform(this)"
        container="formEditPointage">
        @lang('text.enregistrer')
    </x-buttons.btn-save>
</div>
