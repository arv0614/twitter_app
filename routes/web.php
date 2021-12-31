<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('show_tweets', 'TwitterController@show_search_word_tweets')->name("show_tweets");
Route::get('show_tweets_graph', 'TwitterController@show_search_word_tweets_graph')->name("show_tweets_graph");
Route::get('csv_tweets', 'TwitterController@csv_search_word_tweets')->name("csv_tweets");

Route::get('show_users', 'TwitterController@show_search_word_users')->name("show_users");
Route::get('show_users_graph', 'TwitterController@show_search_word_users_graph')->name("show_users_graph");

/* 送信メール本文のプレビュー */
/*Route::get('sample/mailable/preview', function () {
  return new App\Mail\TwitterNotification();
}); */

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home'); /* Auth::routes();での認証処理に含まれているらしい https://hiroslog.com/post/110 */
Route::get('get_tweets', 'TwitterController@get_recent_search_tweets')->name("get_tweets")->middleware('auth');
/* Route::get('edit_users', 'TwitterController@edit_search_word_users')->name("edit_users")->middleware('auth'); */
/* Route::get('send_mail', 'TwitterController@send_mail')->name("send_mail")->middleware('auth'); */
Route::resource('/keywords_search_tweets', 'KeywordsSearchTweetsController')->middleware('auth');

