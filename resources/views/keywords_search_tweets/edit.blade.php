@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center text-center">
    
        <div class="w-75 mt-5">

        
            <div class="text-black-50 text-center mt-5">
                <h1>編集画面</h1>
            </div>
            <p><a href="{{ route('keywords_search_tweets.index')}}">一覧画面</a></p>
             
            @if ($message = Session::get('success'))
            <p>{{ $message }}</p>
            @endif
             
            @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
             
            <form action="{{ route('keywords_search_tweets.update',$keywords_search_tweets->id)}}" method="POST">
                @csrf
                @method('PUT')
                <p>キーワード：<input type="text" name="keyword" value="{{ $keywords_search_tweets->keyword }}"></p>
                {{--<p>実行時刻：<input type="text" name="executed_at" value="{{ $keywords_search_tweets->executed_at }}"></p>--}}
                <input type="submit" value="反映する">
            </form>
            
        </div>
    </div>
@endsection
 