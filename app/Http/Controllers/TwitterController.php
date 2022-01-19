<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Vender\CallTwitterApi;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class TwitterController extends Controller
{
    // TwitterAPIからデータ取得&DB保存
    public function get_recent_search_tweets(Request $request)
    {
        $search_word="ymd_723";
        if($request->input('search_word')){
          $search_word=$request->input('search_word');
        }
        
        $t = new CallTwitterApi();
        $d = $t->getRecentSerachTweets($search_word);
        return view('get_tweets', ['arrays' => $d, 'search_word' => $search_word]);
    }
    
    // tweet表示
    public function show_all_tweets()
    {
        $tw_tweet = \App\TwTweet::orderBy('created_at', 'desc')->paginate(100);
        return view('show_tweets', ['arrays' => $tw_tweet]);
    }
    
    // tweet取得
    public function search_word_tweets($search_word, $from, $to, $paginate_num = 100)
    {
        $word_count = 1;
        if(strpos($search_word," ") !== false){
          $ArraySearchWord = explode (" ",$search_word);
          $word_count = count($ArraySearchWord);
        }
        
        if($word_count == 1){
           $tw_tweet = \App\TwTweet::where('text', 'LIKE', "%$search_word%")
           //->orWhere('user_id_str', 'LIKE', "%$search_word%")
           //->orWhere('user_screen_name', 'LIKE', "%$search_word%")
           ->where('created_at', '>=', $from)
           ->where('created_at', '<=', $to)
           ->orderBy('created_at', 'desc')->paginate($paginate_num);
        }else if($word_count == 2){
           $tw_tweet = \App\TwTweet::where('text', 'LIKE', "%$ArraySearchWord[0]%")
           //->orWhere('user_id_str', 'LIKE', "%$ArraySearchWord[0]%")
           //->orWhere('user_screen_name', 'LIKE', "%$ArraySearchWord[0]%")
           ->where('text', 'LIKE', "%$ArraySearchWord[1]%")
           //->orWhere('user_id_str', 'LIKE', "%$ArraySearchWord[1]%")
           //->orWhere('user_screen_name', 'LIKE', "%$ArraySearchWord[1]%")
           ->where('created_at', '>=', $from)
           ->where('created_at', '<=', $to)
           ->orderBy('created_at', 'desc')->paginate($paginate_num);
        }else if($word_count == 3){
           $tw_tweet = \App\TwTweet::where('text', 'LIKE', "%$ArraySearchWord[0]%")
           //->orWhere('user_id_str', 'LIKE', "%$ArraySearchWord[0]%")
           //->orWhere('user_screen_name', 'LIKE', "%$ArraySearchWord[0]%")
           ->where('text', 'LIKE', "%$ArraySearchWord[1]%")
           //->orWhere('user_id_str', 'LIKE', "%$ArraySearchWord[1]%")
           //->orWhere('user_screen_name', 'LIKE', "%$ArraySearchWord[1]%")
           ->where('text', 'LIKE', "%$ArraySearchWord[2]%")
           //->orWhere('user_id_str', 'LIKE', "%$ArraySearchWord[2]%")
           //->orWhere('user_screen_name', 'LIKE', "%$ArraySearchWord[2]%")
           ->where('created_at', '>=', $from)
           ->where('created_at', '<=', $to)
           ->orderBy('created_at', 'desc')->paginate($paginate_num);
        }else{
           $tw_tweet = \App\TwTweet::where('text', 'LIKE', "%$search_word%")
           ->where('user_id_str', 'LIKE', "%$search_word%")
           ->where('user_screen_name', 'LIKE', "%$search_word%")
           ->where('created_at', '>=', $from)
           ->where('created_at', '<=', $to)
           ->orderBy('created_at', 'desc')->paginate($paginate_num);
        }
        
        return $tw_tweet;
    }
    
    // tweet imp取得
    public function search_imp_tweets($array_tweet_ids)
    {
       $sql = "
       SELECT tw_tweets.id_str, count(distinct tw_tweets.text) AS cnt, MAX(followers_count) AS imp FROM `tw_tweets` 
        LEFT JOIN `tw_users` ON tw_tweets.user_id_str = tw_users.id_str 
        WHERE tw_tweets.id_str IN (".$array_tweet_ids.") 
        GROUP BY tw_tweets.id_str 
        ORDER BY tw_tweets.id_str DESC";
       
       //$tw_tweets = DB::table('tw_tweets');
       //$arrays = $tw_tweets->select(DB::raw($sql))->get();
       $arrays = DB::select($sql);
       return $arrays;
    }
    
    // tweet表示
    public function show_search_word_tweets(Request $request)
    {
        $search_word=" "; $from="2010-01-01 00:00:00"; $to="2200-01-01 23:59:59";
        if($request->input('search_word') && $request->input('search_word') != ""){
          $search_word=$request->input('search_word');
          if($request->input('from') && $request->input('from') != ""){
              $tmp_from=strtotime($request->input('from')." -9 hours");
               $from=date("Y-m-d 00:00:00",$tmp_from);
               if($request->input('to') && $request->input('to') != ""){
                   $tmp_to=strtotime($request->input('to')." -9 hours");
                   $to=date("Y-m-d 23:59:59",$tmp_to);
               }
          }
        }
        
        $paginate_num = 100;
        $tw_tweet = $this->search_word_tweets($search_word, $from, $to, $paginate_num);
        
        $array_tweet_ids = "";
        foreach($tw_tweet as $index => $array){
            if($index >= 1){$array_tweet_ids .= ',';}
            $array_tweet_ids .= "'".$array['id_str']."'";
        }
        if($array_tweet_ids != ""){
            $search_imp = $this->search_imp_tweets($array_tweet_ids);
        
            $array_search_imp = array();
            foreach($search_imp as $index => $array){
                $array_search_imp[$array->id_str] = $array->imp;
            }
            
        }else{
            $array_search_imp = null;
        }
        return view('show_tweets', ['arrays' => $tw_tweet, 'search_word' => $search_word, 'search_imp' => $array_search_imp]);
    }
    
    // tweetグラフ表示
    public function show_search_word_tweets_graph(Request $request)
    {
        $search_word="";
        $tmp_to=date("Y-m-d H:i:s");
        $tmp_from=date("Y-m-d H:i:s",strtotime("-15 day"));
        
        if($request->input('search_word') && $request->input('search_word') != ""){
           $search_word=$request->input('search_word');
           if($request->input('from') && $request->input('from') != ""){
               $tmp_from=strtotime($request->input('from'));
               if($request->input('to') && $request->input('to') != ""){
                   $tmp_to=strtotime($request->input('to'));
               }
           }
       }else{
           $search_word="";
           $tmp_from=date("Y-m-d H:i:s",strtotime("-1 day"));
       }
           
       $search_option = "";
       $ArraySearchWord = explode (" ",$search_word);
       foreach($ArraySearchWord as $SearchWord){
           $search_option .= " AND text LIKE '%".$SearchWord."%'";
      }
      
      $to=date("Y-m-d H:i:s",strtotime($tmp_to." -9 hours"));
      $from=date("Y-m-d H:i:s",strtotime($tmp_from." -9 hours"));
      $index_option_tw_tweets = " tw_tweets.created_at >= '".$from."' AND tw_tweets.created_at <= '".$to."'";
      $index_option_tw_users = " tw_users.updated_at >= '".$from."' AND tw_users.updated_at <= '".$to."'";
          
      if( config('database.default') == "sqlite" ){
          $sql = "SELECT * FROM (SELECT STRFTIME('%Y-%m-%d %H',DATETIME(tw_tweets.created_at, 'localtime')) AS time, count(distinct tw_tweets.text) AS cnt, SUM(followers_count) AS imp, SUM(retweet_count) AS cnt_rt, SUM(favorite_count) AS cnt_favorite FROM `tw_tweets` LEFT JOIN (SELECT tw_users.id_str, tw_users.followers_count FROM `tw_users` LEFT JOIN (SELECT id_str, max(created_at) AS max_created_at FROM `tw_users` GROUP BY id_str) tmp ON tw_users.id_str = tmp.id_str WHERE tw_users.created_at = tmp.max_created_at  GROUP BY tw_users.id_str,followers_count) tmp2 ON tw_tweets.user_id_str = tmp2.id_str WHERE text NOT LIKE 'RT @%' ".$search_option." GROUP BY time ORDER BY time DESC LIMIT 336) sub ORDER BY time ASC";
      }else{
          $sql = "SELECT * FROM (
             SELECT DATE_FORMAT(DATE_ADD(tw_tweets.created_at, INTERVAL 9 HOUR), '%Y-%m-%d %H') AS time, count(distinct tw_tweets.text) AS cnt, MAX(followers_count) AS imp, SUM(retweet_count) AS cnt_rt, SUM(favorite_count) AS cnt_favorite 
             FROM `tw_tweets` 
             LEFT JOIN (SELECT id_str, followers_count as followers_count FROM `tw_users` WHERE ".$index_option_tw_users.")tmp
             ON tw_tweets.user_id_str = tmp.id_str 
            WHERE text NOT LIKE 'RT @%' ".$search_option." AND ".$index_option_tw_tweets."
            GROUP BY time ORDER BY time DESC LIMIT 336) sub 
        ORDER BY time ASC";
      }
      $arrays = DB::select($sql);        
      return view('show_tweets_graph', ['arrays' => $arrays, 'search_word' => $search_word]);
    }
    
    // tweetCSV出力
    public function csv_search_word_tweets(Request $request)
    {
        $search_word=" "; $from="2000-01-01"; $to="2200-01-01";
        if($request->input('search_word') && $request->input('search_word') != ""){
          $search_word=$request->input('search_word');
          if($request->input('from') && $request->input('from') != ""){
              $tmp_from=strtotime($request->input('from')." -9 hours");
               $from=date("Y-m-d H:i:s",$tmp_from);
               if($request->input('to') && $request->input('to') != ""){
                   $tmp_to=strtotime($request->input('to')." -9 hours");
                   $to=date("Y-m-d H:i:s",$tmp_to);
               }
          }
        }
        
        $paginate_num = 10000;
        $tw_tweet = $this->search_word_tweets($search_word, $from, $to, $paginate_num);
        
        // データの作成
         $tweets = array();
         foreach ($tw_tweet as $array){
             $tweets[] = array(
                'tweet_url' => "https://twitter.com/".$array['user_screen_name']."/status/".$array['id_str'],
                'id' => $array['id'],
                'id_str' => $array['id_str'],
                'text' => mb_ereg_replace('"', '""', $array['text']),
                'truncated' => $array['truncated'],
                'source' => strip_tags($array['source']), 
                'in_reply_to_status_id' => $array['in_reply_to_status_id'],
                'in_reply_to_status_id_str' => $array['in_reply_to_status_id_str'],
                'in_reply_to_user_id' => $array['in_reply_to_user_id'],
                'in_reply_to_user_id_str' => $array['in_reply_to_user_id_str'],
                'in_reply_to_screen_name' => $array['in_reply_to_screen_name'],
                'user_id_str' => $array['user_id_str'],
                'user_screen_name' => $array['user_screen_name'],
                'geo' => $array['geo'],
                'coordinates' => $array['coordinates'],
                'place' => $array['place'],
                'contributors' => $array['contributors'],
                'is_quote_status' => $array['is_quote_status'], 
                'retweet_count' => $array['retweet_count'],
                'favorite_count' => $array['favorite_count'],
                'favorited' => $array['favorited'],
                'retweeted' => $array['retweeted'],
                'lang' => $array['lang'],
                'created_at' => $array['created_at'],
             );
          }
         // カラムの作成
         $head = [
            'tweet_url',
            'id',
            'id_str',
            'text',
            'truncated',
            'source',
            'in_reply_to_status_id',
            'in_reply_to_status_id_str',
            'in_reply_to_user_id',
            'in_reply_to_user_id_str',
            'in_reply_to_screen_name',
            'user_id_str',
            'user_screen_name',
            'geo',
            'coordinates',
            'place',
            'contributors',
            'is_quote_status',
            'retweet_count',
            'favorite_count',
            'favorited',
            'retweeted',
            'lang',
            'created_at',
         ];
    
         // 書き込み用ファイルを開く
         $file_name = 'tweets.csv';
         $file_path = storage_path('app/public/'.$file_name);
         $f = fopen($file_path, 'w');
         if ($f) {
             // カラムの書き込み
             mb_convert_variables('SJIS', 'UTF-8', $head);
             fputcsv($f, $head);
             // データの書き込み
             foreach ($tweets as $tweet) {
                mb_convert_variables('SJIS', 'UTF-8', $tweet);
                fputcsv($f, $tweet);
             }
         }
         // ファイルを閉じる
         fclose($f);
    
         // HTTPヘッダ
         header("Content-Type: application/octet-stream");
         header('Content-Length: '.filesize($file_path));
         header('Content-Disposition: attachment; filename='.$file_name);
         readfile($file_path);
    }
    
    // User表示
    public function show_all_users()
    {
        $tw_user = \App\TwUser::orderBy('created_at', 'desc')->paginate(100);
        return view('show_users', ['arrays' => $tw_user]);
    }
    
    // User表示
    public function show_search_word_users(Request $request)
    {
        if($request->input('search_word') && $request->input('search_word') != ""){
          $search_word=$request->input('search_word');
          $tw_user = \App\TwUser::where('screen_name', 'LIKE', "%$search_word%")
          ->orWhere('name', 'LIKE', "%$search_word%")
          ->orWhere('description', 'LIKE', "%$search_word%")
          ->orderBy('created_at', 'desc')
          ->paginate(100);
        }else{
          $search_word="";
          $tw_user = \App\TwUser::orderBy('created_at', 'desc')
          ->paginate(100);
        }
        return view('show_users', ['arrays' => $tw_user, 'search_word' => $search_word]);
    }
    
    // Userグラフ表示
    public function show_search_word_users_graph(Request $request)
    {
        if($request->input('search_word') && $request->input('search_word') != ""){
           $search_word=$request->input('search_word');
       }else{
           $search_word="";
       }
       
       if( config('database.default') == "sqlite" ){
          $sql = "SELECT * FROM (
         SELECT tw_users.id_str, tw_users.screen_name, STRFTIME('%Y-%m-%d %H',DATETIME(created_at, 'localtime')) AS created_day , AVG(tw_users.followers_count) AS followers_count , AVG(tw_users.friends_count) AS friends_count , AVG(tw_users.listed_count) AS listed_count, AVG(tw_users.favourites_count) AS favourites_count 
         FROM `tw_users` 
        WHERE tw_users.screen_name LIKE '%".$search_word."%' 
        GROUP BY tw_users.id_str,created_day,screen_name
        ORDER BY created_day DESC LIMIT 336) sub ORDER BY created_day ASC";
      }else{
          $sql = "SELECT * FROM (
         SELECT tw_users.id_str, tw_users.screen_name, DATE_FORMAT(created_at, '%Y-%m-%d %H') AS created_day , AVG(tw_users.followers_count) AS followers_count , AVG(tw_users.friends_count) AS friends_count , AVG(tw_users.listed_count) AS listed_count, AVG(tw_users.favourites_count) AS favourites_count 
         FROM `tw_users` 
        WHERE tw_users.screen_name LIKE '%".$search_word."%' 
        GROUP BY tw_users.id_str,created_day,screen_name
        ORDER BY created_day DESC LIMIT 336) sub ORDER BY created_day ASC";
      }
       
       $arrays = DB::select($sql);
                
        return view('show_users_graph', ['arrays' => $arrays, 'search_word' => $search_word]);
    }
    
    // User編集
    public function edit_search_word_users(Request $request)
    {
        if($request->input('search_word') && $request->input('search_word') != ""){
          $search_word=$request->input('search_word');
          $tw_user = \App\TwUser::where('screen_name', 'LIKE', "%$search_word%")->orderBy('created_at', 'desc')->paginate(100);
        }else{
          $search_word="";
          $tw_user = \App\TwUser::orderBy('created_at', 'desc')->paginate(100);
        }
        return view('edit_users', ['arrays' => $tw_user, 'search_word' => $search_word]);
    }


}