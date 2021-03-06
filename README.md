## laravel8-umarche

## DEMO
[デモ](https://kentakki.com/login)

ログインアカウント
| アカウント | メールアドレス | パスワード|
----|----| ---|
| 一般ユーザー | test@test.com | password123 |
| オーナー　(url:/owner/login) | test2@test.com | password123|
| 管理者　(url:/admin/login) | test1@test.com | password123|

一般ユーザー画面

![トップ画面](images/top.png)
![カート画面](images/cart.png)
![詳細画面](images/view.png)

オーナー画面
![店舗情報画面](images/shop.png)
![店舗詳細画面](images/detail.png)
![画像管理画面](images/image.png)
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

## 補足

決済のテストとして stript を利用しています。
メールのテストとして mailtrap を利用しています。
必要な場合は.env に情報を追記してください

メール処理には時間がかかるため、
キューを利用して非同期で実装しています。

必要な場合は、php artisan queue:work で
ワーカーを立ち上げて動作確認をするようにしてください
