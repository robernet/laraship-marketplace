<?php

namespace Corals\Modules\CMS\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\CMS\Traits\CMSControllerFunctions;

class CMSInternalController extends BaseController
{
    use CMSControllerFunctions;
    public $view_prefix = '';
    public $internalState = true;

    public function __construct()
    {
        $this->view_prefix = 'cms::cms_internal';

        $this->resetContentQuery();

        parent::__construct();
    }
}
