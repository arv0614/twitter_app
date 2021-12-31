<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\KeywordsSearchTweets;

class GetTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:GetTweets {--search_word=} {--table_name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'GetTweetsを実行するコマンド';

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
        $t = new \App\Http\Vender\CallTwitterApi();
        
        if($this->option('table_name')){
            $table_name = $this->option('table_name');
            $this->line('[Start]batch:GetTweets - command '.$table_name.' - table_name');
            \Log::info('[Start]batch:GetTweets - command '.$table_name.' - table_name');
            
            $keywords_search_tweets = KeywordsSearchTweets::all();
            foreach ($keywords_search_tweets as $keywords_search_tweet){
                $search_word = $keywords_search_tweet->keyword;
                $d = $t->getRecentSerachTweets($search_word);
                $this->line('[Done]batch:GetTweets - command '.$search_word.' - search_word');
                sleep(5); //APIのコール回数制限に合わせる
            }
            $this->line('[End]batch:GetTweets - command '.$table_name.' - table_name');
            \Log::info('[End]batch:GetTweets - command '.$table_name.' - table_name');
            //return 1;
        }else{
            if($this->option('search_word')){
                $search_word = $this->option('search_word');
            }else{
                $search_word="ymd_723";
            }
            $d = $t->getRecentSerachTweets($search_word);
            
            //return $d;
        }
    }
}
