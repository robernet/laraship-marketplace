{!! CoralsForm::openForm($baz,['data-table' => '#BazsDataTable']) !!}

{!! CoralsForm::text('name', 'Foo::attributes.baz.name' ,true,null) !!}

{!! CoralsForm::customFields($baz) !!}

{!! CoralsForm::formButtons() !!}
{!! CoralsForm::closeForm($baz) !!}
