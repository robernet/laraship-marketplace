<?php

namespace Corals\Modules\Foo\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Foo\Models\Baz;

class BazTransformer extends BaseTransformer
{
    public function __construct($extras = [])
    {
        $this->resource_url = config('foo.models.baz.resource_url');

        parent::__construct($extras);
    }

    /**
     * @param Baz $baz
     * @return array
     * @throws \Throwable
     */
    public function transform(Baz $baz)
    {
        $show_url = $baz->getShowURL();

        $transformedArray = [
            'id' => $baz->id,
            'name' => $this->getModelLink($baz, $baz->name, ['data-size' => 'modal-lg']),
            'created_at' => format_date($baz->created_at),
            'updated_at' => format_date($baz->updated_at),
            'action' => $this->actions($baz),
        ];

        return parent::transformResponse($transformedArray);
    }
}
