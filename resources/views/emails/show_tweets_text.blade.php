{{$search_word }} のツイート一覧
{{ route('show_tweets',['search_word' => $search_word]) }}

@foreach($arrays as $index => $array)
<?php
        $d = new DateTime($array['created_at']);
        $d->modify('+9 hour');
        $u = new DateTime($array['updated_at']);
?>
----【# {{ $index+1 }} 】----------------
URL: https://twitter.com/{{ $array['user_screen_name'] }}/status/{{ $array['id'] }}
---
{{ $array['text'] }}
---
UserDetail: {{ route('show_users') }}?search_word={{ $array['user_screen_name'] }}"
screen_name: {{ $array['user_screen_name'] }}
imp: <?php echo $search_imp[$array['id_str']] ?? "";  ?>
RT: {{ $array['retweet_count'] }}
fav: {{ $array['favorite_count'] }}
-----------------------------------

@endforeach
