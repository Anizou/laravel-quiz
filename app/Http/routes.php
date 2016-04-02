<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/quizzes', 'QuizzesController');
Route::get('/quizzes/{id}/score', ['as' => 'quizzes.score', 'uses' => 'QuizzesController@score']);
Route::get('/quizzes/{id}/fixscore', ['as' => 'quizzes.fixscore', 'uses' => 'QuizzesController@fixScore']);
Route::get('/quizzes/{id}/answer/{answer_id}/correct', ['as' => 'answer.correct', 'uses' => 'AnswersController@correct']);
Route::get('/quizzes/{id}/answer/{answer_id}/wrong', ['as' => 'answer.wrong', 'uses' => 'AnswersController@wrong']);
Route::resource('/questions', 'QuestionsController');
Route::resource('/play', 'PlayController');
Route::resource('/result', 'ResultController');
