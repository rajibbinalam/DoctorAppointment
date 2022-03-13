<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dept = ['Jology','Phyology','Cocology','Aurthopedycs','Medicin'];
        for ($i=0; $i < 5; $i++) { 
            $data = new Department();
            $data->name = $dept[$i];
            $data->save();
        }
    }
}
