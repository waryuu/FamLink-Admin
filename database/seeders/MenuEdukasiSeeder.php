<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuModel;
use App\Models\RoleHasModel;

class MenuEdukasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newmenu = [
            [
                'parent' => 17,
                'title' => 'Master Event',
                'url' => '/admin/event',
                'visible' => 1,
                'status' => 1,
            ],
            [
                'parent' => 17,
                'title' => 'Master Material',
                'url' => '/admin/material',
                'visible' => 1,
                'status' => 1,
            ],
        ];
        foreach ($newmenu as $key => $value) {
            MenuModel::create($value);
        }

        $addrole = [
            [
                'id_role' => 2,
                'id_menu' => 23,
            ],
            [
                'id_role' => 2,
                'id_menu' => 24,
            ],
        ];
        foreach ($addrole as $key => $value) {
            RoleHasModel::create($value);
        }
    }
}
