<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    public function correct(Request $request, $quizId, $answerId)
    {
        $answer = Answer::find($answerId);
        $answer->correct = true;
        $answer->save();

        return redirect()->route('quizzes.score', $quizId);
    }

    public function wrong(Request $request, $quizId, $answerId)
    {
        $answer = Answer::find($answerId);
        $answer->correct = false;
        $answer->save();

        return redirect()->route('quizzes.score', $quizId);
    }
}
