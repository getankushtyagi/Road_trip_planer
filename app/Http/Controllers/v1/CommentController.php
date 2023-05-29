<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function myComments($road_trip_id)
    {
        try {
            $comments = DB::table('comments')->where('road_trip_id', $road_trip_id)->whereNull('deleted_at')->get();
            // dd(count($comments));
            if (count($comments) > 0) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'Your comments Fetch Successfully', 'data' => $comments]);
            } else {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'You do not have any comments created', 'data' => $comments]);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('commentslog')->error(
                'my-comments' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }

    public function createComment($road_trip_id, Request $request)
    {
        try {
            $loginuserid=Auth::user()->id;
            $data = $request->all();
            $trip_comments = [
                'road_trip_id' => $road_trip_id,
                'user_id' => $loginuserid,
                'body' => $data['body'],
                'created_at' => now(),
            ];
            $userTripComments = DB::table('comments')->insertGetId($trip_comments);
            if ($userTripComments) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'comments Created Successfully']);
            } else {
                return response()->json(['code' => '400', 'status' => 'failed', 'message' => 'comments Not created']);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('commentslog')->error(
                'create-comments' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }

    public function tripCommentDetail($road_trip_id, $id)
    {
        try {
            $mycomments = DB::table('comments')->where('road_trip_id', $road_trip_id)->where('id', $id)->whereNull('deleted_at')->get();
            // dd(count($mycomments));
            if (count($mycomments) > 0) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'comments Fetch Successfully', 'data' => $mycomments]);
            } else {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'You do not have any comments', 'data' => $mycomments]);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('commentslog')->error(
                'detail-comments' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }

    public function updateComment($road_trip_id, $id, Request $request)
    {
        try {
            $loginuserid=Auth::user()->id;
            $data = $request->all();
            $update_comments = [
                'road_trip_id' => $road_trip_id,
                'user_id' => $loginuserid,
                'body' => $data['body'],
                'updated_at' => now(),
            ];
            $mycomments = DB::table('comments')->where('road_trip_id', $road_trip_id)->where('id', $id)->update($update_comments);
            if ($mycomments) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'Your comments Updated Successfully']);
            } else {
                return response()->json(['code' => '400', 'status' => 'failed', 'message' => 'comments Not updated']);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('commentslog')->error(
                'update-comments' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }

    public function deleteComment($road_trip_id, $id)
    {
        try {
            $trip_detail = [
                'deleted_at' => now(),
            ];
            $userTrip = DB::table('comments')->where('id', $id)->where('road_trip_id', $road_trip_id)->update($trip_detail);
            if ($userTrip) {
                return response()->json(['code' => '200', 'status' => 'success', 'message' => 'Your comments Deleted Successfully']);
            } else {
                return response()->json(['code' => '400', 'status' => 'failed', 'message' => 'comments Not deleted']);
            }
        } catch (\Exception $e) {
            // dd($e);
            Log::channel('commentslog')->error(
                'delete-comments' . date("Y-m-d H:i:s"),
                ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        }
    }
}
