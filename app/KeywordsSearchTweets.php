<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeywordsSearchTweets extends Model
{
    //
    protected $guarded = ['id']; //１つのカラムを書き込み禁止（必須のブラックリスト）
}
