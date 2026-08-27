<?php

namespace Corals\Utility\Location\Jobs;

use Corals\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;
use Yajra\DataTables\EloquentDataTable;

class GenerateExcelForLocations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dataTable;
    protected $scopes;
    protected $columns;
    protected $user;
    protected $tableID;
    protected $download;


    /**
     * GenerateCSVForDataTable constructor.
     * @param $dataTable
     * @param $scopes
     * @param $columns
     * @param $tableID
     * @param User $user
     * @param bool $download
     */
    public function __construct($dataTable, $scopes, $columns, $tableID, User $user, $download = false)
    {
        $this->dataTable = $dataTable;
        $this->scopes = $scopes;
        $this->columns = $columns;
        $this->user = $user;
        $this->tableID = $tableID;
        $this->download = $download;
    }

    /**
     * Execute the job.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function handle()
    {
        try {
            logger('start exporting: ' . $this->dataTable);

            $dataTable = app()->make($this->dataTable);

            $query = app()->call([$dataTable, 'query']);

            $dt = new EloquentDataTable($query);

            $source = $dt->getFilteredQuery();


            //apply scopes
            foreach ($this->scopes as $scope) {
                $scope->apply($source);
            }

            $rootPath = config('app.export_excel_base_path');

            $exportName = join('_', [
                'utility_locations_export',
                'user_id_' . $this->user->id,
                str_replace(['-', ':', ' '], '_', now()->toDateTimeString()) . '.csv'
            ]);

            $filePath = storage_path($rootPath . $exportName);

            if (!file_exists($rootPath = storage_path($rootPath))) {
                mkdir($rootPath, 0755, true);
            }

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $writer = Writer::createFromPath($filePath, 'w+')
                ->setDelimiter(config('corals.csv_delimiter', ','));

            $headers = array_merge(['id' => 'location id'], trans("utility-location::import.location-headers"));

            $writer->insertOne(array_keys($headers));

            $source->chunk(100, function ($data) use ($writer) {
                foreach ($data as $location) {
                    try {
                        $locationExportData = [
                            'id' => $location->id,
                            'name' => $location->name,
                            'slug' => $location->slug,
                            'status' => $location->status,
                            'address' => $location->address,
                            'lat' => $location->lat,
                            'long' => $location->long,
                            'zip' => $location->zip,
                            'city' => $location->city,
                            'state' => $location->state,
                            'country' => $location->country,
                            'module' => $location->module,
                            'type' => $location->type,
                            'parent_id' => $location->parent_id,
                            'description' => $location->description,
                        ];

                        $writer->insertOne($locationExportData);

                    } catch (CannotInsertRecord $exception) {
                        logger(self::class);
                        logger($exception->getMessage());
                        logger($exception->getRecord());
                    } catch (\Exception $exception) {
                    }
                }
            });

            if ($this->download) {
                logger($exportName . ' Completed');
                return response()->download($filePath);
            }


            logger($exportName . ' Completed');
        } catch (\Exception $exception) {
            report($exception);
        }
    }
}

