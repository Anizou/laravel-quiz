<?php

namespace App\Http\Controllers;

use App\Question;
use App\Quiz;
use Illuminate\Http\Request;

class QuizzesController extends Controller
{
    public function index(Request $request)
    {
        $quizzes = Quiz::orderBy('id', 'desc')->paginate();

        return view('quizzes.index', compact('quizzes'));
    }

    public function show(Request $request, $id)
    {
        $post = $this->api('posts.show', $id)->get();

        event(new UserViewingPost($post));

        return view('posts.show', compact('post'));
    }

    public function create(Request $request)
    {
        return view('quizzes.create');
    }

    public function store(Request $request)
    {
        $quiz = Quiz::create([
            'name' => $request->input('name')
        ]);

        return redirect()->route('quizzes.index');
    }

    public function edit(Request $request, $id)
    {
        $quiz = Quiz::find($id);
        $selectedQuestions = array_pluck($quiz->questions()->get()->toArray(), 'id');
        $questions = Question::all();

        return view('quizzes.edit', compact('quiz', 'selectedQuestions', 'questions'));
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::find($id);

        $quiz->update([
            'name' => $request->input('name')
        ]);

        $quiz->questions()->sync($request->input('questions') ?: []);

        return redirect()->route('quizzes.index');
    }

    public function score(Request $request, $id)
    {
        $quiz = Quiz::find($id);

        // 정답인지 자동 체크
        foreach($quiz->questions as $question) {
            $answer = $quiz->answers()->where('question_id', $question->id)->first();
            if ($answer) {
                if (is_null($answer->correct) && $answer->answer === $question->answer) {
                    $answer->correct = true;
                    $answer->save();
                }
            }
        }

        return view('quizzes.show', compact('quiz'));
    }

    public function fixScore(Request $request, $id)
    {
        $quiz = Quiz::find($id);

        $quiz->question_count = $quiz->questions->count();
        $quiz->correct_count = $quiz->answers()->where('correct', 1)->count();
        $quiz->scored = true;
        $quiz->save();

        return redirect()->route('quizzes.index');
    }
}
