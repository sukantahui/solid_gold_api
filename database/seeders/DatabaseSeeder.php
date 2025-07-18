<?php

namespace Database\Seeders;

use App\Models\AgentCategory;
use App\Models\Agent;
use App\Models\CustomVoucher;
use App\Models\PriceCode;
use App\Models\ProductRate;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\CustomerCategory;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\TransactionType;
use App\Models\User;
use App\Models\UserType;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            ['employee_name'=>'Vivekanada','mobile'=>'9836444999','email'=>'bangle312@gmail.com','department_id' => 3, 'designation_id' => 3],
            ['employee_name'=>'Sukanta Hui','mobile'=>'7003756860','email'=>'sukantahui@gmail.com','department_id' => 2, 'designation_id' => 2],
            ['employee_name'=>'Saheb Ghosh','mobile'=>'8334861999','email'=>'sahebghosh89@gmail.com','department_id' => 4, 'designation_id' => 4]
        ]);
        //admin created
        $user=User::create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'user_type_id'=>1,
            'employee_id'=>2
        ]);
        $this->command->info('Created user ADMIN:');
        $this->command->table(
            ['Email', 'Created At'],
            [[$user->email, $user->created_at]]
        );
        //developer created
        $user=User::create([
            'email' => 'developer@gmail.com',
            'password' => Hash::make('12345678'),
            'user_type_id'=>2,
            'employee_id'=>2
        ]);
        $this->command->info('Created user: Developer');
        $this->command->table(
            ['Email', 'Created At'],
            [[$user->email, $user->created_at]]
        );
        //owner created
        $user=User::create([
            'email' => 'owner@gmail.com',
            'password' => Hash::make('12345678'),
            'user_type_id'=>3,
            'employee_id'=>1
        ]);
        $this->command->info('Created user: owner');
        $this->command->table(
            ['Email', 'Created At'],
            [[$user->email, $user->created_at]]
        );

        //owner created
        $user=User::create([
            'email' => 'manager@gmail.com',
            'password' => Hash::make('12345678'),
            'user_type_id'=>4,
            'employee_id'=>3
        ]);
        $this->command->info('Created user: Manager');
        $this->command->table(
            ['Email', 'Created At'],
            [[$user->email, $user->created_at]]
        );

        AgentCategory::insert([
            ['agent_category_name' => 'Gold Agent'],
            ['agent_category_name' => 'Silver Agent']
        ]);
        Agent::insert([
            ['agent_name'=>'Counter Agent','agent_category_id'=>'1','short_name'=>'CA','email'=>'bangle312@gmail.com','phone'=>'998364449999','address'=>'Barrackpore','pin_code'=>'700122'],
            ['agent_name'=>'Swapon Sil','agent_category_id'=>'1','short_name'=>'SWSI','email'=>'swa@gmail.com','phone'=>'12364','address'=>'Barrackpore','pin_code'=>'700122'],
            ['agent_name'=>'Akash Dutta','agent_category_id'=>'2','short_name'=>'AD','email'=>'AD@gmail.com','phone'=>'1236456','address'=>'Barrackpore','pin_code'=>'700122'],
            ['agent_name'=>'Arnab Das','agent_category_id'=>'1','short_name'=>'AR','email'=>'AR@gmail.com','phone'=>'45636456','address'=>'Palta','pin_code'=>'700121']

        ]);
        CustomerCategory::insert([
            ['customer_category_name' => 'Gold'],
            ['customer_category_name' => 'Platinum'],
            ['customer_category_name' => 'Tester'],
            ['customer_category_name' => 'Silver'],
            ['customer_category_name' => 'Diamond'],
            ['customer_category_name' => 'Other']

        ]);

        Customer::insert([
            ['customer_category_id' => 1,
            'customer_name' => 'Sbs Jewellers',
            'mailing_name'=> 'M/S SBS Jewellers',
            'email'=> 'sbs@gmail.com',
            'phone'=> '781458',
            'address'=> 'Garia',
            'pin_code'=> '700111',
            'opening_gold_balance'=> 0,
            'opening_cash_balance'=> 0],

            ['customer_category_id' => 1,
            'customer_name' => 'Radha Jewellers',
            'mailing_name'=> 'M/S Radha Jewellers',
            'email'=> 'radha@gmail.com',
            'phone'=> '8955465',
            'address'=> 'Howrah',
            'pin_code'=> '78559',
            'opening_gold_balance'=> 0,
            'opening_cash_balance'=> 0]
        ]);
        

        PriceCode::insert([
            ['price_code_name' => 'A'],
            ['price_code_name' => 'B'],
            ['price_code_name' => 'C'],
            ['price_code_name' => 'D']
        ]);

        ProductRate::insert([
            ['customer_category_id'=>'1','price_code_id'=>'1','wastege_percentage'=>4,'labour_charge'=>0],
            ['customer_category_id'=>'1','price_code_id'=>'2','wastege_percentage'=>5,'labour_charge'=>0],
            ['customer_category_id'=>'1','price_code_id'=>'3','wastege_percentage'=>6,'labour_charge'=>0],
            ['customer_category_id'=>'1','price_code_id'=>'4','wastege_percentage'=>7,'labour_charge'=>0],
            ['customer_category_id'=>'2','price_code_id'=>'1','wastege_percentage'=>4.5,'labour_charge'=>0],
            ['customer_category_id'=>'2','price_code_id'=>'2','wastege_percentage'=>5.5,'labour_charge'=>0],
            ['customer_category_id'=>'2','price_code_id'=>'3','wastege_percentage'=>6.5,'labour_charge'=>0],
            ['customer_category_id'=>'2','price_code_id'=>'4','wastege_percentage'=>7.5,'labour_charge'=>0]
        ]);

        ProductCategory::insert([
            ['product_category_name' => 'Bala','product_category_description'=>'This is a bala product'],
            ['product_category_name' => 'Churi','product_category_description'=>'This is a Churi'],
            ['product_category_name' => 'Chain','product_category_description'=>'This is a chain'],
            ['product_category_name' => 'Mangal Sutra','product_category_description'=>'This is a Mangal Sutra'],
            ['product_category_name' => 'Necklace','product_category_description'=>'This is a Necklace'],
            ['product_category_name' => 'Ring','product_category_description'=>'This is a Ring'],
            ['product_category_name' => 'Bangle','product_category_description'=>'This is a Bangle'],
            ['product_category_name' => 'Other','product_category_description'=>'This is a Other']
        ]);


        Product::create([
            'product_category_id' => 1,
            'product_name' => 'Churi',
            'product_number' => 'C21',
            'price_code_id' => 1,
        ]);

        Product::create([
            'product_category_id' => 2,
            'product_name' => 'Bala',
            'product_number' => 'B22',
            'price_code_id' => 2,
        ]);

        Product::create([
            'product_category_id' => 1,
            'product_name' => 'Chain',
            'product_number' => 'Ch22',
            'price_code_id' => 2,
        ]);

        TransactionType::create([
            'transaction_type_name'=>'Fine Gold Received From Customer'
        ]);
        TransactionType::create([
            'transaction_type_name'=>'Fine Gold Returned to Customer'
        ]);
        TransactionType::create([
            'transaction_type_name'=>'Fine Gold from customer Customer in cash'
        ]);

    }
}
