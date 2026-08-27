<?php

namespace Corals\Utility\Category\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Utility\Category\Http\Requests\ImportRequest;
use Corals\Utility\Category\Jobs\HandleCategoriesImportFile;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Str;
use Illuminate\View\View;
use League\Csv\CannotInsertRecord;
use League\Csv\Reader;
use League\Csv\Writer;


class ImportController extends BaseController
{
    protected $importHeaders;
    protected $importTarget;

    public function __construct()
    {
        $segments = request()->segments();

        $target = $segments[3] ?? "";

        if (!$target) {
            return;
        }

        $this->resource_url = $target;

        $target = Str::singular($target);

        $this->importTarget = $target;

        $this->importHeaders = trans("utility-category::import.$target-headers");

        $this->middleware(function ($request, \Closure $next) use ($target) {

            $model = 'Corals\\Utility\\Category\\Models\\' . ucfirst($target);

            abort_if(user()->cannot('create', $model), 403, 'Unauthorized');

            return $next($request);
        });

        parent::__construct();
    }

    /**
     * @param ImportRequest $request
     * @return Application|Factory|View
     */
    public function getImportModal(ImportRequest $request)
    {
        $headers = $this->importHeaders;
        $target = $this->importTarget;


        return view('utility-category::partials.import_modal')
            ->with(compact('headers', 'target'));
    }

    /**
     * @param ImportRequest $request
     * @throws CannotInsertRecord
     */
    public function downloadImportSample(ImportRequest $request)
    {

        $csv = Writer::createFromFileObject(new \SplTempFileObject())
            ->setDelimiter(config('corals.csv_delimiter', ','));

        //we insert the CSV header
        $csv->insertOne(array_keys($this->importHeaders));

        $target = Str::plural($this->importTarget, 0);

        $csv->output(sprintf('%s_%s.csv', $target, now()->format('Y-m-d-H-i')));

        die;
    }

    /**
     * @param ImportRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImportFile(ImportRequest $request)
    {
        try {
            // store file in temp folder
            $file = $request->file('file');

            $importsPath = storage_path('categories/imports');

            $fileName = sprintf("%s_%s", Str::random(), $file->getClientOriginalName());

            $fileFullPath = $importsPath . '/' . $fileName;
            $file->move($importsPath, $fileName);

            $reader = Reader::createFromPath($fileFullPath, 'r')
                ->setDelimiter(config('corals.csv_delimiter', ','))
                ->setHeaderOffset(0);

            $header = $reader->getHeader();

            // validate file headers
            if (count(array_diff(array_keys($this->importHeaders), $header))) {
                unset($reader);
                @unlink($fileFullPath);
                throw new \Exception(trans('utility-category::import.exceptions.invalid_headers'));
            }

            switch ($this->importTarget) {
                case 'category':
                    $this->dispatch(new HandleCategoriesImportFile($fileFullPath, user()));
                    break;
            }

            return response()->json([
                'level' => 'success',
                'action' => 'closeModal',
                'message' => trans('utility-category::import.messages.file_uploaded')
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'level' => 'error',
                'message' => $exception->getMessage()
            ], 400);
        }
    }


}
