<?php 


require_once "autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
 
include "../tokenizer-master/try.php";
include "../sastrawi-master/try.php";


define('CONSUMER_KEY', 'NWvHx98amo8RknLSYcfnJZY9n');
define('CONSUMER_SECRET', 'U1EL5s07omsWEgWFtlhiDgRiUwGxajkbdhbwZgvjYvmfJmthX8');
define('ACCESS_TOKEN', '840459557088313344-fSarpf47EHxzLxCgby0XWqvOYpOpyq3');
define('ACCESS_TOKEN_SECRET', '5q94MrGxkGZk1zbRS8TFXD8BoIiyAHTV4Erx80ZEhqqLI');

$conn = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
$query = array(
 "q" => "@BiznetHome",
 "count" => 20,
 "result_type" => "recent"
);

$tweets = $conn->get('search/tweets', $query);
$tweet = $tweets->statuses;
$string = array();

foreach ($tweet as $result) {
				if($result->text){
					$st = str_replace("@BiznetHome", "", $result->text);
					array_push($string, $st);
					echo $result->text;
					echo "<br>";
				}

}
foreach ($string as $key) {
	$regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?).*$)@";	
	$key1 = preg_replace($regex, " ", $key);
	$string12 = preg_replace("/[^A-Za-z0-9\-]/", " ", $key1);
	if(preg_match("/[a-z]/i", $string12)){
					$stem = $stemmer->stem($string12);
					$st = $stopW->remove($stem);

					$tokens = $tokenizer->tokenize($st);
					
					echo "Text : ";
					foreach ($tokens as $token) {
						echo "(".$token.") ";
					}
					echo "<br>";
	}
}


?>