@extends('layouts/master')

@section('content')
    <h1>Create New Question</h1>
    <form method="POST" action="{{ route('questions.store') }}">
        {!! csrf_field() !!}

        <div class="form-group">
            <label for="question">Question</label>
            <input type="text" name="question" value="{{ old('question') }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="answer">Answer</label>
            <input type="text" name="answer" value="{{ old('answer') }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-success pull-right">Create</button>
    </form>
@stop
