<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class StopController extends Controller
{
    public function myStops($road_trip_id)
    {
        try {
            $mystops = DB::table('stops')->where('road_trip_id', $road_trip_id)->whereNull('deleted_at')->get();
            // dd(count($mystops));
            if (count($mystops) > 0) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'Your Stop Fetch Successfully', 'data' => $mystops]);
            } else {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'You do not have any stops create', 'data' => $mystops]);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('stoplog')->error(
                'my-stops' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }

    public function createStop($road_trip_id, Request $request)
    {
        try {
            $data = $request->all();
            $trip_stop = [
                'road_trip_id' => $road_trip_id,
                'name' => $data['name'],
                'description' => $data['description'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'created_at' => now(),
            ];
            $userTripStop = DB::table('stops')->insertGetId($trip_stop);
            if ($userTripStop) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'stop Created Successfully']);
            } else {
                return response()->json(['code' => '400', 'status' => 'failed', 'message' => 'stop Not created']);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('stoplog')->error(
                'stop-create' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }

    public function tripStopDetail($road_trip_id, $id)
    {
        try {
            $mystops = DB::table('stops')->where('road_trip_id', $road_trip_id)->where('id', $id)->whereNull('deleted_at')->get();
            // dd(count($mystops));
            if (count($mystops) > 0) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'Stop Fetch Successfully', 'data' => $mystops]);
            } else {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'You do not have any Stops', 'data' => $mystops]);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('stoplog')->error(
                'stop-detail' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }

    public function updateStop($road_trip_id, $id, Request $request)
    {
        try {
            $data = $request->all();
            $update_stop = [
                'road_trip_id' => $road_trip_id,
                'name' => $data['name'],
                'description' => $data['description'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'updated_at' => now(),
            ];
            $mystops = DB::table('stops')->where('road_trip_id', $road_trip_id)->where('id', $id)->update($update_stop);
            if ($mystops) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'Your Trips Updated Successfully']);
            } else {
                return response()->json(['code' => '400', 'status' => 'failed', 'message' => 'Trip Not updated']);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('stoplog')->error(
                'stop-update' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }

    public function deleteStop($road_trip_id, $id, Request $request)
    {
        try {
            $trip_detail = [
                'deleted_at' => now(),
            ];
            $userTrip = DB::table('stops')->where('id', $id)->where('road_trip_id', $road_trip_id)->update($trip_detail);
            if ($userTrip) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'Your stops Deleted Successfully']);
            } else {
                return response()->json(['code' => '400', 'status' => 'failed', 'message' => 'stop Not deleted']);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('stoplog')->error(
                'stop-delete' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }
}
