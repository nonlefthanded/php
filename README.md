# Random Word Generator: 

* **Random Word Generator:**
  - Get a list or single random word from portland.craigslist.org.

* **Overview:**
  - The Random Word Generator</b></big> uses the "<b>For Sale:Free</b>" section of <b>Portland's Craigslist</b>. 
  - It finds all the words, eliminates "boring" ones ('them,' 'these,' etc.), and ones under 4 letters.
  - It then makes an array of 'em ('words'), and plucks off the last one ('word') for you to do with what you wish.
  - **PRO:** Nothing more random than free Portland Stuff.
  - **CON:** If Craigslist changes their formatting, this would no longer work.

* **Example Usage (php chunk):**
    ```php
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
             echo "<code><pre>";
             print_r($this);
             echo "</pre></code>";
          }
        }
      }

      $how_many_words = 22;   // Default is 10, ceiling is 50.
      $print          = FALSE // Don't print out the arrays. This is the default.
      $words          = new random_word($how_many_words, $print);

      echo $words->word;      // Print out your random word.
      print_r($words->words); // Print out an array of random words.
    ?>
    ```

* **Example Usage (html chunk)**:
    ```html
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
    ```
* **Getting Started**
  - Download 'random_word_generator.php.'
  - Save it to a php-enabled server/directory.
  - Go, go, go...

* **Colophon**
  - Credits -- www.nonlefthanded.com, http://portland.craigslist.org/zip.
  - Copyright and License -- It's all you...