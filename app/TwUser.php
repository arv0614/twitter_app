<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwUser extends Model
{
    /**
     * テーブルの主キー
     *
     * @var bigInteger
     */
    protected $primaryKey = 'uniqu_key';
    protected $guarded = ['uniqu_key']; //１つのカラムを書き込み禁止（必須のブラックリスト）
}
