<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function userDetail()
    {
        try {
            $userdetails = Auth::user();
            return response()->json(['code' => '200', 'status' => 'success', 'message' => 'Detail fetch successfully', 'data' => $userdetails]);
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('userlog')->error(
                'user-detail' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }
}
