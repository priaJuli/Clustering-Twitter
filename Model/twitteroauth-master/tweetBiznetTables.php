<?php


use Abraham\TwitterOAuth\TwitterOAuth;
include "Model/twitteroauth-master/Config/key.php";

$DBuser = "root";
$DBpass = "";
$DBhost = "localhost";
$DBname = "twitter_biznet";
  
  $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
    
     if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }

function yesterday($dateu){
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
	$content = $connection->get("account/verify_credentials");

	$queryLanj = array(
		"q" => "@BiznetHome",
		"until" => $dateu,
		// "max_id" => $maxid,
		"include_entities" => "true",
		"count" => "11"
		);	

	return $connection->get('search/tweets', $queryLanj);
}

function Repeat($maxid)
{
	$dateuntil = $_POST["until"];
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
	$content = $connection->get("account/verify_credentials");

	$queryLanj = array(
		"q" => "@BiznetHome",
		"until" => $dateuntil,
		"max_id" => $maxid,
		"include_entities" => "true",
		"count" => "100"
		);	

	return $connection->get('search/tweets', $queryLanj);
}


?>

	
	<?php
		if(isset($_POST["submit"])){
		

		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
		$content = $connection->get("account/verify_credentials");



			$dateuntil = $_POST["until"];
			$tanggal = explode('-', $dateuntil);
			 $dateN = date_create();
			 //$dateYesterday = date_create();
			 date_date_set($dateN, $tanggal[0], $tanggal[1], $tanggal[2]+1);
			 //date_date_set($date, $tanggal[0], $tanggal[1], $tanggal[2]-1);
			 // echo "<p>".date_format($dateN, 'Y-m-d')."</p>";
			 $dateN = date_format($dateN, 'Y-m-d');
			$query = array(
			 "q" => "@BiznetHome",
			 //"result_type" => "recent",
			 // "until" => "2018-02-5",
			 "until" => $dateN,
			 //"max_id" => "959937252007669760",
			 //"since_id" => "959937252007669760",
			 "include_entities" => "true",
			 "count" => "100"
			);

			$tweets = $connection->get('search/tweets', $query);
			$tweet = $tweets->statuses;
			$count1 = 0;
			$tweetYesterday = yesterday($dateuntil);
			$tYesterday = $tweetYesterday->statuses;
			$id_yesterday = $tYesterday[0]->created_at;

			foreach ($tweet as $result) {
				if(strcmp($result->created_at, $id_yesterday) == 0){
						break;
				}
				elseif(str_replace(" ", "", $result->text)){
					if (isset($result->entities->media)) {
						
					}
					else{
					$count1++;
					$textTw = $result->text;
					$sql = mysqli_query($DBcon, "INSERT INTO `text_twitter`(no,text) VALUES ('', '$textTw')");
					
					?>
					
					<tr>
					<td><?php echo $count1;?></td><td>
					<?php echo $result->text;?></td>
					</tr>

					<?php 
					}
					
				}
				else{
					break;
				}
				
			}
			if($count1>=95){
					$mxid = $tweet[$count1]->id_str;
				// echo $mxid;

				$count2 = 0;
				
				for ($i=0; $i <= 0; $i++) { 
					$tweets1 = Repeat($mxid);
					$tweet = $tweets1->statuses;
					
					foreach ($tweet as $result) {
						if(strcmp($result->created_at, $id_yesterday) == 0){
							break 2;
							
						}
						elseif(str_replace(" ", "", $result->text)){
							if (isset($result->entities->media)) {
								
							}
							else{
							$count1++;
							$count2++;
							$textTw = $result->text;
							$sql = mysqli_query($DBcon, "INSERT INTO `text_twitter`(no,text) VALUES ('', '$textTw')");
							?>
							
							<tr>
							<td><?php echo $count1;?></td><td>
							<?php echo $result->text;?></td>
							 <p>Created at : <?php echo $count1." ";echo $result->created_at; ?> dan ID : <?php echo $result->id_str;?></p> 
							</tr>

							<?php 
							
							}
							
						}
						else{
							break;
							break;
						}
						
					}
					if($count2 != 0 && (isset($tweet[$count2]->id_str))){
					$mxid = $tweet[$count2]->id_str;
					$count2 = 0;
					}
					else{
						break;
						
					}

				}//end for i=0
			} // end if count >= 95
			$check_sts = mysqli_query($DBcon, "SELECT * FROM `status_data_set` WHERE status='new'");
			if($check_sts->num_rows != 0){
				$dateI = $check_sts->fetch_assoc()["tanggal"];
				$dateI .= " ".$dateuntil;
				
				$update_status = mysqli_query($DBcon, "UPDATE `status_data_set` SET tanggal='$dateI' WHERE status='new'");
			}else{
				$query_status = mysqli_query($DBcon, "INSERT INTO `status_data_set`(id_datasets,status,tanggal,klaster,anggota) VALUES ('', 'new', '$dateuntil', '', '')");
				if(!$query_status){
					echo "Data status gagal di insert<br>";
				}else{
					echo "Data status berhasil di insert<br>";
				}
			}
		}// end if post submit
		elseif(isset($_POST["reset"])){
             mysqli_query($DBcon, "TRUNCATE TABLE `text_twitter`");
        }
	?>