<x-modal.modal-header-body>
    <x-slot name="title">
        add new pointage
    </x-slot>
    <div id="formAddFamille">
        <form action="{{ url('pointages/add') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col">

                    <x-forms.select
                        id="classe"
                        name="classe_id"
                        class="form-control select2"
                        title="@lang('text.selectionnez')"
                        label="classe"
                        field-required
                    >
{{--                        <option selected value="all">@lang('text.all')</option>--}}
                        @foreach($classes as $classe)
                            <option value="{{$classe->id}}">{{$classe->libelle_fr}}</option>
                        @endforeach

                    </x-forms.select>
                </div>
                <div class="col">
                    <x-forms.input type="date"  value="{{date('Y-m-d')}}" field-required label="date" name="date"/>
                </div>
                 <div class="col">
                    <x-forms.input type="time" value="{{date('h:i')}}" field-required label="heure" name="time"/>
                </div>
{{--                <div class="col">--}}
{{--                    <x-forms.input type="text"  value="{{ auth()->user()->name}}" field-required label="pointeur" name="pointeurName"/>--}}
{{--                </div>--}}

            </div>
        </form>
        <x-buttons.btn-save
            onclick="addObject(this, 'pointages')"
            container="formAddFamille">
            save
        </x-buttons.btn-save>
    </div>
</x-modal.modal-header-body>
