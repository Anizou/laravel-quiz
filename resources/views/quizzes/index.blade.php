@extends('layouts/master')

@section('content')
    <h1>Quizzes</h1>

    <div class="pull-right">
        <a href="{{ route('quizzes.create') }}" class="btn btn-primary">+ New Quiz</a>
        <a href="{{ route('questions.index') }}" class="btn btn-primary">Question List</a>
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
    @foreach($quizzes as $quiz)
        <tr>
            <td>{{ $quiz->id }}</td>
            <td>{{ $quiz->name }}</td>
            <td>{{ $quiz->created_at }}</td>
            <td>
                <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('quizzes.score', $quiz->id) }}" class="btn btn-primary">Score</a>
            </td>
        </tr>
    @endforeach
        </tbody>
    </table>

    {!! $quizzes->render() !!}


@stop
