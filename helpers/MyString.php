<?php
namespace app\helpers;

class MyString {

    function __construct() {
        
    }
    
    static function randomString($len) {
        $ret = substr(str_shuffle("abcdefghijklmnopqrstuvwxABCDEFGHJKLMNPQRSTUVWX1234567890"), 0, $len);
        return $ret;
    }
    
    static function random($len) {          
        return self::randomString($len);
    }
    
    static function strToURL($string) {
      $prevodni_tabulka = Array(
          'ä'=>'a',
          'Ä'=>'A',
          'á'=>'a',
          'Á'=>'A',
          'à'=>'a',
          'À'=>'A',
          'ã'=>'a',
          'Ã'=>'A',
          'â'=>'a',
          'Â'=>'A',
          'č'=>'c',
          'Č'=>'C',
          'ć'=>'c',
          'Ć'=>'C',
          'ď'=>'d',
          'Ď'=>'D',
          'ě'=>'e',
          'Ě'=>'E',
          'é'=>'e',
          'É'=>'E',
          'ë'=>'e',
          'Ë'=>'E',
          'è'=>'e',
          'È'=>'E',
          'ê'=>'e',
          'Ê'=>'E',
          'í'=>'i',
          'Í'=>'I',
          'ï'=>'i',
          'Ï'=>'I',
          'ì'=>'i',
          'Ì'=>'I',
          'î'=>'i',
          'Î'=>'I',
          'ľ'=>'l',
          'Ľ'=>'L',
          'ĺ'=>'l',
          'Ĺ'=>'L',
          'ń'=>'n',
          'Ń'=>'N',
          'ň'=>'n',
          'Ň'=>'N',
          'ñ'=>'n',
          'Ñ'=>'N',
          'ó'=>'o',
          'Ó'=>'O',
          'ö'=>'o',
          'Ö'=>'O',
          'ô'=>'o',
          'Ô'=>'O',
          'ò'=>'o',
          'Ò'=>'O',
          'õ'=>'o',
          'Õ'=>'O',
          'ő'=>'o',
          'Ő'=>'O',
          'ř'=>'r',
          'Ř'=>'R',
          'ŕ'=>'r',
          'Ŕ'=>'R',
          'š'=>'s',
          'Š'=>'S',
          'ś'=>'s',
          'Ś'=>'S',
          'ť'=>'t',
          'Ť'=>'T',
          'ú'=>'u',
          'Ú'=>'U',
          'ů'=>'u',
          'Ů'=>'U',
          'ü'=>'u',
          'Ü'=>'U',
          'ù'=>'u',
          'Ù'=>'U',
          'ũ'=>'u',
          'Ũ'=>'U',
          'û'=>'u',
          'Û'=>'U',
          'ý'=>'y',
          'Ý'=>'Y',
          'ž'=>'z',
          'Ž'=>'Z',
          'ź'=>'z',
          'Ź'=>'Z',
          ' '=>'-',
          '.'=>'-',
          ','=>'-'
      );
      $ret = preg_replace("/[^a-z0-9_-]/", "", strtolower(strtr(trim($string), $prevodni_tabulka)));
      $ret = preg_replace("/[-]+/", "-", $ret);
      return $ret; 
    }
    
    static function minimize($text) {
        $text = preg_replace("/\040+|\t+/", "\040", $text);   
        $text = preg_replace("/\r+/", "\n", $text);
        $text = preg_replace("/\n\040|\r\040|\040\r|\040\n/", "\n", $text); 
        $text = preg_replace("/\n+/", "\n", $text);   
        return $text; 
    }
}
?>