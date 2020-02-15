<?php
header('Content-Type: text/html; charset=UTF-8');

$json_string = file_get_contents('php://input');
$json = json_decode($json_string, true);
$resultCode = checkResultCode($json);
if($resultCode === 0) {
    $arr["resultCode"] = $resultCode;
    $arr["convertedText"] = convert($json["text"], $json["mode"]);
} else {
    $arr["resultCode"] = $resultCode;
}

print json_encode($arr, JSON_PRETTY_PRINT);

function checkResultCode($param) {
  if (isset($param["mode"])) {
    $mode = $param["mode"];
    if ($mode === 0 || $mode === 1) {
      if (!empty($param['text'])) {
        $text = $param['text'];
        if ($mode === 0) {
          return 0;
        } else {
          if (isInvalidDNA($text)) {
            return 4;
          } else {
            return 0;
          }
        }
      } else {
        return 3;
      }
    } else {
      return 2;
    }
  } else {
    return 1;
  }
}

function convertToDNA($text) {
  $hex = bin2hex($text);
  $nucleotideArray = array("AA", "AT", "AC", "AG", "TA", "TT", "TC", "TG", "CA", "CT", "CC", "CG", "GA", "GT", "GC", "GG");
  $hexArray = array("/0/", "/1/", "/2/", "/3/", "/4/", "/5/", "/6/", "/7/", "/8/", "/9/", "/a/", "/b/", "/c/", "/d/", "/e/", "/f/");
  $result = preg_replace($hexArray, $nucleotideArray, $hex);
  return $result;
}

function convertToLanguage($text) {
  $strArray = str_split($text, 2);
  $resultArray = array_map("dnaDecode", $strArray);
  $hex = implode("", $resultArray);
  return hex2bin($hex);
}

function dnaDecode($nucleotide) {
  $nucleotideArray = array("/AA/", "/AT/", "/AC/", "/AG/", "/TA/", "/TT/", "/TC/", "/TG/", "/CA/", "/CT/", "/CC/", "/CG/", "/GA/", "/GT/", "/GC/", "/GG/");
  $hexArray = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
  $result = preg_replace($nucleotideArray, $hexArray, $nucleotide);
  return $result;
}

function convert($text, $mode) {
  if ($mode === 0) {
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
