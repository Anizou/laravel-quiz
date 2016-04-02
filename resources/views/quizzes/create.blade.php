@extends('layouts/master')

@section('content')
    <h1>Create New Quiz</h1>
    <form method="POST" action="{{ route('quizzes.store') }}">
        {!! csrf_field() !!}

        <div class="form-group">
            <label for="question">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-success pull-right">Create</button>
    </form>
@stop
