<?php

// demo.php

// include composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

$tokenizerFactory  = new \Sastrawi\Tokenizer\TokenizerFactory();
$tokenizer = $tokenizerFactory->createDefaultTokenizer();

// $string = preg_replace("/[^A-Za-z0-9\-]/", " ", "Tidak ada kendala kok lemot? Soluisinya pasti selalu di optimalisasi. Long term nya apa nih");
// $tokens = $tokenizer->tokenize($string);

// echo $string;

// foreach ($tokens as $token) {
// 	echo $token.", ";
// }

?>