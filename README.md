## laravel8-umarche

## ダウンロード方法

git clone https://github.com/kentakki416/laravel8-umarche.git

もしくは、zip ファイルでダウンロードしてください。

## インストール方法

cd laravel8_umarche
composer install
npm install
npm run dev

.env.example をコピーして、.env ファイルを作成

開発環境で DB を起動した後に、

php artisan migrate:fresh --seed

と実行してください。（データベーステーブルとダミーデータが追加されれば OK）

最後に,
composer ではなく、git を用いて install した際に、env ファイルの APP_KEY が作成されず動かないので、
php artisan key:gerenerate
でキーを作成後、

php artisan serve で簡易サーバーを立ち上げる。

## インストール後の実施事項

画像のダミーデータは
public/images フォルダ内に
sample1.jpg ~ sample6.jpg として
保存されています。

php artisan storage:link で
storage フォルダにリンク後、

storage/app/public/products フォルダ内に保存すると
表示されます。
(products フォルダがない場合は作成してください)

ショップの画像も表示する場合は、
storage/app/public/shops フォルダを作成し、画像を保存してください
