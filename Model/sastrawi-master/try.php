<?php

// include composer autoloader
require_once __DIR__ . '/vendor/autoload.php';
// include "../tokenizer-master/try.php";


// create stemmer
// cukup dijalankan sekali saja, biasanya didaftarkan di service container
$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
$dictionary = $stemmerFactory->createDefaultDictionary();
$dictionary->addWordsFromTextFile(__DIR__.'/data/kata-dasar.txt');
$dictionary->add('cover');
$stemmer  = new \Sastrawi\Stemmer\Stemmer($dictionary);
$stopWord = new \Sastrawi\StopWordRemover\StopWordRemoverFactory();
$stopW = $stopWord->createStopWordRemover();

// $stem = $stemmer->stem("Kumengirimkannya");
// $st = $stopW->remove($stem);
// $tokens = $tokenizer->tokenize($st);

// foreach ($tokens as $wordT) {
// 	echo $wordT.", ";
// }

?>