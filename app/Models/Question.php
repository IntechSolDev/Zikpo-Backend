<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\QuestionComment;
use App\Models\QuestionLike;
use App\Models\QuestionShare;
use App\Models\QuestionHash;
use App\Models\Expertise;
use Illuminate\Support\Facades\Auth;
class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'file',
        'file_type',
        'description',
        'thumbnail'
    ];

    public function getFileAttribute($value)
    {
        if($value == null)
        {
            return null;
        }
        else
        {
            return asset('/public/assets/images/question/' . $value);
        }

    }

    public function getThumbnailAttribute($value)
    {
        if($value == null)
        {
            return null;
        }
        else
        {
            return asset('/public/assets/images/question-thumbnail/' . $value);
        }

    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function response()
    {
        return $this->hasMany(Response::class,'question_id','id')->with(['likes','comments','user']);
    }
    public function comments()
    {
        return $this->hasMany(QuestionComment::class,'question_id','id')->with('user');
    }
     public function likes()
    {
        return $this->hasMany(QuestionLike::class,'question_id','id')->with('user');
    }

    public function getExpertes($id)
    {
      $experties_ids = QuestionHash::where('question_id',$id)->pluck('experties_id');
      $all_expertes = Expertise::whereIn('id',$experties_ids)->pluck('title');
      if(isset($all_expertes))  {return $all_expertes; }else{ return null;}
    }

    public function isLike($id)
    {
      $is_like = QuestionLike::where([['question_id',$id],['user_id',Auth::user()->id]])->first();
      if(isset($is_like))  {return true; }else{ return false;}
    }

      public function isComment($id)
    {
      $is_comment = QuestionComment::where([['question_id',$id],['user_id',Auth::user()->id]])->first();
      if(isset($is_comment))  {return true; }else{ return false;}
    }
      public function isShare($id)
    {
      $is_share = QuestionShare::where([['question_id',$id],['user_id',Auth::user()->id]])->first();
      if(isset($is_share))  {return true; }else{ return false;}
    }

}
