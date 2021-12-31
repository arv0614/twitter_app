<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <style type="text/css">
    <!--
    table{
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
    }
    
    table tr{
      border-bottom: solid 1px #eee;
      cursor: pointer;
    }
    
    table tr:hover{
      background-color: #d4f0fd;
    }
    
    table th,table td{
      text-align: center;
      width: 25%;
      padding: 15px 0;
    }
    
    table td.icon{
      background-size: 35px;
      background-position: left 5px center;
      background-repeat: no-repeat;
      padding-left: 30px;
    }
    
    table td.icon.bird{
      background-image: url(icon-bird.png)
    }
    
    table td.icon.whale{
      background-image: url(icon-whale.png)
    }
    
    table td.icon.crab{
      background-image: url(icon-crab.png)
    }
    -->
    </style>

</head>

<body>
            <p><a href="{{ route('show_tweets',['search_word' => $search_word]) }}" target="_blank">ツイート一覧</a></p>
            
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="max-width:640px;">
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
                            $emphasize_text = str_replace($search_word,"<b style='background-color:yellow;'>".$search_word."</b>",$emphasize_text);
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


</body>
</html>