<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movement;

class MovementController extends Controller
{
    public function history($account)
    {
        $history = Movement::where('account_id', $account)->get();
    
        if (count($history) === 0) return response()->json(['status' => 'success', 'data' => 'No movements registered']);

        return response()->json(['status' => 'success', 'data' => $history]);
    }
}
