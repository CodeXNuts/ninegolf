<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubRating;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;

class ClubRatingController extends Controller
{

    public function create(Club $club, Request $request)
    {   

       $this->authorize('create',['App\ClubRating',$club]);
        
        $this->validate($request, [
            'inputRating' => 'required|numeric|max:5',
            'reviewComment' => 'required'
        ]);

        try {

            $isRatingInserted = ClubRating::create([
                'user_id' => auth()->id(),
                'club_id' => $club->id,
                'rating' => $request->inputRating,
                'comment' =>$request->reviewComment
            ]);

            if (!empty($isRatingInserted->id)) {
                $res = [
                    'key' => 'success',
                    'msg' => 'Your rating has been submitted successfully'
                ];
            } else {
                $res = [
                    'key' => 'fail',
                    'msg' => 'Your rating could not been submitted'
                ];
            }
        } catch (Exception $e) {
            $res = [
                'key' => 'fail',
                'msg' => 'Your rating could not been submitted'
            ];
        }

        return back()->with($res['key'],$res['msg']);
    }
}
