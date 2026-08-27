<?php

namespace Corals\Modules\Foo\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Foo\DataTables\BazsDataTable;
use Corals\Modules\Foo\Http\Requests\BazRequest;
use Corals\Modules\Foo\Models\Baz;
use Corals\Modules\Foo\Services\BazService;
use Illuminate\Http\JsonResponse;

class BazsController extends BaseController
{
    protected $bazService;

    public function __construct(BazService $bazService)
    {
        $this->bazService = $bazService;

        $this->resource_url = config('foo.models.baz.resource_url');

        $this->resource_model = new Baz();

        $this->title = trans('Foo::module.baz.title');
        $this->title_singular = trans('Foo::module.baz.title_singular');

        parent::__construct();
    }

    /**
     * @param BazRequest $request
     * @param BazsDataTable $dataTable
     * @return mixed
     */
    public function index(BazRequest $request, BazsDataTable $dataTable)
    {
        return $dataTable->render('Foo::bazs.index');
    }

    /**
     * @param BazRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(BazRequest $request)
    {
        $baz = new Baz();

        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular]),
        ]);

        return view('Foo::bazs.create_edit')->with(compact('baz'));
    }

    /**
     * @param BazRequest $request
     * @return JsonResponse
     */
    public function store(BazRequest $request)
    {
        try {
            $baz = $this->bazService->store($request, Baz::class);
            $message = [
                'level' => 'success',
                'message' => trans('Corals::messages.success.created', ['item' => $this->title_singular]),
            ];
        } catch (\Exception $exception) {
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
            log_exception($exception, Baz::class, 'store');
        }

        return response()->json($message);
    }

    /**
     * @param BazRequest $request
     * @param Baz $baz
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(BazRequest $request, Baz $baz)
    {
        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.show_title', ['title' => $baz->getIdentifier()]),
            'showModel' => $baz,
        ]);

        return view('Foo::bazs.show')->with(compact('baz'));
    }

    /**
     * @param BazRequest $request
     * @param Baz $baz
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(BazRequest $request, Baz $baz)
    {
        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.update_title', ['title' => $baz->getIdentifier()]),
        ]);

        return view('Foo::bazs.create_edit')->with(compact('baz'));
    }

    /**
     * @param BazRequest $request
     * @param Baz $baz
     * @return JsonResponse
     */
    public function update(BazRequest $request, Baz $baz)
    {
        try {
            $this->bazService->update($request, $baz);
            $message = [
                'level' => 'success',
                'message' => trans('Corals::messages.success.updated', ['item' => $this->title_singular]),
            ];
        } catch (\Exception $exception) {
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
            log_exception($exception, Baz::class, 'update');
        }

        return response()->json($message);
    }

    /**
     * @param BazRequest $request
     * @param Baz $baz
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(BazRequest $request, Baz $baz)
    {
        try {
            $this->bazService->destroy($request, $baz);

            $message = [
                'level' => 'success',
                'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular]),
            ];
        } catch (\Exception $exception) {
            log_exception($exception, Baz::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}
