@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    
        <div class="w-75 mt-5">
            <div class="text-black-50 text-center mt-5">
                <h1>ユーザ編集</h1>
            </div>
            
            {{ Form::open(['method'=>'get', 'url'=>'/edit_users']) }}
            {{ Form::label('search_word', '検索ワード', ['class'=>'search_word']) }}
            {{ Form::text('search_word',  $search_word ) }}
            {{ Form::close() }}
            <p><a href="{{ route('show_tweets') }}">ツイート一覧</a></p>
            
            <table class="table mt-5  text-left">                            
                <thead>
                    <tr>
                        <th>submit</th>
                        <th>uniqu_key</th>
                        <th>name</th>
                        <th>screen_name</th>
                        <th>description</th>
                        <th>followers_count</th>
                        <th>friends_count</th>
                    </tr>
                </thead>
                
                <tbody>
                @foreach($arrays as $index => $array)
                {{ Form::model($array, ['method'=>'post', 'url'=>'/edit_users']) }}
                <tr>
                    <td>{{ Form::button('登録', ['type' => 'submit', 'onfocus' => 'this.blur();']) }}</td>
                    <td>{{ $array['uniqu_key'] }}</td>
                    <td>{{ Form::text('name', null, ['placeholder'=>'入力してください']) }}</td>
                    <td>{{ Form::text('screen_name', null, ['placeholder'=>'入力してください']) }}</td>
                    <td>{{ Form:: textarea('description', null, ['placeholder' => '入力してください', 'rows' => '5']) }}</td>
                    <td>{{ Form::text('followers_count', null, ['placeholder'=>'入力してください']) }}</td>
                    <td>{{ Form::text('friends_count', null, ['placeholder'=>'入力してください']) }}</td>
                </tr>
                {{ Form::close() }}
                @endforeach
                </tbody>
            </table>
                        
        </div>
        
    </div>
@endsection
 