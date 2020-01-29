# DNAConverter-web
[Webページ](http://adventam10.php.xdomain.jp/dna/index.php)

## 環境
* サーバー  
[XFREE](https://www.xfree.ne.jp/)
*  PHP7.0.x
*  HTML5

## 内容
* copy_to_mamp.sh  
MAMP の htdocs にソースをコピーするスクリプト
* dna  
ソース
srcが作業用、distが実際にサーバーに置くやつ

## gulp使い方
* [node.js](https://nodejs.org/ja/)（最新版の方）をインストール
* ターミナルで `node -v` できればインストール完了
* ターミナルで dna フォルダに移動
* 必要であれば `npm install -D gulp-sass` で 
* `npx gulp` で処理実行 dist フォルダにファイルが生成される
