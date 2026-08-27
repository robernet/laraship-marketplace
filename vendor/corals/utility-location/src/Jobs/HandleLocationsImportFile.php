<?php

namespace Corals\Utility\Location\Jobs;

use Corals\Foundation\Traits\ImportTrait;
use Corals\Utility\Location\Http\Requests\LocationRequest;
use Corals\Utility\Location\Models\Location;
use Corals\Utility\Location\Services\LocationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use League\Csv\{Exception as CSVException};

class HandleLocationsImportFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ImportTrait;

    protected $importFilePath;

    /**
     * @var array
     */
    protected $importHeaders;
    protected $user;

    /**
     * HandleBrandsImportFile constructor.
     * @param $importFilePath
     * @param $user
     */
    public function __construct($importFilePath, $user)
    {
        $this->user = $user;
        $this->importFilePath = $importFilePath;
        $this->importHeaders = array_keys(trans('utility-location::import.location-headers'));
    }


    /**
     * @throws CSVException
     */
    public function handle()
    {
        $this->doImport();
    }

    /**
     * @param $record
     * @throws \Exception
     */
    protected function handleImportRecord($record)
    {
        $record = array_map('trim', $record);

        $locationData = $this->getLocationData($record);

        $this->validateRecord($locationData);

        $locationModel = Location::query()->where('name', $locationData['name'])->first();

        $locationRequest = new LocationRequest();

        $locationRequest->replace($locationData);

        $locationService = new LocationService();

        if ($locationModel) {
            $locationService->update($locationRequest, $locationModel);
        } else {
            $locationService->store($locationRequest, Location::class);
        }
    }

    /**
     * @param $record
     * @return array
     * @throws \Exception
     */
    protected function getLocationData($record)
    {
        return array_filter([
            'name' => data_get($record, 'name'),
            'slug' => data_get($record, 'slug'),
            'status' => data_get($record, 'status'),
            'address' => data_get($record, 'address'),
            'lat' => data_get($record, 'lat'),
            'long' => data_get($record, 'long'),
            'zip' => data_get($record, 'zip'),
            'city' => data_get($record, 'city'),
            'state' => data_get($record, 'state'),
            'country' => data_get($record, 'country'),
            'module' => data_get($record, 'module'),
            'type' => data_get($record, 'type'),
            'parent_id' => data_get($record, 'parent_id'),
            'description' => data_get($record, 'description'),
        ]);
    }

    protected function initHandler()
    {
    }

    protected function getValidationRules($data): array
    {
        $locationTypes = join(',', array_keys(\Settings::get('utility_location_types', [])));
        $status = join(',', array_keys(trans('Corals::attributes.status_options')));
        $modules = join(',', array_keys(\Utility::getUtilityModules()));

        return [
            'name' => 'required|max:191|unique:utility_locations,name',
            'slug' => 'nullable',
            'status' => 'required|in:' . $status,
            'address' => 'required|max:191',
            'lat' => 'required|max:191',
            'long' => 'required|max:191',
            'zip' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
            'module' => 'nullable|in:' . $modules,
            'type' => 'nullable|in:' . $locationTypes,
            'parent_id' => 'nullable|exists:utility_list_of_values,id',
            'description' => 'nullable',
        ];
    }
}
