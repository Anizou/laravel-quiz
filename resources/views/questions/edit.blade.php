@extends('layouts/master')

@section('content')
    <h1>Edit Question</h1>
    <form method="POST" action="{{ route('questions.update', $question) }}">
        {!! csrf_field() !!}
        {!! method_field('put') !!}

        <div class="form-group">
            <label for="question">Question</label>
            <input type="text" name="question" value="{{ old('question', $question->question) }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="answer">Answer</label>
            <input type="text" name="answer" value="{{ old('answer', $question->answer) }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-success pull-right">Edit</button>
    </form>
@stop
