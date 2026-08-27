<?php

namespace Corals\Modules\Foo\database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class FooPermissionsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [];

        $permissions[] = [
            'name' => 'Administrations::admin.foo',
        ];

        $models = ['bar'];

        $levels = ['view', 'create', 'update', 'delete', 'restore', 'hardDelete'];

        foreach ($models as $model) {
            foreach ($levels as $level) {
                $permissions[] = [
                    'name' => 'Foo::' . $model . '.' . $level,
                ];
            }
        }

        $permissions = array_map(function ($item) {
            return array_merge($item, [
                'guard_name' => config('auth.defaults.guard'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $permissions);

        DB::table('permissions')->insert($permissions);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
