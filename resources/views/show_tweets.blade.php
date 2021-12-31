@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center text-center">

        <div class="col col-md-12 mt-5">
            <div class="text-black-50 text-center mt-5">
                <h1>ツイート一覧</h1>
            </div>
            
            {{ Form::open(['method'=>'get', 'url'=>'/show_tweets']) }}
            {{ Form::label('search_word', '検索ワード', ['class'=>'search_word']) }}
            {{ Form::text('search_word',  $search_word ) }}
            {{ Form::close() }}
            <p><a href="{{ route('show_tweets_graph') }}?search_word={{ $search_word }}">ツイート数推移グラフ</a></p>
            <p><a href="{{ route('show_users') }}">ユーザ一覧</a></p>
            <p><a href="{{ route('csv_tweets') }}?search_word={{ $search_word }}" target="_blank">csv</a></p>
            
            <div class="row flex-row flex-nowrap overflow-auto">
                {!! $arrays->appends(['search_word' => $search_word])->render() !!}
            </div>
            
            <table class="table table-responsive mt-5  text-left">
                <thead>
                    <tr>
                        <th>index</th>
                        <th>created_at</th>                        
                        <th>text</th>
                        <th>screen_name</th>
                        <th>source</th>
                        <th>imp</th>
                        <th>retweet_count</th>
                        <th>favorite_count</th>
                    </tr>
                </thead>
                
                <tbody>
                @foreach($arrays as $index => $array)
                <?php
                        $d = new DateTime($array['created_at']);
                        $d->modify('+9 hour');
                        $u = new DateTime($array['updated_at']);
                        //$u->modify('+9 hour');
                        // 検索ワードを強調する
                        $emphasize_text = $array['text'];
                        if( isset($search_word) && $search_word != ""){
                            $search_word_array = explode(" ", $search_word);
                            foreach($search_word_array  as $value){
                                $emphasize_text = str_replace($value,"<b style='background-color:yellow;'>".$value."</b>",$emphasize_text);
                            }
                        }
                ?>
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td><a href="https://twitter.com/{{ $array['user_screen_name'] }}/status/{{ $array['id'] }}" target="_blank">{{ $d->format('m/d H:i') }}</a> ({{ $u->format('m/d H:i') }})</td>
                    <td><?= $emphasize_text ?></td>
                    <td><a href="{{ route('show_users') }}?search_word={{ $array['user_screen_name'] }}">{{ $array['user_screen_name'] }}</a></td>
                    <td><?= $array['source'] ?></td>
                    <td><?php echo $search_imp[$array['id_str']] ?? "";  ?></td>
                    <td>{{ $array['retweet_count'] }}</td>
                    <td>{{ $array['favorite_count'] }}</td>
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
 