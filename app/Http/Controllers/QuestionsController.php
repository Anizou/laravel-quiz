<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::orderBy('id', 'desc')->paginate();

        return view('questions.index', compact('questions'));
    }

    public function show(Request $request, $id)
    {
        $post = $this->api('posts.show', $id)->get();

        event(new UserViewingPost($post));

        return view('posts.show', compact('post'));
    }

    public function create(Request $request)
    {
        return view('questions.create');
    }

    public function store(Request $request)
    {
        $question = Question::create([
            'question' => $request->input('question'),
            'answer' => $request->input('answer')
        ]);

        return redirect()->route('questions.index');
    }

    public function edit(Request $request, $id)
    {
        $question = Question::find($id);

        return view('questions.edit', compact('question'));
    }

    public function update(Request $request, $id)
    {
        Question::find($id)->update([
            'question' => $request->input('question'),
            'answer' => $request->input('answer')
        ]);

        return redirect()->route('questions.index');
    }
}
