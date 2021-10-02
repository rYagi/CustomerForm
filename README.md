# CustomerForm
PHPによる問い合わせフォームWebアプリケーション

## 開発環境
Vagrant 2.2.4

CentOS8（generic/centos8）

Apach2.4.37

PHP 7.2.24

postfix | mail_version 3.5.8

### その他実行に必要な設定
rewritemoduleの有効化をするためにhttpd.confの155行目を書き換えてください

　AllowOverride None → AllowOverride All
 
 （/etc/httpd/conf/httpd.confに配置されているファイルをルートディレクトリにコミットしております）
	
メール送信のため、postfixが入っていなければインストールしてください
