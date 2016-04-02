<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['quiz_id', 'question_id', 'answer'];

    public function quiz()
    {
        return $this->belongsTo('App\Quiz');
    }
}
