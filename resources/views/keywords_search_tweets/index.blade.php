@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center text-center">
    
        <div class="w-75 mt-5">
            
            <div class="text-black-50 text-center mt-5">
                <h1>一覧画面</h1>
            </div>
            <p><a href="{{ route('keywords_search_tweets.create') }}">新規追加</a></p>
             
            @if ($message = Session::get('success'))
            <p>{{ $message }}</p>
            @endif
             
            <table class="table mt-5  text-left">
                <tr>
                    <th>ID</th>
                    <th>keyword</th>
                    <th>詳細</th>
                    <th>一覧</th>
                    <th>csv</th>
                    <th>編集</th>
                    <th>削除</th>
                </tr>
                @foreach ($keywords_search_tweets as $keywords_search_tweet)
                <tr>
                    <td>{{ $keywords_search_tweet->id }}</td>
                    <td>{{ $keywords_search_tweet->keyword }}</td>
                    <th><a href="{{ route('keywords_search_tweets.show',$keywords_search_tweet->id)}}">詳細</a></th>
                    <th><a href="{{ route('show_tweets',['search_word' => $keywords_search_tweet->keyword]) }}" target="_blank">一覧</a></th>
                    <th><a href="{{ route('csv_tweets') }}?search_word={{ $keywords_search_tweet->keyword }}" target="_blank">csv</a></th>
                    <th><a href="{{ route('keywords_search_tweets.edit',$keywords_search_tweet->id)}}">編集</a></th>
                    <th>
                        <form action="{{ route('keywords_search_tweets.destroy', $keywords_search_tweet->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" name="" value="削除">
                        </form>
                    </th>
                </tr>
                @endforeach
            </table>

        </div>
    </div>
@endsection
 