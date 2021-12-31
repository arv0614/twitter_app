@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center text-center">
    
        <div class="col col-md-12 mt-5">
            <div class="text-black-50 text-center mt-5">
                <h1>ユーザ一覧</h1>
            </div>
            
            {{ Form::open(['method'=>'get', 'url'=>'/show_users']) }}
            {{ Form::label('search_word', '検索ワード', ['class'=>'search_word']) }}
            {{ Form::text('search_word',  $search_word ) }}
            {{ Form::close() }}
            <p><a href="{{ route('show_tweets') }}">ツイート一覧</a></p>
            
            <div class="row flex-row flex-nowrap overflow-auto">
                {!! $arrays->appends(['search_word' => $search_word])->render() !!}
            </div>
            
            <table class="table table-responsive mt-5  text-left">
                <thead>
                    <tr>
                        <th>created_at</th>
                        <th>profile_image</th>
                        <th>screen_name</th>
                        <th>graph</th>
                        <th>description</th>
                        <th>followers_count</th>
                        <th>friends_count</th>
                    </tr>
                </thead>
                
                <tbody>
                @foreach($arrays as $index => $array)
                <tr>
                    <td><?php $d = new DateTime($array['created_at']); echo $d->format('m/d H:i'); ?></td>
                    <td class="text-center"><a href="https://twitter.com/{{ $array['screen_name'] }}" target="_blank"><img src="{{ $array['profile_image_url_https'] }}"  class="img-fluid rounded-circle" alt="Responsive image"></a></td>
                    <td>{{ $array['name'] }}(<a href="{{ route('show_users',['search_word' => $array['screen_name'] ]) }}">{{ $array['screen_name'] }}</a>)</td>
                    <td><a href="{{ route('show_users_graph') }}?search_word={{ $array['screen_name'] }}">推移</a></td>
                    <td>{{ $array['description'] }}</td>
                    <td>{{ $array['followers_count'] }}</td>
                    <td>{{ $array['friends_count'] }}</td>
                    
                </tr>
                @endforeach
                </tbody>
            </table>
            
            <div class="row flex-row flex-nowrap overflow-auto">
                {!! $arrays->appends(['search_word' => $search_word])->render() !!}
            </div>
            
        </div>
    </div>
</div>
@endsection
