@extends('layouts/master')

@section('content')
    <canvas class="blur" src="/images/yumin1.jpg"></canvas>

    {{--
    Full Page Background Image Blur
    http://codepen.io/bbodine1/pen/vcjed/
    --}}
    <style>
    body {
        background: #fff;
    }
    </style>

    <script>
        CanvasImage = function (e, t) {
            this.image = t;
            this.element = e;
            e.width = t.width;
            e.height = t.height;
            this.context = e.getContext("2d");
            this.context.drawImage(t, 0, 0);
        };

        CanvasImage.prototype = {
            blur:function(e) {
                this.context.globalAlpha = 0.5;
                for(var t = -e; t <= e; t += 2) {
                    for(var n = -e; n <= e; n += 2) {
                        this.context.drawImage(this.element, n, t);
                        var blob = n >= 0 && t >= 0 && this.context.drawImage(this.element, -(n -1), -(t-1));
                    }
                }
            }
        };

        $(function() {
            $(".blur").css({
                "min-width":"100%",
                "max-width":"100%",
                "min-height":"100%",
                "max-height":"100%",
                "position":"fixed",
                "top":"0",
                "left":"0",
                "z-index":"-2",
                "opacity":"0.7"
            });
            var image, canvasImage, canvas;
            $(".blur").each(function() {
                canvas = this;
                image = new Image();
                image.onload = function() {
                    canvasImage = new CanvasImage(canvas, this);
                    canvasImage.blur(8);
                };
                image.src = $(canvas).attr("src");
            });
        });

    </script>

    <h1 class="title">{{ $quiz->name }}</h1>

    @if($quiz->scored)
        <h2>전체 문항수 : <span class="label label-success">{{ $quiz->question_count }}</span></h2>
        <h2>정답 문항수 : <span class="label label-success">{{ $quiz->correct_count }}</span></h2>
        <h2><span class="label label-success">{{  (int)($quiz->correct_count * 100 / $quiz->question_count) }} 점</span></h2>
    @else
    <h2 class="subtitle text-center" style="margin:40px;">다음 단어의 뜻을 입력하세요</h2>
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
                <label class="control-label col-sm-3 markdown question" style="text-align:left;" for="answer_{{ $question->id }}">{{ $question->question }}</label>
                <div class="col-sm-1 audio">
                    @if(!str_contains($question->question, ' '))
                        <a href="http://www.dictionary.com/browse/{{ $question->question }}" data-remote="false" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-headphones text-danger"></i></a>
                    @endif
                </div>
                <div class="col-sm-7">
                    <input type="ext" class="form-control answer" name="answer_{{ $question->id }}" id="answer_{{ $question->id }}"
                           @if(!str_contains($question->question, ' '))
                           readonly="true"
                           @endif
                           value="{{ isset($answers[$question->id]) ? $answers[$question->id]->answer : '' }}" placeholder="뜻 입력">
                </div>
            </div>
            @endforeach

            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8">
                    <button type="submit" class="btn btn-success btn-lg">정답 등록하기</button>
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
                    <label class="control-label col-sm-3 markdown question" style="text-align:left;" for="answer_{{ $question->id }}">{{ $question->question }}</label>
                    <div class="col-sm-1 audio">
                        @if(!str_contains($question->question, ' '))
                        <a href="http://www.dictionary.com/browse/{{ $question->question }}" data-remote="false" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-headphones text-success"></i></a>
                        @endif
                    </div>
                    <div class="col-sm-5">
                        <input type="ext" class="form-control answer" name="answer_{{ $question->id }}" id="answer_{{ $question->id }}"
                                readonly="true" value="{{ $answer ? $answer->answer : '' }}" placeholder="뜻 입력" autocomplete="off">
                        @unless($correct)
                            <i class="form-control-feedback glyphicon glyphicon-remove"></i>
                            <div class="help-block with-errors">{{ $question->answer }}</div>
                        @endunless
                    </div>
                </div>
            @endforeach
        @endif
    </form>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">발음 듣기</h4>
                </div>
                <div class="modal-body">
                    <iframe src="" width="99.6%" height="800" frameborder="0"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <style>
        .title, .subtitle {
            color: black;
            -webkit-text-fill-color: white; /* Will override color (regardless of order) */
            -webkit-text-stroke-width: 1px;
            -webkit-text-stroke-color: black;
        }

        .audio {
            font-size:35px;
        }

        .form-group {
            font-size:20px;
        }

        .modal-dialog,
        .modal-content {
            /* 80% of window height */
            height: 90%;
        }

        .modal-body {
            /* 100% = dialog height, 120px = header + footer */
            max-height: calc(100% - 120px);
            overflow-y: scroll;
        }
    </style>
    <script>
        // http://stackoverflow.com/questions/19663555/bootstrap-3-how-to-load-content-in-modal-body-via-ajax
        // Fill modal with content from link href
        $("#myModal").on("show.bs.modal", function(e) {
            var $link = $(e.relatedTarget);
            $(this).find("iframe").attr("src", $link.attr("href"));
            @unless($quiz->scored)
                $link.parents('.form-group').find('.answer').attr('readonly', false);
            @endunless
        });
    </script>
@stop

