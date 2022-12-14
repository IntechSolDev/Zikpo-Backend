<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expertise;
use App\Models\QuestionHash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
   //Response Status
    public $success = 200;
    public $error = 404;
    public $validate_error = 401;

    // View All Question of Login User
    public function getAllQuestion()
    {
        $user = Auth::user();
        $questions = Question::where('user_id',$user->id)->with(['user','response','comments'])->latest()->get();
        $question_list = QuestionResource::collection($questions);
        if($questions)
        {
            return response()->json([
                'data'=>$question_list,
                'message' => 'Question Data.',
                'status'=>'success',
            ],$this->success);
        }
        return response()->json([
            'data'=>['data'=>[]],
            'message' => 'Question Data not Found.',
            'status'=>'success',
        ],$this->success);
    }

    // View Detail Question
    public function getDetailQuestion($id)
    {
        $user = Auth::user();
        $questions = Question::where('id',$id)->with(['user','response','comments'])->first();
        $question_list = QuestionResource::make($questions);
        if($questions)
        {
            return response()->json([
                'data'=>$question_list,
                'message' => 'Question Data.',
                'status'=>'success',
            ],$this->success);
        }
        return response()->json([
            'data'=>['data'=>[]],
            'message' => 'Question Data not Found.',
            'status'=>'success',
        ],$this->success);
    }

    // Add New Question
    public function addQuestion(Request $request)
    {
        try {
                $user = Auth::user();
                $validator = Validator::make($request->all(), [
                    'file' => 'required',
                    'file_type' => 'required',
                ]);

                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors(), 'status' => 'error', 'validaterror' => "1"], 401);
                }

            if ($request->hasFile('file')) {
                //upload new file
                $extension = $request->file->extension();
                $filename = time() . "_." . $extension;
                $request->file->move(public_path('/assets/images/question'), $filename);
                $input['file'] = $filename;
            }
            if ($request->hasFile('thumbnail')) {
                //upload new file
                $extension = $request->thumbnail->extension();
                $filename = time() . "_." . $extension;
                $request->thumbnail->move(public_path('/assets/images/question-thumbnail'), $filename);
                $input['thumbnail'] = $filename;
            }
            $input['user_id'] = $user->id;
            $input['file_type'] = $request->file_type;
            $input['description'] = $request->description;

            $question = Question::create($input);

            if ($request->expertise) {
                $expertise = $request->expertise;
                foreach($expertise as $expert)
                {
                    $experties = Expertise::find($expert);
                    if($experties)
                    {
                        QuestionHash::updateOrCreate(['question_id'=>$question->id,'title'=>$experties->title,'experties_id'=>$experties->id,'user_id'=>$user->id]);
                    }

                }
            }

            if($question)
            {
                return response()->json([
                    'message' => 'New Question addded successfully',
                    'status'=>'success',
                ],$this->success);
            }
            return response()->json([
                'message' => 'Question Data not inserted',
                'status'=>'error',
            ],$this->error);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 'error'], $this->error);

        }
    }


}
