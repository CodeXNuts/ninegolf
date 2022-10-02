<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubRating;
use App\Models\ClubRatingReply;
use Exception;
use Illuminate\Http\Request;

class ClubRatingReplyController extends Controller
{
    
    public function create(Club $club, ClubRating $clubRating, Request $request)
    {
        $this->authorize('create',['App\ClubRatingReply',$club]);

        $this->validate($request,[
            'replyComment' => 'required'
        ]);

        try {

            $isReplyInserted = ClubRatingReply::create([
                'user_id' => auth()->id(),
                'club_rating_id' => $clubRating->id,
                'comment' =>$request->replyComment
            ]);

            if (!empty($isReplyInserted->id)) {
                $res = [
                    'key' => 'success',
                    'msg' => 'Your have replied'
                ];
            } else {
                $res = [
                    'key' => 'fail',
                    'msg' => 'Your reply can not be posted'
                ];
            }
        } catch (Exception $e) {
            $res = [
                'key' => 'fail',
                'msg' => 'Your reply can not be posted'
            ];
        }

        return back()->with($res['key'],$res['msg']);
    }
}
