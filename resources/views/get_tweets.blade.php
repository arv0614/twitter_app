@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center text-center">
    
        <div class="w-75 mt-5">
            <div class="text-black-50 text-center mt-5">
                 <h1>以下のデータ取得完了</h1>
            </div>
            
            {{ Form::open(['method'=>'get', 'url'=>'/get_tweets']) }}
            {{ Form::label('search_word', '検索ワード', ['class'=>'search_word']) }}
            {{ Form::text('search_word',  $search_word ) }}
            {{ Form::close() }}
            
            <table class="table mt-5">                            
                <tbody>
                @foreach($arrays as $index => $array)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td><a href="https://twitter.com/{{ $array->user->screen_name }}/status/{{ $array->id }}">{{ $array->id }}</a></td>
                    <td><a href="https://twitter.com/{{ $array->user->screen_name }}">{{ $array->user->screen_name }}</a></td>
                    <td>{{ $array->text }}</td>
                    <td><?php $d = new DateTime($array->created_at);$d->modify('+9 hour'); echo $d->format('Y年m月d日 H時i分s秒'); ?></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
 