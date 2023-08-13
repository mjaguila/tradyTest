<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FinancialApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_account_creation()
    {
        $data = [
            'customer_id' => '4',
            'initial_deposit' => '500'
        ];
   
        $response = $this->json('POST','api/accounts/create',$data);

        $response->assertStatus(200);
    }
    
    public function test_transfer()
    {
        $data = [
            'amount' => '1',
            'source_account' => '11',
            'destination_account' => '2'
        ];
   
        $response = $this->json('POST','api/accounts/transfer',$data);

        $response->assertStatus(200);
    }

    public function test_balance()
    {
        $response = $this->get('api/accounts/balance/1');

        $response->assertStatus(200);
    }
    
    public function test_history()
    {
        $response = $this->get('api/movements/history/5');

        $response->assertStatus(200);
    }
}
