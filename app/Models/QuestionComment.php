<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'question_id',
        'user_id',
        'comment',
        'like',
        'reply_to',
        'is_hide',
    ];
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
