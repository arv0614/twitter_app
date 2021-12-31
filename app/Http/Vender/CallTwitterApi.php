<?php

namespace App\Http\Vender;

use Illuminate\Http\Request;
use Abraham\TwitterOAuth\TwitterOAuth;
use Carbon\Carbon;

use App\Http\TwTweet;

class CallTwitterApi
{
    
    private $t;
    
    public function __construct()
    {
        $this->t = new TwitterOAuth(
            config('app.twitter_client_key'),
            config('app.twitter_client_secret'),
            config('app.twitter_client_id_access_token'),
            config('app.twitter_client_id_access_token_secret')
            );
    }
    
    // ツイート検索&取得
    public function getRecentSerachTweets($search_word)
    {
        //$latest_tweet_id = \App\TwTweet::where('text', 'LIKE', "%".$search_word."%")->orderBy('id', 'desc')->first()->id ?? 0 ;
        $latest_tweet_id = \App\TwTweet::orderBy('created_at', 'desc')->first()->id ?? 0 ;
        
        $search_word = str_replace(" ", "%20", $search_word);
        //$search_word = "\"".$search_word."\"";
        // RTを除く
        $search_word = $search_word."%20exclude:retweets";
        
        //$latest_tweet_id = \App\TwTweet::max('id');
        $d = $this->t->get("search/tweets", [
            'q' => $search_word,
            'count' => 100, //v1.1は100が最大
            'result_type' => 'recent',
            'lang' => 'ja',
            //'since_id' => $latest_tweet_id,
         ]);
         
         foreach($d->statuses  as $index =>  $status) {
            
            $write_data = \App\TwTweet::updateOrCreate(
                ['id' => $status->id],
                [ //'id' => $status->id ?? null,
                  'id_str' => $status->id_str ?? null,
                  'text' => $status->text ?? null,
                  'truncated' => $status->truncated ?? null,
                  //'entities' => $status->entities ?? null, {#272 ▶}
                  //'metadata' => $status->metadata ?? null, {#274 ▶}
                  'source' => $status->source ?? null, 
                  'in_reply_to_status_id' => $status->in_reply_to_status_id ?? null,
                  'in_reply_to_status_id_str' => $status->in_reply_to_status_id_str ?? null,
                  'in_reply_to_user_id' => $status->in_reply_to_user_id ?? null,
                  'in_reply_to_user_id_str' => $status->in_reply_to_user_id_str ?? null,
                  'in_reply_to_screen_name' => $status->in_reply_to_screen_name ?? null,
                  'user_id_str' => $status->user->id_str ?? null, //TwUser tableを参照
                  'user_screen_name' => $status->user->screen_name ?? null,
                  'geo' => $status->geo->place->id ?? null, //geoオブジェクトの一部(placeid指定)
                  'coordinates' => "[".($status->coordinates->longitude ?? null).",".($status->coordinates->latitude ?? null)."]", //緯度軽度
                  'place' => $status->place->full_name ?? null, //placeオブジェクトの一部のみ
                  'contributors' => $status->contributors ?? null,
                  //'retweeted_status' => $status->retweeted_status ?? null, {#278 ▶}
                  'is_quote_status' => $status->is_quote_status ?? null, 
                  'retweet_count' => $status->retweet_count ?? null,
                  'favorite_count' => $status->favorite_count ?? null,
                  'favorited' => $status->favorited ?? null,
                  'retweeted' => $status->retweeted ?? null,
                  'lang' => $status->lang ?? null,
                  'created_at' => Carbon::parse($status->created_at)->format('Y-m-d H:i:s') ?? null,
                ]);
                
            $write_data_2 = \App\TwUser::updateOrCreate(
                ['id' => $status->user->id, 'followers_count' => $status->user->followers_count, 'friends_count' => $status->user->friends_count],
                [ 'id_str' => $status->user->id_str ?? null,
                  'name' => $status->user->name ?? null,
                  'screen_name' => $status->user->screen_name ?? null,
                  'location' => $status->user->location ?? null,
                  'description' => $status->user->description ?? null,
                  'url' => $status->user->url ?? null,
                  'protected' => $status->user->protected ?? null,
                  'followers_count' => $status->user->followers_count ?? null,
                  'friends_count' => $status->user->friends_count ?? null,
                  'listed_count' => $status->user->listed_count ?? null,
                  'favourites_count' => $status->user->favourites_count ?? null,
                  'utc_offset' => $status->user->utc_offset ?? null,
                  'time_zone' => $status->user->time_zone ?? null,
                  'geo_enabled' => $status->user->geo_enabled ?? null,
                  'verified' => $status->user->verified ?? null,
                  'statuses_count' => $status->user->statuses_count ?? null,
                  'lang' => $status->user->lang ?? null,
                  'contributors_enabled' => $status->user->contributors_enabled ?? null,
                  'is_translator' => $status->user->is_translator ?? null,
                  'is_translation_enabled' => $status->user->is_translation_enabled ?? null,
                  'profile_background_color' => $status->user->profile_background_color ?? null,
                  'profile_background_image_url' => $status->user->profile_background_image_url ?? null,
                  'profile_background_image_url_https' => $status->user->profile_background_image_url_https ?? null,
                  'profile_background_tile' => $status->user->profile_background_tile ?? null,
                  'profile_image_url' => $status->user->profile_image_url ?? null,
                  'profile_image_url_https' => $status->user->profile_image_url_https ?? null,
                  'profile_banner_url' => $status->user->profile_banner_url ?? null,
                  'profile_link_color' => $status->user->profile_link_color ?? null,
                  'profile_sidebar_border_color' => $status->user->profile_sidebar_border_color ?? null,
                  'profile_sidebar_fill_color' => $status->user->profile_sidebar_fill_color ?? null,
                  'profile_text_color' => $status->user->profile_text_color ?? null,
                  'profile_use_background_image' => $status->user->profile_use_background_image ?? null,
                  'has_extended_profile' => $status->user->has_extended_profile ?? null,
                  'default_profile' => $status->user->default_profile ?? null,
                  'default_profile_image' => $status->user->default_profile_image ?? null,
                  'following' => $status->user->following ?? null,
                  'follow_request_sent' => $status->user->follow_request_sent ?? null,
                  'notifications' => $status->user->notifications ?? null,
                  'translator_type' => $status->user->translator_type ?? null,
                ]);
             
        }
        
        \Log::info('[Done]getRecentSerachTweets ('.count($d->statuses).' record upsert) → - search_word:'.$search_word);
        
        return $d->statuses;
    }
    
}