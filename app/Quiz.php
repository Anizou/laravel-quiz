<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'quizzes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public function questions()
    {
        return $this->belongsToMany('App\Question')->withTimestamps();
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }
}
