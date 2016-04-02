@extends('layouts/master')

@section('content')
    <h1>Edit Quiz</h1>
    <form method="POST" action="{{ route('quizzes.update', $quiz) }}">
        {!! csrf_field() !!}
        {!! method_field('put') !!}

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ old('name', $quiz->name) }}" class="form-control">
        </div>

        @foreach($questions as $question)
        <div class="checkbox">
            <label><input type="checkbox" name="questions[]"
                          @if(in_array($question->id, $selectedQuestions))
                                  checked="true"
                          @endif
                          value="{{ $question->id }}">{{ $question->id . ':' . $question->question . ':' . $question->answer }}</label>
        </div>
        @endforeach

        <button type="submit" class="btn btn-success pull-right">Edit</button>
    </form>
@stop
