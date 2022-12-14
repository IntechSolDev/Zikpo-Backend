<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Question;
use App\Models\QuestionComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuestionCommentController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 404;
    public $invalidStatus = 401;


    public function view($id)
    {
        $comment_data = [];
        $comments = QuestionComment::with('user')->where([['question_id',$id],['reply_to',null]])->get();
        $all_comment = CommentResource::collection($comments);
        if($comments->isNotEmpty())
        {
            return response()->json(['comments'=>$all_comment,'message' => 'Comment created successfully', 'status' => 'success'], 200);
        }
        else{
            return response()->json(['message' => 'Comment was not created ', 'status' => 'error'], 401);
        }
    }



    public function addCommentQuestion(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $validator = Validator::make($input,[
            'comment' => 'required',
            'question_id' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input['user_id']= $user->id;
        $comment = QuestionComment::create($input);
        $get_question = Question::find($request->question_id);
        if($comment)
        {

            // FireBase
            $message = "$request->comment";
            $data_array = [
                'title' => "Comment on your Post",
                'body' => $message,
                'comment'=>$request->comment,
                'type' => 'comment',
                'user' => $user,
                'question_id' => $request->question_id,
                'question_data'=> $get_question,
                'description' => $message
            ];


            return response()->json(['message' => 'Comment created successfully', 'status' => 'success'], 200);

        }
        else{
            return response()->json(['message' => 'Comment was not created ', 'status' => 'error'], 401);

        }
    }


}
