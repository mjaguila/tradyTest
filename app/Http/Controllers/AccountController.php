<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Movement;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'customer_id' => 'required|exists:customers,id',
            'initial_deposit' => 'gt:0'
        ];

        $messages = [
            'customer_id.exists' => 'The customer does not exists',
            'initial_deposit.gt' => 'Initial deposit must be greater than cero'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'data' => $validator->errors()->all()]);
        }
 
        $account = new Account();
        $account->customer_id = $request->get('customer_id');
        $account->save();

        $initial_deposit = $request->get('initial_deposit');

        $movement = new Movement();
        $movement->account_id = $account->id;
        $movement->credit = $initial_deposit;
        $movement->save();

        return response()->json(['status' => 'success', 'data' => $account]);
    }

    public function transfer(Request $request)
    {
        $rules = [
            'amount' => 'required|gt:0',
            'source_account' => 'required|exists:accounts,id',
            'destination_account' => 'required|exists:accounts,id',
        ];

        $messages = [
            'amount.gt' => 'Amount must be greater than cero',
            'source_account.exists' => 'The source account does not exists',
            'destination_account.exists' => 'The destination account does not exists',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'data' => $validator->errors()->all()]);
        }
 
        $source = Account::find($request->get('source_account'));
        $destination = Account::find($request->get('destination_account'));
        $amount = $request->get('amount');
        $source_balance = $this->balance($source->id);
        if ($source_balance < $amount) {
            return response()->json(['status' => 'error', 'data' => 'Insufficient balance']);
        }

        $movement = new Movement();
        $movement->account_id = $source->id;
        $movement->debit = $amount;
        $movement->save();

        $movement = new Movement();
        $movement->account_id = $destination->id;
        $movement->credit = $amount;
        $movement->save();

        return response()->json(['status' => 'success', 'data' => 'Transaction completed']);
    }

    public function balance($id)
    {

        $credits = Movement::where('account_id', $id)->where('credit', '<>', 0)->get();
        $debits = Movement::where('account_id', $id)->where('debit', '<>', 0)->get();

        return $credits->sum('credit') - $debits->sum('debit');
    }
}
