# Rese
飲食店予約アプリです。  
会員登録無しで、店舗情報と投稿レビューを見ることが出来ます。  
会員登録すると、予約・お気に入り追加・来店後にレビュー投稿が出来ます。  
管理者は店舗代表者作成が出来ます。  
店舗代表者は店舗情報の作成・変更が出来ます。  
![RESEtop](https://github.com/user-attachments/assets/67f7505d-af60-4b7f-bbac-83570cce13bf)

## 作成目的  
Laravel学習のまとめとして作成しました。

## アプリケーションURL  
http://ec2-54-65-12-180.ap-northeast-1.compute.amazonaws.com/  
※テストデプロイのため保護されていない通信です。QRコード読み取りページのカメラへのアクセスは、お使いのブラウザでの設定が必要になる場合があります。  
例：GoogleChromの場合  
1.Chromeのアドレスバーに chrome://flags/#unsafely-treat-insecure-origin-as-secure と入力。  
2.Insecure origins treated as secure を検索。  
3.QRコード読み取りページのURLを枠の中に入力し、有効にする。  
4.ブラウザを再起動。  
5.QRコードの機能確認が終わったら有効を停止するにし、ブラウザを再起動。

## 機能一覧
会員登録・ログイン、メール認証、お気に入り追加・削除、予約追加・変更・削除、レビュー投稿・変更・削除、検索、リマインドメール送信、QRコード予約認証、決済(stripe)  
管理者権限での店舗代表者作成、お知らせメール送信  
店舗代表者権限での店舗情報作成・更新、予約確認  

## 使用技術
Laravel Framework 8.x、PHP7.4.9、MySQL8.0.26、JavaScript、stripe

## テーブル設計
![table_design](https://github.com/user-attachments/assets/3e5a35e0-bca8-4748-9a6a-c9718991b1c4)

## ER図
![table_ER drawio](https://github.com/user-attachments/assets/9f30999d-b0c1-4ed0-8e32-0621c4f8da30)

## 環境構築
### Dockerビルド

  1.クローン作成
  
    git@github.com:ishikawashinnya/Rese.git
  
  2.DockerDesktopアプリを立ち上げる

  3.コンテナをビルドして起動
  
    docker-compose up -d --build

### Laravel環境構築

  1.実行中の PHP コンテナの中に入る
  
    docker-compose exec php bash
  
  2.Composer を使用した依存関係のインストール
  
    composer install
  
  3.「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成
  
  4..envに以下の環境変数を追加
  
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=laravel_db
    DB_USERNAME=laravel_user
    DB_PASSWORD=laravel_pass  
    
  5.アプリケーションキーの作成
  
    php artisan key:generate
    
  6.マイグレーションの実行
  
    php artisan migrate

  7.シーディングの実行
  
    php artisan db::seed  

  ※メール、stripe等の設定は必要に応じて行ってください。

## ダミーデータ説明
### ユーザー一覧
1.管理者　email : admin@example.com　　password : testadmin  
2.店舗代表者　email : shoprep@example.com　　password : testshoprep  
3.テストユーザー　email : test@example.com　　password : testuser  
※店舗代表者は店舗名：仙人の代表者として設定しています。  
※テストユーザーのレビュー投稿は店舗名：仙人で行えます。

## URL
開発環境：http://localhost/  
phpMyAdmin:：http://localhost:8080/
