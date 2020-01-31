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

### ソース
* src  
作業用
*  dist  
`npx gulp` で生成した実際にサーバーに置くやつ

## gulp使い方
* [node.js](https://nodejs.org/ja/)（最新版の方）をインストール
* ターミナルで `node -v` できればインストール完了
* ターミナルで DNAConverter-web フォルダに移動
* 必要であれば `npm install -D` でインストールする 
* `npx gulp` で処理実行 dist フォルダにファイルが生成される
