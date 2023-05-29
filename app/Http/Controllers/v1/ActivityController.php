<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ActivityController extends Controller
{
    public function myActivities($road_trip_id)
    {
        try {
            $activity = DB::table('activities')->where('road_trip_id', $road_trip_id)->whereNull('deleted_at')->get();
            // dd(count($activity));
            if (count($activity) > 0) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'Your Activities Fetch Successfully', 'data' => $activity]);
            } else {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'You do not have any Activity created', 'data' => $activity]);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('activitylog')->error(
                'my-activity' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }

    public function createActivity($road_trip_id, Request $request)
    {
        try {
            $data = $request->all();
            $trip_activity = [
                'road_trip_id' => $road_trip_id,
                'name' => $data['name'],
                'description' => $data['description'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'created_at' => now(),
            ];
            $userTripActivity = DB::table('activities')->insertGetId($trip_activity);
            if ($userTripActivity) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'Activity Created Successfully']);
            } else {
                return response()->json(['code' => '400', 'status' => 'failed', 'message' => 'Activity Not created']);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('activitylog')->error(
                'create-activity' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }

    public function tripActvityDetail($road_trip_id, $id)
    {
        try {
            $myactivities = DB::table('activities')->where('road_trip_id', $road_trip_id)->where('id', $id)->whereNull('deleted_at')->get();
            // dd(count($myactivities));
            if (count($myactivities) > 0) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'Activity Fetch Successfully', 'data' => $myactivities]);
            } else {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'You do not have any Activity', 'data' => $myactivities]);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('activitylog')->error(
                'detail-activity' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }

    public function updateActivity($road_trip_id, $id, Request $request)
    {
        try {
            $data = $request->all();
            $update_Activity = [
                'road_trip_id' => $road_trip_id,
                'name' => $data['name'],
                'description' => $data['description'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'updated_at' => now(),
            ];
            $myActivity = DB::table('activities')->where('road_trip_id', $road_trip_id)->where('id', $id)->update($update_Activity);
            if ($myActivity) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'Your Activity Updated Successfully']);
            } else {
                return response()->json(['code' => '400', 'status' => 'failed', 'message' => 'Activity Not updated']);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('activitylog')->error(
                'update-activity' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }

    public function deleteActivity($road_trip_id, $id)
    {
        try {
            $trip_detail = [
                'deleted_at' => now(),
            ];
            $userTrip = DB::table('activities')->where('id', $id)->where('road_trip_id', $road_trip_id)->update($trip_detail);
            if ($userTrip) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'Your Activities Deleted Successfully']);
            } else {
                return response()->json(['code' => '400', 'status' => 'failed', 'message' => 'Activity Not deleted']);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('activitylog')->error(
                'delete-activity' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }
}
