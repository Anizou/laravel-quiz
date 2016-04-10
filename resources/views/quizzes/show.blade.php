@extends('layouts/master')

@section('content')
    <h1>{{ $quiz->name }}</h1>

    <h3>다음 단어의 뜻을 입력하세요</h3>

    <form method="POST" action="{{ route('play.store') }}" class="form-horizontal">
        {!! csrf_field() !!}
        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

        <?php
        $count = 1;
        $answers = $quiz->answers;
        $answers = $answers->keyBy('question_id');
        ?>

        @foreach($quiz->questions as $question)
            <?php
            $answer = isset($answers[$question->id]) ? $answers[$question->id] : null;
            $correct = $answer && $answer->correct;
            ?>
        <div class="form-group
            @unless($correct)
                has-feedback has-error
            @endunless
        ">
            <label class="control-label col-sm-1">{{ ($count++) }}</label>
            <label class="control-label col-sm-3" style="text-align:left;" for="answer_{{ $question->id }}">
                {{ $question->question }}
                @if($question->example)
                    <span class="markdown">```ex) {{ $question->example }}```</span>
                @endif
            </label>
            <div class="col-sm-7">
                <input type="ext" class="form-control" name="answer_{{ $question->id }}" id="answer_{{ $question->id }}"
                       value="{{ $answer ? $answer->answer : '' }}" placeholder="뜻 입력">
            @unless($correct)
                <i class="form-control-feedback glyphicon glyphicon-remove"></i>
                <div class="help-block with-errors">{{ $question->answer }}</div>
            @endunless
            </div>
            <div class="col-sm-1">
                @if($correct)
                    <a href="{{ route('answer.wrong', [$quiz->id, $answer->id]) }}" class="btn btn-danger">Wrong</a>
                @elseif($answer)
                    <a href="{{ route('answer.correct', [$quiz->id, $answer->id]) }}" class="btn btn-primary">Correct</a>
                @endif
            </div>
        </div>
        @endforeach

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <a href="{{ route('quizzes.fixscore', $quiz->id) }}" class="btn btn-primary">Fix Score</a>
            </div>
        </div>
    </form>
@stop

