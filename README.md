# TwitterApp
 
Twitter APIでツイートを取得し、可視化するツール。

# Features
 
* Laravel7で拡張性が高め。
* ローカル環境のDBにツイートデータを蓄積させられる。
* TwitterOAuthでv1.1のみでなくv2にも対応可能（コード修正必要）。 

# Requirement

* Laravel 7
* cron
* Twitter API 

# Installation

```bash
git clone git@github.com:arv0614/twitter_app.git
cd twitter_app
composer install
sudo chmod -R 777 storage
sudo chmod -R 777 bootstrap/cache
sudo chmod -R 776 database
touch database/database.sqlite
sudo chmod -R 777 database/database.sqlite 
sudo chmod -R 777 storage/logs
php artisan migrate
php artisan key:generate
php artisan serve
```
```bash
cp .env.sample .env 
vi .env 
—以下を追加
TWITTER_CLIENT_KEY=<developer.twitter.comで取得>
TWITTER_CLIENT_SECRET=<developer.twitter.comで取得>
TWITTER_CLIENT_ID_ACCESS_TOKEN=<developer.twitter.comで取得>
TWITTER_CLIENT_ID_ACCESS_TOKEN_SECRET=<developer.twitter.comで取得>
—
```
```bash
sudo crontab -e
—
* * * * * cd <Laravelプログラム本体の場所> && php artisan schedule:run >> /dev/null 2>&1
—
```

# Usage

以下コマンドでデモサーバ起動。　http://127.0.0.1:8000 にブラウザでアクセスする。

```bash
cd twitter_app
php artisan serve
```
# Note

* developer.twitter.comでトークン取得するのに2時間くらいかかります。
* サブディレクトリ運用ではpublic/に.htaccessを設置すれば運用できます。
  * [Laravelサブディレクトリ運用](https://qiita.com/yyano/items/a0d141a91ba8d867985e)
* resources/views/analytics.blade.php はアクセス解析用のトラッキングコードです。必ず書き換えてご利用ください。

# References

* [Twitter API v1.1](https://developer.twitter.com/en/docs/twitter-api/v1/tweets/search/api-reference/get-search-tweets)
* [get-tweets-search-recent](https://developer.twitter.com/en/docs/twitter-api/tweets/search/api-reference/get-tweets-search-recent)
* [Laravel7 DB設定](https://readouble.com/laravel/7.x/ja/database.html)
* [CRUD実装](https://noumenon-th.net/programming/2020/01/30/laravel-crud/)
* [EloquentORM](https://readouble.com/laravel/7.x/ja/eloquent.html)
* [コマンドライン化&cron登録](https://engineer-lady.com/program_info/laravel-cron/)
* [ログイン機能](https://mebee.info/2020/04/21/post-10081/)
* [Form](https://qiita.com/manbolila/items/b364088e821f4c946229)
* [Mail](https://readouble.com/laravel/5.7/ja/mail.html)
* [Gmailから配信](https://qiita.com/hideno0110/items/e06b986684b274b392ca)
* [ページネーション](https://pgmemo.tokyo/data/archives/1278.html)
* [グラフ（Chart.js）](https://note.com/laravelstudy/n/ne41d086745bc)
* [Laravel初期設定、デバッグ](https://www.petitmonte.com/php/laravel_project.html)
* [ロゴ](https://hatchful.shopify.com/ja/)
* [favicon設置](https://qiita.com/mineaki27th/items/0e841d10b2571ba67f6b)
* [csv出力](https://snome.jp/framework/laravel-csv/)

# Author

* 作成者 KAI KINOSHITA
* E-mail arv0614@gmail.com

# License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
