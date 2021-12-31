<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class MailSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:MailSend {--search_word=} {--base_date=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'メール送信するコマンド';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if($this->option('search_word')){
            $search_word = $this->option('search_word');
        }else{
            $search_word="ymd_723";
        }
        if($this->option('base_date')){
            $tmp_base_date=strtotime($this->option('base_date'));
            $base_date=date("Y-m-d 00:00:00",$tmp_base_date);
        }else{
            $base_date = date("Y-m-d");
        }
        $tmp_from_date=strtotime($base_date." -9 hours");
        $from_date=date("Y-m-d H:i:s", $tmp_from_date);
        $tmp_to_date=strtotime($from_date." +24 hours");
        $to_date=date("Y-m-d H:i:s", $tmp_to_date);
        $paginate_num = 1000;
        
        $twitter_controller = new \App\Http\Controllers\TwitterController();
        $tw_tweet = $twitter_controller->search_word_tweets($search_word, $from_date, $to_date, $paginate_num);
        
        $array_tweet_ids = "";
        foreach($tw_tweet as $index => $array){
            if($index >= 1){$array_tweet_ids .= ',';}
            $array_tweet_ids .= "'".$array['id_str']."'";
        }
        
        if($array_tweet_ids != ""){
            $search_imp = $twitter_controller->search_imp_tweets($array_tweet_ids);
            $array_search_imp = array();
            foreach($search_imp as $index => $array){
                $array_search_imp[$array->id_str] = $array->imp;
            }
        }else{
            $array_search_imp = null;
        }
        
        // 配送処理
        $to = [config('mail.from.address')];
        $formed_date = strtotime($base_date);
        $title = date("Y年m月d日",$formed_date).'のツイート：'.$search_word;
        $template_html='emails.show_tweets';
        $template_text='emails.show_tweets_text';
        
        $data = ['arrays' => $tw_tweet, 'search_word' => $search_word, 'search_imp' => $array_search_imp];
        
        Mail::to($to)->send(new \App\Mail\TwitterNotification($title, $data, $template_html, $template_text));
        
        $this->line('[Done]command:MailSend - command '.$search_word.' - search_word');
        //\Log::info('[Done]command:MailSend - command '.$search_word.' - search_word');
        return 0;
    }
}
