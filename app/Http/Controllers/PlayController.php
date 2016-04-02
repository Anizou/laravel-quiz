<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlayController extends Controller
{
    public function show(Request $request, $id)
    {
        $quiz = Quiz::find($id);
        $answers = $quiz->answers;

        return view('play.show', compact('quiz', 'answers'));
    }

    public function store(Request $request)
    {
        $all = $request->all();
        foreach($all as $key => $value) {
            if (Str::startsWith($key, 'answer_')) {
                list($dummy, $questionId) = explode('_', $key);

                $answer = Answer::firstOrNew([
                    'quiz_id' => $request->input('quiz_id'),
                    'question_id' => $questionId
                ]);

                if ($value) {
                    $answer->answer = $value;
                    $answer->save();
                }
            }
        }

        return redirect()->route('play.show', $request->input('quiz_id'));
    }
}
