<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Random Word Generator</title>

  <style type="text/css">

    ::selection{ background-color: #f30; color: white; }
    ::moz-selection{ background-color: #f30; color: white; }
    ::webkit-selection{ background-color: #f30; color: white; }

    body {
      background-color: #fff;
      margin: 2em;
      font: 13px/20px normal Helvetica, Arial, sans-serif;
      color: #4F5155;
    }

    a {
      color: #003399;
      background-color: transparent;
      font-weight: normal;
      text-decoration:none;
    }

    a:hover {
      text-decoration:underline;
    }

    h1 {
      color: #444;
      background-color: transparent;
      border-bottom: 1px solid #D0D0D0;
      font-size: 1.5em;
      font-weight: normal;
      margin: 0 0 14px 0;
      padding: 15px 0px;
    }

    hr {
      border:0;
      border-bottom: 1px solid #D0D0D0;
    }

    code {
      font-family: Consolas, Monaco, Courier New, Courier, monospace;
      font-size: 12px;
      background-color: #f9f9f9;
      border: 1px solid #D0D0D0;
      color: #002166;
      display: block;
      margin: 14px 0 14px 0;
      padding: 12px 10px 12px 10px;
      white-space:pre;
    }

    p.footer{
      text-align: right;
      font-size: 11px;
      border-top: 1px solid #D0D0D0;
      line-height: 22px;
      margin-top:3em;
    }

  </style>
</head>
<body>
<?php

class random_word {
   public function __construct($how_many_words = 1, $print = 0) {
      $how_many_words = ($how_many_words > 50) ? 50 : intval($how_many_words) ;
      $boring         = "free next postings nbsp craigslist more with what that there them must their this also were some your have from when they these does ikea";
      $url            = "http://portland.craigslist.org/zip/";
      $pattern        = "/<p.*?>.*?<a.*?>(.*?)<\/a>.*?<\/p>/";

      $str            = ereg_replace("[\r|\n]"," ",file_get_contents($url)); // <- Turn page into one string...
      $lower_str      = strtolower($str);                                    // <- Lowercase string...
      $links_in_paras = preg_match_all($pattern,$lower_str,$m);              // <- Get links inside paragraphs from that string...
      $all_alpha      = ereg_replace("[^a-z ]"," ",implode(' ',$m[1]));      // <- Turn that array back to a string and remove all non-alpha chars...
      $not_boring     = str_replace(explode(' ',$boring),' ',$all_alpha);    // <- Remove words from the list of "boring" words...
      $less_than_num  = preg_replace('/\b\w{1,3}\b/',' ',$not_boring);       // <- Remove words of less than 4 chars...
      $clean_string   = trim(preg_replace('/\s\s+/', ' ',$less_than_num));   // <- Remove more than two spaces and trim the string...
      $text_array     = explode(' ', $clean_string);                         // <- Back to an array.

      $tmp['tmp']     = 1; // <- there for count() in while loop...

      while(count($tmp) < ($how_many_words + 1)) {
         $n                = rand(0,count($text_array) - 1);
         $this->word       = $text_array[$n];
         $tmp[$this->word] = 1;
      }

      unset($tmp['tmp']);
      $this->words = array_keys($tmp);

      // ---------------------------------
      // $print = 1 to see the array
      // $print > 1 to see debugging info.
      // ---------------------------------
      if ($print > 1) {
         $this->debug->message        = "Random Word Generator has a ceiling of 50 words.";
         $this->debug->url            = htmlentities($url);
         $this->debug->view_pattern   = htmlentities($pattern);
         $this->debug->how_many_words = "<b>" . count($text_array) . "</b> words from <b><a href='" . $url . "' target='_blank'>" . $url . "</a></b>.";
         $this->debug->text_array     = $text_array;
         
      }
      if ($print != 0) {
         echo "<code>";
         print_r($this);
         echo "</code>";
      }
   }
}
$how_many_words = ($_GET['how_many_words']) ? $_GET['how_many_words'] : 10;
$print          = ($_GET['print']) ? $_GET['print'] : 0;
$w              = new random_word($how_many_words, $print);
?>

<h1>Random Word Generator</h1>

<p>
  <big><b>The Random Word Generator</b></big> uses the "<b>For Sale:Free</b>" section of <b>Portland's Craigslist</b>. 
  It finds all the words, eliminates "boring" ones ('them,' 'these,' etc.), and ones under 4 letters.
  It then makes an array of 'em ('words'), and plucks off the last one ('word') for you to do with what you wish.
</p>
<p>
  Example: 
  <code style='color:#333;'>
  <span style='color:cyan;'>&lt;?php</span>
    $how_many_words = 22;   <span style='color:gray;'>// Default is 10, ceiling is 50.</span>
    $print          = FALSE <span style='color:gray;'>// Don't print out the arrays. This is the default.</span>
    $words          = <span style='color:blue'>new</span> random_word($how_many_words, $print);

    <span style='color:blue'>echo</span> $words->word;      <span style='color:gray;'>// Print out your random word.</span>
    print_r($words->words); <span style='color:gray;'>// Print out an array of random words.</span>
  <span style='color:cyan;'>?&gt;</span>
  
  <b>Note:</b> If Craigslist changes their formatting, this would no longer work.
  </code>
</p>


<hr />

<p>
  <a href='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>'>New Set (Default:10, no debugging info)</a>
  |
  <a href='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>?how_many_words=25'>New Set (25)</a>
  |
  <a href='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>?print=1'>New Set (some debugging info)</a>
  |
  <a href='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>?print=2'>New Set (more debugging info)</a>
</p>

<p>Single word is "<b><?php echo $w->word ?></b>"

<p><b><?php echo $how_many_words ?></b> word<?php if ($how_many_words != 1) { ?>s<?php } ?>.</p>

<ol>
  <li><b><?php echo implode("</b></li>\n  <li><b>", $w->words) ?></b></li>
</ol>

<p class='footer'>
  <a href='http://portland.craigslist.org/zip/' target='_blank'>portland.craigslist.org/zip</a> 
  parsed by 
  <a href='http://www.nonlefthanded.com' target='_blank'>nonlefthanded.com</a>
</p>

</body>
</html>