<style>
    .import-description-table .table {
        font-size: small;
    }

    .import-description-table .table > tbody > tr > td {
        padding: 4px;
    }

    .required-asterisk {
        color: red;
        font-size: 100%;
        top: -.4em;
    }
</style>

<div>
    {!! CoralsForm::openForm(null, ['url' => url('utilities/categories/import/'.$resource_url.'/upload-import-file'), 'files' => true]) !!}
    {!! CoralsForm::file('file', 'utility-category::import.labels.file') !!}


    {!! CoralsForm::formButtons('utility-category::import.labels.upload_file', [], ['show_cancel' => false]) !!}
    {!! CoralsForm::closeForm() !!}

    {!! CoralsForm::link(url('utilities/categories/import/'.$resource_url.'/download-import-sample'),
    trans('utility-category::import.labels.download_sample'),
    ['class' => '']) !!}
</div>
<hr/>
<h4>@lang('utility-category::import.labels.column_description')</h4>
<div class="table-responsive import-description-table">
    <table class="table table-striped">
        <thead>
        <tr>
            <th style="width: 120px;">@lang('utility-category::import.labels.column')</th>
            <th>@lang('HireSkills::import.labels.description')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($headers as $column => $description)
            <tr>
                <td>{{ $column }}</td>
                <td>{!! $description !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>
    initSelect2ajax();
</script>
