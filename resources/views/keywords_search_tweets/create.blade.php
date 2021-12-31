@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center text-center">
    
        <div class="w-75 mt-5">
        
            <div class="text-black-50 text-center mt-5">
                <h1>新規作成画面</h1>
            </div>
            <p><a href="{{ route('keywords_search_tweets.index')}}">一覧画面</a></p>
             
            @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
             
            <form action="{{ route('keywords_search_tweets.store')}}" method="POST">
                @csrf
                <p>キーワード：<input type="text" name="keyword" value="{{old('keyword')}}"></p>
                {{--<p>実行時刻：<input type="time" name="executed_at" value="{{old('executed_at')}}"></p>--}}
                <input type="submit" value="登録する">
            </form>
            
        </div>
    </div>
@endsection
 