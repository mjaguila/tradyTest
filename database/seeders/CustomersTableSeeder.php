<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Facades\File;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/seeders/customers.json');
        $customers = json_decode($json);

        foreach ($customers as $key => $value) {
            Customer::create([
                'id' => $value->id,
                'name' => $value->name
            ]);
        }
    }
}
