@extends('layouts/master')

@section('content')
    <h1>{{ $quiz->name }}</h1>

    @if($quiz->scored)
        <h2>전체 문항수 : <span class="label label-success">{{ $quiz->question_count }}</span></h2>
        <h2>정답 문항수 : <span class="label label-success">{{ $quiz->correct_count }}</span></h2>
        <h2><span class="label label-success">{{  (int)($quiz->correct_count * 100 / $quiz->question_count) }} 점</span></h2>
    @else
    <h3>다음 단어의 뜻을 입력하세요</h3>
    @endif

    <form method="POST" action="{{ route('play.store') }}" class="form-horizontal">
        {!! csrf_field() !!}
        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

        <?php
        $count = 1;
        $answers = $answers->keyBy('question_id');
        ?>

        @unless($quiz->scored)
            @foreach($quiz->questions as $question)
            <div class="form-group">
                <label class="control-label col-sm-1">{{ ($count++) }}</label>
                <label class="control-label col-sm-3 markdown" style="text-align:left;" for="answer_{{ $question->id }}">{{ $question->question }}</label>
                <div class="col-sm-8">
                    <input type="ext" class="form-control" name="answer_{{ $question->id }}" id="answer_{{ $question->id }}"
                           value="{{ isset($answers[$question->id]) ? $answers[$question->id]->answer : '' }}" placeholder="뜻 입력">
                </div>
            </div>
            @endforeach

            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8">
                    <button type="submit" class="btn btn-success">정답 등록하기</button>
                </div>
            </div>
        @else

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
                    <label class="control-label col-sm-3 markdown" style="text-align:left;" for="answer_{{ $question->id }}">{{ $question->question }}</label>
                    <div class="col-sm-6">
                        <input type="ext" class="form-control" name="answer_{{ $question->id }}" id="answer_{{ $question->id }}"
                                value="{{ $answer ? $answer->answer : '' }}" placeholder="뜻 입력">
                        @unless($correct)
                            <i class="form-control-feedback glyphicon glyphicon-remove"></i>
                            <div class="help-block with-errors">{{ $question->answer }}</div>
                        @endunless
                    </div>
                </div>
            @endforeach
        @endif
    </form>
@stop

