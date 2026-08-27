<?php

namespace Corals\Utility\Category\Jobs;

use Corals\Foundation\Traits\ImportTrait;
use Corals\Utility\Category\Http\Requests\CategoryRequest;
use Corals\Utility\Category\Models\Category;
use Corals\Utility\Category\Services\CategoryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use League\Csv\{Exception as CSVException};

class HandleCategoriesImportFile implements ShouldQueue
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
        $this->importHeaders = array_keys(trans('utility-category::import.category-headers'));
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

        $categoryData = $this->getcategoryData($record);

        $this->validateRecord($categoryData);

        $categoryModel = Category::query()->where('slug', $categoryData['slug'])->first();

        $categoryRequest = new CategoryRequest();

        $categoryRequest->replace($categoryData);

        $categoryService = new CategoryService();

        if ($categoryModel) {
            $categoryService->update($categoryRequest, $categoryModel);
        } else {
            $categoryService->store($categoryRequest, Category::class);
        }
    }

    /**
     * @param $record
     * @return array
     * @throws \Exception
     */
    protected function getCategoryData($record)
    {

        $data = array_filter([
            'name' => data_get($record, 'name'),
            'slug' => data_get($record, 'slug'),
            'status' => data_get($record, 'status'),
            'parent_id' => data_get($record, 'parent_id'),
            'module' => data_get($record, 'module'),
            'is_featured' => data_get($record, 'is_featured'),
            'category_attributes'=>data_get($record,'category_attributes') ? explode('|',data_get($record,'category_attributes')) :null,
            'description' => data_get($record, 'description'),
        ]);

        if (data_get($record, 'thumbnail_link')) {
            $data['properties'] = ['thumbnail_link' => data_get($record, 'thumbnail_link')];
        }

        return $data;
    }

    protected function initHandler()
    {
    }

    protected function getValidationRules($data): array
    {
        $status = join(',', array_keys(trans('Corals::attributes.status_options')));
        $modules = join(',', array_keys(\Utility::getUtilityModules()));

        return [
            'name' => 'required|max:191',
            'slug' => 'required|max:191|unique:utility_categories,slug',
            'status' => 'required|in:' . $status,
            'parent_id' => 'nullable|exists:utility_categories,id',
            'module' => 'nullable|in:' . $modules,
            'is_featured' => 'nullable|boolean',
            'category_attributes' => 'nullable',
            'category_attributes.*' => 'exists:utility_attributes,id',
            'properties.thumbnail_link' => 'nullable',
            'description' => 'nullable',
        ];
    }
}
