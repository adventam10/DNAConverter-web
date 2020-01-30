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
