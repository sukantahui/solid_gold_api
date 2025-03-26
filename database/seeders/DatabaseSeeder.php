<?php

namespace Database\Seeders;

use App\Models\CustomerCategory;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\User;
use App\Models\UserType;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        UserType::insert([
            ['user_type_name' => 'Admin'],
            ['user_type_name' => 'Developer'],
            ['user_type_name' => 'Owner'],
            ['user_type_name' => 'Manager'],
            ['user_type_name' => 'Manager Production'],
            ['user_type_name' => 'Manager Sale'],
            ['user_type_name' => 'Worker'],
        ]);

        Department::insert([
            ['department_name' => 'Administration'],
            ['depatment_name' => 'Development'],
            ['depatment_name' => 'Ownership'],
            ['depatment_name' => 'Office'],
        ]);
        Designation::insert([
            ['designation_name' => 'Administrator'],
            ['designation_name' => 'Developer'],
            ['designation_name' => 'Owner'],
            ['designation_name' => 'Manager'],
            ['designation_name' => 'Manager Production'],
            ['designation_name' => 'Manager Sale'],
            ['designation_name' => 'Worker'],
        ]);
        Employee::insert([
            ['employee_name'=>'Vivekanada','mobile'=>'9836444999','email'=>'bangle312@gmail.com','department_id' => 1, 'designation_id' => 1]
        ]);
        CustomerCategory::insert([
            ['customer_category_name' => 'Gold'],
            ['customer_category_name' => 'Platinum'],
        ]);
    }
}
