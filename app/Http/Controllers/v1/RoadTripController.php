<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoadTripController extends Controller
{
    public function myTrips()
    {
        try {
            $loginuser = Auth::user()->id;
            $mytrips = DB::table('road_trips')->where('user_id', $loginuser)->whereNull('deleted_at')->get();
            // dd(count($mytrips));
            if (count($mytrips) > 0) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'Your Trips Fetch Successfully', 'data' => $mytrips]);
            } else {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'You do not have any Trip create', 'data' => $mytrips]);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('roadtriplog')->error(
                'my-trips' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }

    public function createTrip(Request $request)
    {
        try {
            $data = $request->all();
            $loginuser = Auth::user()->id;

            $trip_detail = [
                'user_id' => $loginuser,
                'title' => $data['title'],
                'starting_point' => $data['starting_point'],
                'destination_point' => $data['destination_point'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'created_at' => now(),
            ];
            $userTrip = DB::table('road_trips')->insertGetId($trip_detail);
            if ($userTrip) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'Your Trips Created Successfully']);
            } else {
                return response()->json(['code' => '400', 'status' => 'failed', 'message' => 'Trip Not created']);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('roadtriplog')->error(
                'create-trip' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }

    public function tripDetail($trip_id)
    {
        try {
            $loginuser = Auth::user()->id;
            $mytrips = DB::table('road_trips')->where('user_id', $loginuser)->whereNull('deleted_at')->where('id', $trip_id)->get();
            // dd(count($mytrips));
            if (count($mytrips) > 0) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'Your Trips Fetch Successfully', 'data' => $mytrips]);
            } else {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'You do not have any Trip', 'data' => $mytrips]);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('roadtriplog')->error(
                'trip-detail' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }

    public function tripDetailUpdate($trip_id, Request $request)
    {
        try {
            $data = $request->all();
            $loginuser = Auth::user()->id;

            $trip_detail = [
                'user_id' => $loginuser,
                'title' => $data['title'],
                'starting_point' => $data['starting_point'],
                'destination_point' => $data['destination_point'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'updated_at' => now(),
            ];
            $userTrip = DB::table('road_trips')->where('id', $trip_id)->update($trip_detail);
            if ($userTrip) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'Your Trips Updated Successfully']);
            } else {
                return response()->json(['code' => '400', 'status' => 'failed', 'message' => 'Trip Not updated']);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('roadtriplog')->error(
                'trip-detail-update' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }

    public function tripDelete($trip_id, Request $request)
    {
        try {

            $trip_detail = [
                'deleted_at' => now(),

            ];
            $userTrip = DB::table('road_trips')->where('id', $trip_id)->update($trip_detail);
            if ($userTrip) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'Your Trips Deleted Successfully']);
            } else {
                return response()->json(['code' => '400', 'status' => 'failed', 'message' => 'Trip Not deleted']);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('roadtriplog')->error(
                'trip-delete' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }
}
