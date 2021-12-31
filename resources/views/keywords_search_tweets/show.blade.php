@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center text-center">
    
        <div class="w-75 mt-5">
        
            <div class="text-black-50 text-center mt-5">
                <h1>詳細画面</h1>
            </div>
            <p><a href="{{ route('keywords_search_tweets.index')}}">一覧画面</a></p>
             
            <table class="table mt-5  text-left">
                <tr>
                    <th>id</th>
                    <th>keyword</th>
                    <th>executed_at</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                </tr>
                <tr>
                    <td>{{ $keywords_search_tweets->id }}</td>
                    <td>{{ $keywords_search_tweets->keyword }}</td>
                    <td>{{ $keywords_search_tweets->executed_at }}</td>
                    <td>{{ $keywords_search_tweets->created_at }}</td>
                    <td>{{ $keywords_search_tweets->updated_at }}</td>
                </tr>
            </table>
        
        </div>
    </div>
</div>
@endsection
 