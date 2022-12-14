<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionHomeResource;
use App\Models\Question;
use App\Models\QuestionComment;
use App\Models\QuestionLike;
use App\Models\UserExpertise;
use App\Models\QuestionHash;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //Response Status
    public $success = 200;
    public $error = 404;
    public $validate_error = 401;

    // View All Question of Login User
    public function getHomeData()
    {
        $user = Auth::user();
        $questions = Question::query();
        $latest_questions = $questions;
        $foryou=[];
        $foryou_questions=[];


        //Trending
        $question_response =  Response::select('question_id', DB::raw('COUNT(question_id) as count'))
            ->groupBy('question_id')
            ->orderBy('count', 'desc')
            ->pluck('question_id');
        $question_comment =  QuestionComment::select('question_id', DB::raw('COUNT(question_id) as count'))
            ->groupBy('question_id')
            ->orderBy('count', 'desc')
            ->pluck('question_id');
        $question_like =  QuestionLike::select('question_id', DB::raw('COUNT(question_id) as count'))
            ->groupBy('question_id')
            ->orderBy('count', 'desc')
            ->pluck('question_id');

        if($question_response->isNotEmpty())
        {

            $trending = Question::whereIn('id',$question_response)->get();
        }
        else if($question_comment->isNotEmpty())
        {
            $trending = Question::whereIn('id',$question_comment)->get();
        }
        else if($question_like->isNotEmpty())
        {
            $trending = Question::whereIn('id',$question_like)->get();
        }
        else
        {
            $trending = Question::take(5)->get();

        }


        $latest =  Question::latest()->take(5)->get();

        $trending_list = QuestionHomeResource::collection($trending);

        //Latest
        $latest_list = QuestionHomeResource::collection($latest);


        //Foryou
        $get_user_expertise = UserExpertise::where('user_id',$user->id)->pluck('expertises_id');

        if(isset($get_user_expertise))
        {
            foreach($get_user_expertise as $user_exp)
            {
                $question_hash = QuestionHash::where('experties_id',$user_exp)->pluck('question_id');
                foreach($question_hash as $qh)
                {
                    if (!in_array($qh, $foryou_questions))
                    {
                        $foryou_questions[] = $qh;
                    }
                }
            }

        }

        if(count($foryou_questions) > 0)
        {
            $foryou_question = Question::whereIn('id',$foryou_questions)->latest()->take(5)->get();
        }
        else
        {
            $foryou_question = Question::latest()->take(5)->get();
        }
        $foryou_list = QuestionHomeResource::collection($foryou_question);

        return response()->json([
            'trending'=> isset($trending_list)  ? $trending_list : [],
            'foryou'=>isset($foryou_list)  ? $foryou_list : [],
            'latest'=> isset($latest_list)  ? $latest_list : [],
            'message' => 'Home Data.',
            'status'=>'success',
        ],$this->success);

    }

    // View Foryou Questions
    public function getForyouData()
    {
        $user = Auth::user();
        $questions = Question::query();
        $foryou=[];
        $foryou_questions=[];

        //Foryou
        $get_user_expertise = UserExpertise::where('user_id',$user->id)->pluck('expertises_id');

        if(isset($get_user_expertise))
        {
            foreach($get_user_expertise as $user_exp)
            {
                $question_hash = QuestionHash::where('experties_id',$user_exp)->pluck('question_id');
                foreach($question_hash as $qh)
                {
                    if (!in_array($qh, $foryou_questions))
                    {
                        $foryou_questions[] = $qh;
                    }
                }
            }

        }
        if(count($foryou_questions) > 0)
        {
            $foryou_question = Question::whereIn('id',$foryou_questions)->latest()->get();
        }
        else
        {
            $foryou_question = Question::latest()->get();
        }

        $foryou_list = QuestionHomeResource::collection($foryou_question);

        return response()->json([
            'foryou'=>isset($foryou_list)  ? $foryou_list : [],
            'message' => 'Foryou Data.',
            'status'=>'success',
        ],$this->success);

    }

    // View Trending Questions
    public function getTrendingData()
    {
        $user = Auth::user();
        $questions = Question::query();

        //Trending
        $question_response =  Response::select('question_id', DB::raw('COUNT(question_id) as count'))
            ->groupBy('question_id')
            ->orderBy('count', 'desc')
            ->pluck('question_id');
        $question_comment =  QuestionComment::select('question_id', DB::raw('COUNT(question_id) as count'))
            ->groupBy('question_id')
            ->orderBy('count', 'desc')
            ->pluck('question_id');
        $question_like =  QuestionLike::select('question_id', DB::raw('COUNT(question_id) as count'))
            ->groupBy('question_id')
            ->orderBy('count', 'desc')
            ->pluck('question_id');

        if($question_response->isNotEmpty())
        {
            $trending = Question::whereIn('id',$question_response)->get();
        }
        else if($question_comment->isNotEmpty())
        {
            $trending = Question::whereIn('id',$question_comment)->get();
        }
        else if($question_like->isNotEmpty())
        {
            $trending =Question::whereIn('id',$question_like)->get();
        }
        else
        {
            $trending = Question::get();
        }


        $trending_list = QuestionHomeResource::collection($trending);

        return response()->json([
            'trending'=> isset($trending_list)  ? $trending_list : [],
            'message' => 'Trending Data',
            'status'=>'success',
        ],$this->success);

    }

    // View Latest Question
    public function getLatestData()
    {
        $user = Auth::user();
        $questions = Question::query();
        $latest_questions = $questions;

        $latest =  $latest_questions->latest()->get();

        //Latest
        $latest_list = QuestionHomeResource::collection($latest);


        return response()->json([
            'latest'=> isset($latest_list)  ? $latest_list : [],
            'message' => 'Home Data.',
            'status'=>'success',
        ],$this->success);

    }






    // User Online
    public function user_online(Request $request){
        $user = Auth::user();
        $status = $request->status;
        User::where('id', $user->id)->update(['status' => $status, 'last_seen' => now()]);
        return "Success";
    }






}
