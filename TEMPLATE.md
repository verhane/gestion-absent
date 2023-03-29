# DCS template

## Getting started

To make it easy for you to get started with DCS-template, here's a list of recommended next steps.

### Components usage

- [ ] Buttons
- btn-add : Button pour ajouter un élément (`ex `: ajouter un utilisateur)

```angular2html

<x-buttons.btn-add>
    {{__('Ajouter un utilisateur')}}
</x-buttons.btn-add>
```

- btn-save : Button pour enregistrer les modifications (`ex `: enregistrer un utilisateur)

```angular2html

<x-buttons.btn-save>
    {{__('Enregistrer')}}
</x-buttons.btn-save>
```

- buttons.actions-btn : Button pour les actions

```angular2html

<x-buttons.actions-btn>

</x-buttons.actions-btn>
```

- buttons.actions-container : Container pour les actions

```angular2html

<x-buttons.actions-container></x-buttons.actions-container>
```

- buttons.actions-container-groupe : Container pour les actions

```angular2html

<x-buttons.actions-container-groupe></x-buttons.actions-container-groupe>
```

- [ ] Forms
- forms.input : Input has a `label`, `name`, `id`, `placeholder`, `type`, `value`, and a `field-required` attribute

```angular2html

<x-forms.input
    label="Label"
    name="name"
    placeholder="Placeholder"
    field-required="true"
></x-forms.input>
```

- forms.select : Input group has a `label`, `name`, `id`, and a `field-required` attribute

```angular2html

<x-forms.select
    label="Label"
    name="name"
    field-required="true"
>
    <option value="1">Option 1</option>
    <option value="2">Option 2</option>
    <option value="3">Option 3</option>
</x-forms.select>
```

- [ ] Filters
- filtres.container : Container pour les filtres

```angular2html

<x-filters.container>
    <x-filters.element class="col" label="Filter label">
        <x-forms.select name="filter-test">
            <option value="1">Option 1</option>
            <option value="2">Option 2</option>
            <option value="3">Option 3</option>
        </x-forms.select>
    </x-filters.element>
</x-filters.container>
```

- filtres.element : Element pour les filtres: attribute `label` pour le label du filtre

```angular2html

<x-filters.element label="Filter label">
    <x-forms.select name="filter-test">
        <option value="1">Option 1</option>
        <option value="2">Option 2</option>
        <option value="3">Option 3</option>
    </x-forms.select>
</x-filters.element>
```

- [ ] **Cards**
- card: _slot with the name_ `heading` _for the heading of the card_

```angular2html

<x-card>
    <x-slot name="heading">
        card heading
    </x-slot>
    card-body
</x-card>
```

- [ ] Tables
- table
  ***Attention*** : la table doit être dans un container avec la classe `table-responsive`

```angular2html

<div class="table-responsive">
    <x-table.table>
        <x-table.tr>
            <x-table.th>th 1</x-table.th>
            <x-table.th>th 2</x-table.th>
            <x-table.th>th 3</x-table.th>
        </x-table.tr>
        <x-table.tr>
            <x-table.td>td exemple 1</x-table.td>
            <x-table.td>td exemple 2</x-table.td>
            <x-table.td>td exemple 3</x-table.td>
        </x-table.tr>
    </x-table.table>
</div>
```

- [ ] Layouts
- page-header : Header de la page avec un `titre` et un bouton d'action (`ex `: ajouter un utilisateur)

```angular2html

<x-layouts.page-header>
    <x-slot name="title">
        {{__('Utilisateurs')}}
    </x-slot>
    <x-buttons.btn-add>
        {{__('Ajouter un utilisateur')}}
    </x-buttons.btn-add>
</x-layouts.page-header>
```

- [ ] **Modals**
- modal : Modal avec un `titre` et un `body`

```angular2html

<x-modal.modal-header-body>
    <x-slot name="title">
        Modal title
    </x-slot>
    <div>
        Modal body
    </div>
</x-modal.modal-header-body>
```

## Exemples of some usage

- [ ] **Index blade**: `index.blade.php` (exemple) : `page-header` + `filters` + `table` 

```angular2html

<page-header>
    <x-slot name="title">
        {{__('Utilisateurs')}}
    </x-slot>
    <x-buttons.btn-add>
        {{__('Ajouter un utilisateur')}}
    </x-buttons.btn-add>
</page-header>

<x-filters.container>
    <x-filters.element class="col" label="Filter label">
        <x-forms.select name="filter-test">
            <option value="1">Option 1</option>
            <option value="2">Option 2</option>
            <option value="3">Option 3</option>
        </x-forms.select>
    </x-filters.element>
</x-filters.container>

<div class="table-responsive">
    <x-table.table>
        <x-table.tr>
            <x-table.th>th 1</x-table.th>
            <x-table.th>th 2</x-table.th>
            <x-table.th>th 3</x-table.th>
        </x-table.tr>
        <x-table.tr>
            <x-table.td>td exemple 1</x-table.td>
            <x-table.td>td exemple 2</x-table.td>
            <x-table.td>td exemple 3</x-table.td>
        </x-table.tr>
    </x-table.table>
</div>
```

- [ ] **Add blade**: `add.blade.php` (exemple) : `modal-header-body` + `form` 

```angular2html

<x-modal.modal-header-body>
    <x-slot name="title">
        {{__('Ajouter un utilisateur')}}
    </x-slot>
    <form action="">
        <x-forms.input label="Nom" name="name" placeholder="Nom" field-required="true"></x-forms.input>
        <x-forms.input label="Prénom" name="firstname" placeholder="Prénom" field-required="true"></x-forms.input>
        <x-forms.input label="Email" name="email" placeholder="Email" field-required="true"></x-forms.input>
        <x-forms.select label="Rôle" name="role" field-required="true">
            <option value="1">Option 1</option>
            <option value="2">Option 2</option>
            <option value="3">Option 3</option>
        </x-forms.select>

        <x-buttons.btn-save>
            {{__('Enregistrer')}}
        </x-buttons.btn-save>

    </form>
</x-modal.modal-header-body>
```

