@props(['modelName', 'label', 'route', 'permission'])

<div class="d-flex justify-content-between">

    @can($permission)
        <x-form.add-link :label="$label" :route="$route"/>
    @endcan

    <x-form.search/>

</div>
