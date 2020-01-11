<?php
error_reporting(E_ALL); //E_STRICTレベル以外のエラーを報告する
ini_set('display_errors','On'); //画面にエラーを表示させるか

$mode=0;
$convertedText="";
if (!empty($_POST['mode'])) {
  $mode=$_POST['mode'];
}

function convertToDNA($text){
  $hex = bin2hex($text);
  $nucleotideArray = array("AA", "AT", "AC", "AG", "TA", "TT", "TC", "TG", "CA", "CT", "CC", "CG", "GA", "GT", "GC", "GG");
  $hexArray = array("/0/", "/1/", "/2/", "/3/", "/4/", "/5/", "/6/", "/7/", "/8/", "/9/", "/a/", "/b/", "/c/", "/d/", "/e/", "/f/");
  $result = preg_replace($hexArray, $nucleotideArray, $hex);
  return $result;
}

function convertToLanguage($text){
  $strArray = str_split($text, 2);
  $resultArray = array_map("dnaDecode", $strArray);
  $hex = implode("", $resultArray);
  return hex2bin($hex);
}

function dnaDecode($nucleotide){
  $nucleotideArray = array("/AA/", "/AT/", "/AC/", "/AG/", "/TA/", "/TT/", "/TC/", "/TG/", "/CA/", "/CT/", "/CC/", "/CG/", "/GA/", "/GT/", "/GC/", "/GG/");
  $hexArray = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
  $result = preg_replace($nucleotideArray, $hexArray, $nucleotide);
  return $result;
}

function convert($text, $mode){
  if ($mode==0) {
    return convertToDNA($text);
  }
  if (isInvalidDNA($text)) {
    return "むり...";
  }
  return convertToLanguage($text);
}

function isInvalidDNA($text) {
  // hex2bin使うので4の倍数じゃないとダメ
  if (empty($text) || mb_strlen( $text )%2 != 0 || mb_strlen( $text )%4 != 0) {
    return True;
  }
  if (preg_match('/[^ATCG]/', $text)) {
    return True;
  }
  return False;
}

function getTwitterURL() {
  $hashTag = "&hashtags=" . urlencode("DNA変換");
  global $convertedText;
  return "https://twitter.com/intent/tweet?text=" . urlencode($convertedText) . $hashTag;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="感謝を直接伝えるのは恥ずかしいけど、何も伝えないのもモヤモヤする...そんなあなたを自己満足させてくれるツールです！！" />
    <title>でぃ〜えぬえ〜へんかん</title>
    <link rel="icon" href="img/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <script>
    window.onload = function() {
        console.log("%c ", 'background: url(http://adventam10.php.xdomain.jp/dna/img/pig.png); background-size: 100% 100%; padding: 128px 200px');
        console.log("%cきゃ〜！！！！", 'color: #c1031d; font-size: 5em; ');
    };
    </script>
    <style>
    button, input, select, textarea {
      font-family : inherit;
      font-size : 100%;
    }
    form {
      display: inline;
    }
    button {
      background: transparent;
      border: none;
      padding: 0;
    }
    button img {
      display: block;
      width: 30px;
    }
    .button {
      cursor: pointer;
      margin-top: 8px;
    }
    .text-area{
      height: 150px;
      float: left;
      width: 50%;
    }
    .div-result{
      border-style: solid;
      border-width : 1px;
      box-sizing: border-box;
      overflow: scroll;
      padding: 3px;
      word-wrap: break-word;
    }
    .text-input{
      border-style: solid;
      border-width : 1px;
      box-sizing: border-box;
      height: 100%;
      padding: 3px;
      resize: none;
      width: 100%;
    }
    .tweet{
      float: right;
    }
    .contents{
      margin-bottom: 32px;
    }
    @media screen and (max-width:480px) {
      .text-area{
        width: 100%;
      }
    }
    </style>
  </head>
  <body>
    <header>
      <a href="index.php">でぃ〜えぬえ〜へんかん</a>
      <hr class="header-footer">
    </header>
    <div class="contents">
      <form action="index.php" method="post">
        <div>
          <input type="radio" id="radio1" name="mode" value="0" <?php if($mode==0) echo 'checked'?>> <label for="radio1">ことば</label>
          <input type="radio" id="radio2" name="mode" value="1" <?php if($mode==1) echo 'checked'?>> <label for="radio2">ぬくれおちど</label>
        </div>
        <div class="text-area">
          <textarea class="text-input" placeholder="入力してください" rows="10" name="value"><?php if(!empty($_POST['value'])) echo $_POST['value']?></textarea>
        </div>
        <div class="text-area div-result">
          <?php if(!empty($_POST['value'])) {
            $convertedText = convert($_POST['value'], $mode);
            echo $convertedText;
          } ?>
        </div>
        <input class="button button-convert" type="submit" value="変換する">
      </form>
      <button class="button tweet" type=“button” onclick="location.href='<?php echo getTwitterURL();?>'"><img src="img/icon_twitter.png" alt="ツイッター" /></button>
    </div>
    <footer>
      <hr class="header-footer">
      Copyright <a href="https://github.com/adventam10">am10</a>. All Rights Reserved.
    </footer>
  </body>
</html>
