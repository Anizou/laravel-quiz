@extends('layouts/master')

@section('content')
    <h1>Questions</h1>

    <div class="pull-right">
        <a href="{{ route('questions.create') }}" class="btn btn-primary">+ New Question</a>
        <a href="{{ route('quizzes.index') }}" class="btn btn-primary">Quiz List</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
    @foreach($questions as $question)
        <tr>
            <td>{{ $question->id }}</td>
            <td>{{ $question->question }}</td>
            <td>{{ $question->created_at }}</td>
            <td>
                <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-primary">Edit</a>
            </td>
        </tr>
    @endforeach
        </tbody>
    </table>

    {!! $questions->render() !!}


@stop
