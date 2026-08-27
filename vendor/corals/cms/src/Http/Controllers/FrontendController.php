<?php

namespace Corals\Modules\CMS\Http\Controllers;

use Corals\Foundation\Http\Controllers\PublicBaseController;
use Corals\Modules\CMS\Traits\CMSControllerFunctions;

class FrontendController extends PublicBaseController
{
    use CMSControllerFunctions;
    public $view_prefix = '';
    public $internalState = false;

    public function __construct()
    {
        $this->resetContentQuery();

        parent::__construct();
    }
}
