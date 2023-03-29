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
                    {{--           <td >{{$eleve->matricule}}</td>--}}
                    <td>{{$eleve->id}}</td>
                    <td>{{$eleve->nom}} {{$eleve->prenom}}</td>
                    <td>{{$eleve->nni}}</td>
                    <input type="hidden" name="eleve_id[]" value="{{$eleve->id}}">
                    @php
                        $value_present=$pointage->detailsPointage->firstWhere('Eleves_id',$eleve->id)?$pointage->detailsPointage->firstWhere('Eleves_id',$eleve->id)->presence_id:null;
                        $checked=$pointage->detailsPointage->firstWhere('Eleves_id',$eleve->id)?'checked':'';

                    @endphp
{{--                    @dump($value_present,$checked)--}}
{{--                    @foreach($presences as $presence)--}}
{{--                        <td>--}}
{{--                            <input--}}
{{--                                name="present_{{$eleve->id}}"--}}
{{--                                value="{{$presence->id}}"--}}
{{--                                type="radio"--}}
{{--                                @if($value_present==$presence->id) checked  @endif--}}
{{--                            /></td>--}}
{{--                    @endforeach--}}
                    @if($value_present=='1')
                        <td>
                        <input name="present_{{$eleve->id}}" value="1" type="radio" checked />
                        </td>
                         <td>
                        <input name="present_{{$eleve->id}}" value="2" type="radio" />
                         </td>
                        <td>
                        <input name="present_{{$eleve->id}}" value="3" type="radio" />
                        </td>
                    @elseif($value_present=='2')
                        <td>
                            <input name="present_{{$eleve->id}}" value="1" type="radio"  />
                        </td>
                        <td>
                            <input name="present_{{$eleve->id}}" value="2" type="radio"checked />
                        </td>
                        <td>
                            <input name="present_{{$eleve->id}}" value="3" type="radio" />
                        </td>
                    @elseif($value_present=='3')
                        <td>
                            <input name="present_{{$eleve->id}}" value="1" type="radio"  />
                        </td>
                        <td>
                            <input name="present_{{$eleve->id}}" value="2" type="radio" />
                        </td>
                        <td>
                            <input name="present_{{$eleve->id}}" value="3" type="radio" checked />
                        </td>
                    @else
                        <td>
                            <input name="present_{{$eleve->id}}" value="1" type="radio" checked  />
                        </td>
                        <td>
                            <input name="present_{{$eleve->id}}" value="2" type="radio" />
                        </td>
                        <td>
                            <input name="present_{{$eleve->id}}" value="3" type="radio" />
                        </td>
                    @endif

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
