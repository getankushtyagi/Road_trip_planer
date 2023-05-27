<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public function userDetailUpdate(Request $request)
    {
        try {
            $loginuserid = Auth::user()->id;
            $data = $request->all();
            $updateval = [
                'email' => $data['email'],
                'name' => $data['name']
            ];
            $result = DB::table('users')->where('id', $loginuserid)->update($updateval);
            if ($result) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'User Detail Updated successfully']);
            } else {
                return response()->json(['code' => '400', 'status' => 'failed', 'message' => 'User detail not Updated']);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('userlog')->error(
                'user-detail-update' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }

    public function userDelete(Request $request)
    {
        try {
            $loginuserid = Auth::user()->id;
            $currenttime = Carbon::now()->toDateTime();
            // dd($currenttime);
            $result = DB::table('users')->where('id', $loginuserid)->update([
                'deleted_at' => $currenttime
            ]);
            if ($result) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'User Deleted successfully']);
            } else {
                return response()->json(['code' => '400', 'status' => 'failed', 'message' => 'User not Exist']);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('userlog')->error(
                'user-detail-update' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }
}
