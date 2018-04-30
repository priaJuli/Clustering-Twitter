
<?php 
ini_set('max_execution_time', 4800);
include 'config/koneksi.php';
  
  $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
    
     if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }

	$tweet = mysqli_query($DBcon, "SELECT * FROM `term_text_twitter`");
	$string1 = array();
	$k = 0;
	foreach ($tweet as $result) {
		if(!(isset($string1["bayar"]) and isset($string1["cover"]) and isset($string1["koneksi"])) ) {
			$string1["bayar"] = array("doc"=> $result["no_doc"], "term"=> 0);
			$count_arr = 0;
			$string1["cover"] = array("doc"=> $result["no_doc"], "term"=> 0);
			$count_arr = 0;
			$string1["koneksi"] = array("doc"=> $result["no_doc"], "term"=> 0);
			$count_arr = 0;
		}
		else{
			
			if(in_array("bayar", explode(', ', $result["term"]))) {
				//echo "String bayar ada di document".$result["no_doc"]."<br>";
				 $count_arr = $string1["bayar"]["term"];
				if(count(explode(', ', $result["term"])) > $count_arr) {
					//echo "Update<br>";
					$string1["bayar"]["term"] = count(explode(', ', $result["term"]));
					$string1["bayar"]["doc"] = $result["no_doc"];
					
					continue;
				}else{
					continue;
				}
			}elseif(in_array("jangkau", explode(', ', $result["term"])) or in_array("cover", explode(', ', $result["term"])) or in_array("luas", explode(', ', $result["term"])) or in_array("kota", explode(', ', $result["term"]))){
				//echo "String cover ada di document".$result["no_doc"]."<br>";
				$count_arr = $string1["cover"]["term"];
				if(count(explode(', ', $result["term"])) > $count_arr){
					//echo "Update<br>";
					$string1["cover"]["term"] = count(explode(', ', $result["term"]));
					$string1["cover"]["doc"] = $result["no_doc"];
					
					continue;
				}else{
					continue;
				}
			}elseif(in_array("koneksi", explode(', ', $result["term"]))){
				//echo "String koneksi ada di document".$result["no_doc"]."<br>";
				$count_arr = $string1["koneksi"]["term"];
				if(count(explode(', ', $result["term"])) > $count_arr){
					//echo "Update<br>";
					$string1["koneksi"]["term"] = count(explode(', ', $result["term"]));
					$string1["koneksi"]["doc"] = $result["no_doc"];
					
					continue;
				}else{
					continue;
				}
			}else{
				continue;
			}
		}
	}
// 	// echo "<br>Klaster pertama ditentukan pada document ke".$string1["bayar"]["doc"];
// 	// echo "<br>Klaster pertama ditentukan pada document ke".$string1["cover"]["doc"];
// 	// echo "<br>Klaster pertama ditentukan pada document ke".$string1["koneksi"]["doc"];

	// $mboh = mysqli_query($DBcon, "SELECT DISTINCT klaster FROM `document_klaster_next`");
	// $i = 1;
 //    foreach ($mboh as $mboh1) {
 //    	if($i == 1){
 //    		$klaster1 = $mboh1["klaster"];
 //    	}elseif($i == 2){
 //    		$klaster2 = $mboh1["klaster"];
 //    	}else{
 //    		$klaster3 = $mboh1["klaster"];
 //    	}
 //    	$i++;	
 //  	}
  	//echo $klaster1.", ".$klaster2.", ".$klaster3."<br>";

	$klaster1 = $string1["bayar"]["doc"];
	$klaster2 = $string1["cover"]["doc"];
	$klaster3 = $string1["koneksi"]["doc"];
   
	process_term();
	process_tfidf();
	process_vector_doc();

	process_jarak_doc($klaster1);

	process_jarak_doc($klaster2);

	process_jarak_doc($klaster3);
	process_group_klaster();
	term_klaster($klaster1);
	term_klaster($klaster2);
	term_klaster($klaster3);
	Next_iterasi($klaster1);
	Next_iterasi($klaster2);
	Next_iterasi($klaster3);
	process_group_klaster_next();
	
	
	term_klaster_last($klaster1, 2);
	term_klaster_last($klaster2, 2);
	term_klaster_last($klaster3, 2);

	Next_iterasi2($klaster1, 2);
	Next_iterasi2($klaster2, 2);
	Next_iterasi2($klaster3, 2);
	process_group_klaster_2(2);

	term_klaster_last($klaster1, 3);
	term_klaster_last($klaster2, 3);
	term_klaster_last($klaster3, 3);
	Next_iterasi2($klaster1, 3);
	Next_iterasi2($klaster2, 3);
	Next_iterasi2($klaster3, 3);
	process_group_klaster_2(3);

	// // echo "<br>".jarak_klaster($klaster1, $klaster2);
	// // echo "<br>".jarak_klaster($klaster1, $klaster3);
	// // echo "<br>".jarak_klaster($klaster2, $klaster3);

	jarak_c_doc($klaster1);
	jarak_c_doc($klaster2);
	jarak_c_doc($klaster3);

	proses_dbi($klaster1, $klaster2);
	proses_dbi($klaster1, $klaster3);
	proses_dbi($klaster3, $klaster2);

function process_term(){
	include 'config/koneksi.php';
	  
 	 $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
    
     if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }


	//`text_twitter`

	$tweet = mysqli_query($DBcon, "SELECT * FROM `term_text_twitter`");
	$string1 = array();

	foreach ($tweet as $result) {
		array_push($string1, $result["term"]);
	}

	foreach ($string1 as $key1) {
		$tokens = explode(', ', $key1);

		foreach ($tokens as $token) {
			//$dq = mysqli_query($DBcon, "SELECT * FROM `table_term`");
			// while ($q = $dq->fetch_assoc()){
			// 	if($q["term"] == $token){
			// 		$ccc = $q["count"] + 1;
			// 		$update_term = mysqli_query($DBcon, "UPDATE `table_term` SET count=$cc");
			// 	}
				
			// }//end while
			// echo $token."<br>";
			$insert_term = mysqli_query($DBcon, "INSERT INTO `table_term`(term,count) VALUES ('$token', 1)");	
			// if($q["term"] != $token){
				
			// }
			if(!$insert_term){
				$dq = mysqli_query($DBcon, "SELECT * FROM `table_term` WHERE term='$token'");
				$q = $dq->fetch_assoc();
				// foreach ($dq as $q) {
				// 	echo $q["count"]."<br>";
				// }

				$cc = $q["count"] + 1;
				$update_term = mysqli_query($DBcon, "UPDATE `table_term` SET count=$cc WHERE term='$token'");
				// echo "term sudah ada count+1 =".$cc."<br>";
			}
			// echo "insert into table term success<br>";
			
		}//end foreach tokens
						
	}//end foreach string1
}

	function process_tfidf(){
		include 'config/koneksi.php';
		  
		  $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
		    
	     if ($DBcon->connect_errno) {
	         die("ERROR : -> ".$DBcon->connect_error);
	     }

		$tweet = mysqli_query($DBcon, "SELECT * FROM `term_text_twitter`");
		$total = mysqli_num_rows($tweet);
		$string1 = array();
		//$nodoc = array();

		foreach ($tweet as $result) {
			array_push($string1, $result["term"]);
			//array_push($nodoc, $result["no_doc"]);
		}
		$countdoc = 0;
		foreach ($string1 as $key1) {
			$countdoc++;
			$tokens = explode(', ', $key1);

			foreach ($tokens as $token) {
				$check = mysqli_query($DBcon, "SELECT * FROM `tf_idf_document` WHERE term='$token' AND no_doc=$countdoc");
				$idf = mysqli_query($DBcon, "SELECT * FROM `table_term` WHERE term='$token'");
				if(mysqli_num_rows($check) > 0){
					$R = $check->fetch_assoc();
					$tf_doc = $R["TF"]+1;
					$update_term = mysqli_query($DBcon, "UPDATE `tf_idf_document` SET TF=$tf_doc WHERE term='$token' AND no_doc=$countdoc");
					if($update_term){
						// echo $token." doccument ke".$countdoc." berhasil dan TF document bertambah<br>";
					}
				}
				else{
					$idf_doc = $idf->fetch_assoc();
					$n_idf = log10($total / $idf_doc["count"]);
				$insert_term = mysqli_query($DBcon, "INSERT INTO `tf_idf_document`(no_doc,term,TF,IDF) VALUES ($countdoc, '$token', 1, $n_idf)");
				// echo $token." doccument ke".$countdoc."Berhasil dan Term document baru<br>";

				}
				
				
				
			}//end foreach tokens
			
		}
}
	
	function process_vector_doc(){
		include 'config/koneksi.php';
		  
		$DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
		    
	    if ($DBcon->connect_errno) {
	         die("ERROR : -> ".$DBcon->connect_error);
	     }

		//$tweet = mysqli_query($DBcon, "SELECT * FROM `tf_idf_document`");
		$total_tweet = mysqli_query($DBcon, "SELECT * FROM `term_text_twitter`");
		$total = mysqli_num_rows($total_tweet);
		$arr_sum = array();
		$arr_sqrt = array();
		//$nodoc = array();


		for ($i=1; $i <= $total; $i++) { 
			// echo "D".$i." = ";
			$arr_sum[$i] = 0;
			$query_sum = mysqli_query($DBcon, "SELECT * FROM `tf_idf_document` WHERE no_doc=$i");
			foreach ($query_sum as $tfidf) {
				// echo $tfidf["TF"] * $tfidf["IDF"]."+";
				$nilaiTFIDF = $tfidf["TF"] * $tfidf["IDF"];
				//echo "<br>TF(".$tfidf["TF"].") * IDF(".$tfidf["IDF"].") = ".$nilaiTFIDF."<br>Dan kuadrat TFIDF = ".$nilaiTFIDF*$nilaiTFIDF;
				$arr_sum[$i] = $arr_sum[$i] + ($nilaiTFIDF * $nilaiTFIDF);
			}
			// echo "<br>= ".$arr_sum[$i]."<br>";
			$arr_sqrt[$i] = sqrt($arr_sum[$i]);
			// echo "= ".$arr_sqrt[$i]."<br>";
			//echo "Nilai SUM dari doc ".$i." = ".$arr_sum[$i]." dan SQRT = ".$arr_sqrt[$i].".<br>";
			$insert_vector = mysqli_query($DBcon, "INSERT INTO `vector_document`(no_doc,sum,sqrt) VALUES ($i, $arr_sum[$i], $arr_sqrt[$i])");
		}
		
		
}

function process_jarak_doc($klaster){
		include 'config/koneksi.php';
		  
		$DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
		    
	    if ($DBcon->connect_errno) {
	         die("ERROR : -> ".$DBcon->connect_error);
	     }

	    // klaster 3, 29 dan 54
	     $arr_tklaster = array();
		$term_k = mysqli_query($DBcon, "SELECT * FROM `tf_idf_document` WHERE no_doc=$klaster");
		foreach($term_k as $word){
			//echo "Term ".$word["term"]." klaster<br>";
			array_push($arr_tklaster, array($word["term"], $word["TF"]));
		}
		$total_tweet = mysqli_query($DBcon, "SELECT * FROM `term_text_twitter`");
		$total = mysqli_num_rows($total_tweet);
		$arr_jarak1 = array();
		$arr_jarak2 = array();
		
		for($o=1; $o <= $total; $o++){
			if($o == $klaster){
				// $insert_jarak =  mysqli_query($DBcon, "INSERT INTO `jarak_cosinus`(no_doc,klaster,jarak_cosinus) VALUES ($o, $klaster, 1)");
				continue;
			}
			else{
				// echo "<br>D".$o."C".$klaster." = ( Kata yang sama ) / (VectorD".$o." * VectorC".$klaster.")<br>";
				// echo " = ";
			
				$arr_jarak1[$o] = 0;
				$query_sum = mysqli_query($DBcon, "SELECT * FROM `tf_idf_document` WHERE no_doc=$o");
				//echo "Select * from doc ".$o."<br>";
				foreach ($query_sum as $qterm) {
					$termL = $qterm["term"];

					foreach ($arr_tklaster as $klTerm) {
						
						if(strcmp($klTerm[0], $termL) == 0){
						// echo "( ".$termL." )";
						$ope = sqrt(($qterm["TF"] * $qterm["IDF"]) * ($klTerm[1] * $qterm["IDF"]));
						$arr_jarak1[$o] = $arr_jarak1[$o] + $ope;

						// echo "( ".number_format(($qterm["TF"]*$qterm["IDF"]), 4)." x ".number_format(($klTerm[1] * $qterm["IDF"]), 3)." ) +";
						}
						else{
							
						}
					}
					
				}
				$sqrtD = mysqli_query($DBcon, "SELECT * FROM `vector_document` WHERE no_doc=$o");
				$sqrtND = $sqrtD->fetch_assoc();
				$sqrtC = mysqli_query($DBcon, "SELECT * FROM `vector_document` WHERE no_doc=$klaster");
				$sqrtNC = $sqrtC->fetch_assoc();
				$vectorCND = number_format($sqrtNC["sqrt"], 3) * number_format($sqrtND["sqrt"], 3);
				
				$cosin = $arr_jarak1[$o] / $vectorCND;
				
				$insert_jarak =  mysqli_query($DBcon, "INSERT INTO `jarak_cosinus`(no_doc,klaster,jarak_cosinus) VALUES ($o, $klaster, $cosin)");
			}
			// if($cosin != 0){
			// 	echo "<br> = / ( ".number_format($sqrtND["sqrt"], 3)." x ".number_format($sqrtNC["sqrt"], 3)." )<br>";
			// 	echo " = ".number_format($cosin, 4)."<br>";
			// }
			
		}
		// echo "<br>";
}

function process_group_klaster(){
		include 'config/koneksi.php';
		  
		$DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
		 
	    if ($DBcon->connect_error) {
	         die("ERROR : -> ".$DBcon->connect_error);
	     }

		//$tweet = mysqli_query($DBcon, "SELECT * FROM `tf_idf_document`");
		$total_tweet = mysqli_query($DBcon, "SELECT * FROM `term_text_twitter`");
		$query_total = mysqli_query($DBcon, "SELECT * FROM `jarak_cosinus` ORDER BY `jarak_cosinus`.`no_doc` ASC");
		$total = mysqli_num_rows($total_tweet);
		$arr_cosinus = array();
		//$arr_sqrt = array();
		//$nodoc = array();
		while ($query_T = $query_total->fetch_assoc()) {
			if(isset($arr_cosinus[$query_T["no_doc"]])){
				$jarak_sb = $arr_cosinus[$query_T["no_doc"]]["jarak"];
				if($jarak_sb <= $query_T["jarak_cosinus"]){
					$arr_cosinus[$query_T["no_doc"]]["klaster"] = $query_T["klaster"];
					$arr_cosinus[$query_T["no_doc"]]["jarak"] = $query_T["jarak_cosinus"];
					// echo " [".$query_T["klaster"]."]".$query_T["jarak_cosinus"]." ";
				}
				else{
					// echo " [".$query_T["klaster"]."]".$query_T["jarak_cosinus"]." ";
					continue;
				}
			}else{
				$arr_cosinus[$query_T["no_doc"]] = array("klaster" => $query_T["klaster"], "jarak" => $query_T["jarak_cosinus"]);
				// echo "<br>".$query_T["no_doc"]." [".$query_T["klaster"]."]".$query_T["jarak_cosinus"];
			}
		}
		$y = 1;
		foreach ($arr_cosinus as $Aw) {
			if($Aw["jarak"] == 0){

			}else{
				$cluster = $Aw["klaster"];
				// echo "Document".$y." ada di klaster".$cluster."<br>";
				$insert_groupK =  mysqli_query($DBcon, "INSERT INTO `document_klaster`(no_doc,klaster) VALUES ($y, $cluster)");
			}

			$y++;
		}

}

function term_klaster($clus){
	include 'config/koneksi.php';
	  
	$DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
	    
    if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }
     $update_cl = mysqli_query($DBcon, "SELECT * FROM `document_klaster` WHERE klaster=$clus");
	foreach ($update_cl as $iter) {
		$doc_no = $iter["no_doc"];
		$geto_term= mysqli_query($DBcon, "SELECT * FROM `tf_idf_document` WHERE no_doc=$doc_no");
		foreach ($geto_term as $term_do) {
		$termo = $term_do["term"];
		$tfo = $term_do["TF"];
		$idf = $term_do["IDF"];
			$check_term_new1 = mysqli_query($DBcon, "SELECT TF FROM `update_cluster_term` WHERE term='$termo' AND klaster=$clus");
			if($check_term_new1->num_rows != 0){
				$tf_kl1 = ($check_term_new1->fetch_assoc()["TF"]) + 1;
				$update_new_term2 = mysqli_query($DBcon, "UPDATE `update_cluster_term` SET TF=$tf_kl1 WHERE term='$termo' AND klaster=$clus");
				if($update_new_term2){
					// echo "Update term beres <br>";
				}
			}else{
				$insert_new_term3 = mysqli_query($DBcon, "INSERT INTO `update_cluster_term`(klaster,term,TF,IDF) VALUES ($clus, '$termo', $tfo, $idf)");
				if($insert_new_term3){
					// echo "Insert term Beres<br>";
				}
			}
		}
	}
	// $select_term_new = mysqli_query($DBcon, "SELECT * FROM `update_cluster_term` WHERE klaster=$clus");
	// echo "Update term klaster".$clus."<br><( ";
	// foreach ($select_term_new as $z) {
	// 	echo $z["term"].", ";
	// }
	// echo " )<br>";
}

function Next_iterasi($clus){
		include 'config/koneksi.php';
		  
		$DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
		    
	    if ($DBcon->connect_errno) {
	         die("ERROR : -> ".$DBcon->connect_error);
	     }

	    // klaster 3, 29 dan 54
	     $arr_tklaster = array();
		$term_k = mysqli_query($DBcon, "SELECT * FROM `update_cluster_term` WHERE klaster=$clus");
		foreach($term_k as $word){
			//echo "Term ".$word["term"]." klaster<br>";
			array_push($arr_tklaster, array($word["term"], $word["TF"]));
		}
		$total_tweet = mysqli_query($DBcon, "SELECT * FROM `term_text_twitter`");
		$total = mysqli_num_rows($total_tweet);
		$arr_jarak1 = array();
		$sqrt_cluster = 0;
				
		for($o=1; $o <= $total; $o++){
						
				$arr_jarak1[$o] = 0;
				$query_sum = mysqli_query($DBcon, "SELECT * FROM `tf_idf_document` WHERE no_doc=$o");
				//echo "Select * from doc ".$o."<br>";
				foreach ($query_sum as $qterm) {
					$termL = $qterm["term"];
					foreach ($arr_tklaster as $klTerm) {
						
						if(strcmp($klTerm[0], $termL) == 0){
						// echo "( ".$termL." )";
						$arr_jarak1[$o] = sqrt(($qterm["TF"] * $qterm["IDF"]) * ($klTerm[1] * $qterm["IDF"]));
						// echo "( ".number_format(($qterm["TF"]*$qterm["IDF"]), 4)." x ".number_format(($klTerm[1] * $qterm["IDF"]), 3)." ) +";
						}
						else{
							
						}
					}
				}
			
			$sqrtD = mysqli_query($DBcon, "SELECT * FROM `vector_document` WHERE no_doc=$o");
			$sqrtND = $sqrtD->fetch_assoc();
			$sqrtC = mysqli_query($DBcon, "SELECT * FROM `update_cluster_term` WHERE klaster=$clus");
			foreach ($sqrtC as $apa) {
				$kali = $apa["TF"] * $apa["IDF"];
				$sqrt_cluster = $sqrt_cluster + ($kali * $kali);
			}
			$sqrtNC = sqrt($sqrt_cluster);

			$vectorCND = $sqrtNC * $sqrtND["sqrt"];
			
			$cosin = $arr_jarak1[$o] / $vectorCND;
			
			$insert_jarak =  mysqli_query($DBcon, "INSERT INTO `jarak_cosinus_next`(no_doc,klaster,jarak_cosinus) VALUES ($o, $clus, $cosin)");
			//echo "Jarak document".$o." terhadap klaster".$clus." adalah ".$cosin." .<br>";
			if($cosin != 0){
				// echo "<br>Jarak doc".$o." trhd klaster".$clus." = ".number_format($cosin, 4)."<br>";
			}
		}	
		// echo "<br>";
}

function process_group_klaster_next(){
		include 'config/koneksi.php';
		  
		$DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
		 
	    if ($DBcon->connect_error) {
	         die("ERROR : -> ".$DBcon->connect_error);
	     }

		//$tweet = mysqli_query($DBcon, "SELECT * FROM `tf_idf_document`");
		$total_tweet = mysqli_query($DBcon, "SELECT * FROM `term_text_twitter`");
		$query_total = mysqli_query($DBcon, "SELECT * FROM `jarak_cosinus_next`");
		$total = mysqli_num_rows($total_tweet);
		$arr_cosinus = array();
		//$arr_sqrt = array();
		//$nodoc = array();
		while ($query_T = $query_total->fetch_assoc()) {
			if(isset($arr_cosinus[$query_T["no_doc"]])){
				$jarak_sb = $arr_cosinus[$query_T["no_doc"]]["jarak"];
				if($jarak_sb <= $query_T["jarak_cosinus"]){
					$arr_cosinus[$query_T["no_doc"]]["klaster"] = $query_T["klaster"];
					$arr_cosinus[$query_T["no_doc"]]["jarak"] = $query_T["jarak_cosinus"];
				}
				else{
					continue;
				}
			}else{
				$arr_cosinus[$query_T["no_doc"]] = array("klaster" => $query_T["klaster"], "jarak" => $query_T["jarak_cosinus"]);
			}
		}
		$y = 1;
		$angg_k = "";
		foreach ($arr_cosinus as $Aw) {
			if($Aw["jarak"] == 0){
				$angg_k .= " ".$y;
				
				// $insert_groupK =  mysqli_query($DBcon, "INSERT INTO `document_klaster_next`(no_doc,klaster) VALUES ($y, 0)");
			}else{
				$cluster = $Aw["klaster"];

				$insert_groupK =  mysqli_query($DBcon, "INSERT INTO `document_klaster_next`(no_doc,klaster) VALUES ($y, $cluster)");
				// 	echo "Document".$y." ada di klaster".$cluster."<br>";
			}

			$y++;
		}
		$angg_kosong = "[ ".$angg_k." ]";
		$insert_status_no = mysqli_query($DBcon, "UPDATE `status_data_set` SET nonanggota='$angg_kosong' WHERE status='new'");
}

function term_klaster_last($clus, $iterasi){
	include 'config/koneksi.php';
	  
	$DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
	    
    if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }
     if($iterasi == 2){
     	$update_cl4 = mysqli_query($DBcon, "SELECT * FROM `document_klaster_next` WHERE klaster=$clus");
     }elseif($iterasi == 3){
     	$update_cl4 = mysqli_query($DBcon, "SELECT * FROM `document_klaster_iterasi2` WHERE klaster=$clus");
     	mysqli_query($DBcon, "DELETE FROM `update_cluster_term_last` WHERE klaster=$clus");
     }
     
	foreach ($update_cl4 as $iter4) {
		$doc_no = $iter4["no_doc"];
		$geto_term4 = mysqli_query($DBcon, "SELECT * FROM `tf_idf_document` WHERE no_doc=$doc_no");
		foreach ($geto_term4 as $term_do4) {
		$termo4 = $term_do4["term"];
		$tfo4 = $term_do4["TF"];
		$idf4 = $term_do4["IDF"];
			$check_term_new14 = mysqli_query($DBcon, "SELECT TF FROM `update_cluster_term_last` WHERE term='$termo4' AND klaster=$clus");
			if($check_term_new14->num_rows != 0){
				$tf_kl14 = ($check_term_new14->fetch_assoc()["TF"]) + 1;
				$update_new_term24 = mysqli_query($DBcon, "UPDATE `update_cluster_term_last` SET TF=$tf_kl14 WHERE term='$termo4' AND klaster=$clus");
				if($update_new_term24){
					// echo "Update term beres <br>";
				}
			}else{
				$insert_new_term34 = mysqli_query($DBcon, "INSERT INTO `update_cluster_term_last`(klaster,term,TF,IDF) VALUES ($clus, '$termo4', $tfo4, $idf4)");
				if($insert_new_term34){
					// echo "Insert term Beres<br>";
				}
			}
		}
	}
	// $select_term_new = mysqli_query($DBcon, "SELECT * FROM `update_cluster_term_last` WHERE klaster=$clus");
	 // echo "Update term klaster".$clus."<br><( ";
	// foreach ($select_term_new as $z) {
	// 	echo $z["term"].", ";
	// }
	// echo " )<br>";
}

function Next_iterasi2($clus, $iterasi){
		include 'config/koneksi.php';
		  
		$DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
		    
	    if ($DBcon->connect_errno) {
	         die("ERROR : -> ".$DBcon->connect_error);
	     }
	     
	    // klaster 3, 29 dan 54
	     $arr_tklaster = array();
		$term_k = mysqli_query($DBcon, "SELECT * FROM `update_cluster_term_last` WHERE klaster=$clus");
		foreach($term_k as $word){
			//echo "Term ".$word["term"]." klaster<br>";
			array_push($arr_tklaster, array($word["term"], $word["TF"]));
		}
		$total_tweet = mysqli_query($DBcon, "SELECT * FROM `term_text_twitter`");
		$total = mysqli_num_rows($total_tweet);
		$arr_jarak1 = array();
		$sqrt_cluster = 0;
				
		for($o=1; $o <= $total; $o++){
				
				$arr_jarak1[$o] = 0;
				$query_sum = mysqli_query($DBcon, "SELECT * FROM `tf_idf_document` WHERE no_doc=$o");
				//echo "Select * from doc ".$o."<br>";
				foreach ($query_sum as $qterm) {
					$termL = $qterm["term"];
					foreach ($arr_tklaster as $klTerm) {
						
						if(strcmp($klTerm[0], $termL) == 0){
						// echo "( ".$termL." )";
						$arr_jarak1[$o] = sqrt(($qterm["TF"] * $qterm["IDF"]) * ($klTerm[1] * $qterm["IDF"]));
						// echo "( ".number_format(($qterm["TF"]*$qterm["IDF"]), 4)." x ".number_format(($klTerm[1] * $qterm["IDF"]), 3)." ) +";
						}
						else{
							
						}
					}
				}
			
			$sqrtD = mysqli_query($DBcon, "SELECT * FROM `vector_document` WHERE no_doc=$o");
			$sqrtND = $sqrtD->fetch_assoc();
			$sqrtC = mysqli_query($DBcon, "SELECT * FROM `update_cluster_term_last` WHERE klaster=$clus");
			foreach ($sqrtC as $apa) {
				$kali = $apa["TF"] * $apa["IDF"];
				$sqrt_cluster = $sqrt_cluster + ($kali * $kali);
			}
			$sqrtNC = sqrt($sqrt_cluster);

			$vectorCND = $sqrtNC * $sqrtND["sqrt"];
			
			$cosin = $arr_jarak1[$o] / $vectorCND;
			if($iterasi == 3){
		     	mysqli_query($DBcon, "DELETE FROM `jarak_cosinus_next2` WHERE klaster=$clus AND no_doc=$o");
		     }
			$insert_jarak =  mysqli_query($DBcon, "INSERT INTO `jarak_cosinus_next2`(no_doc,klaster,jarak_cosinus) VALUES ($o, $clus, $cosin)");
			//echo "Jarak document".$o." terhadap klaster".$clus." adalah ".$cosin." .<br>";
			if($cosin != 0){
				// echo "<br>".$o." ".$clus." = ".number_format($cosin, 5)."<br>";
			}
		}	
		// echo "<br>";
}

function process_group_klaster_2($iterasi){
		include 'config/koneksi.php';
		  
		$DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
		 
	    if ($DBcon->connect_error) {
	         die("ERROR : -> ".$DBcon->connect_error);
	     }
	     if($iterasi == 3){
			     	
			     	mysqli_query($DBcon, "TRUNCATE TABLE `document_klaster_iterasi2`");
		 }

		//$tweet = mysqli_query($DBcon, "SELECT * FROM `tf_idf_document`");
		$total_tweet = mysqli_query($DBcon, "SELECT * FROM `term_text_twitter`");
		$query_total = mysqli_query($DBcon, "SELECT * FROM `jarak_cosinus_next2`");
		$total = mysqli_num_rows($total_tweet);
		$arr_cosinus = array();
		//$arr_sqrt = array();
		//$nodoc = array();
		while ($query_T = $query_total->fetch_assoc()) {
			if(isset($arr_cosinus[$query_T["no_doc"]])){
				$jarak_sb = $arr_cosinus[$query_T["no_doc"]]["jarak"];
				if($jarak_sb <= $query_T["jarak_cosinus"]){
					$arr_cosinus[$query_T["no_doc"]]["klaster"] = $query_T["klaster"];
					$arr_cosinus[$query_T["no_doc"]]["jarak"] = $query_T["jarak_cosinus"];
				}
				else{
					continue;
				}
			}else{
				$arr_cosinus[$query_T["no_doc"]] = array("klaster" => $query_T["klaster"], "jarak" => $query_T["jarak_cosinus"]);
			}
		}
		$y = 1;
		$angg_k = "";
		foreach ($arr_cosinus as $Aw) {
			if($Aw["jarak"] == 0){
				$angg_k .= " ".$y;
				
				// $insert_groupK =  mysqli_query($DBcon, "INSERT INTO `document_klaster_next`(no_doc,klaster) VALUES ($y, 0)");
			}else{
				$cluster = $Aw["klaster"];
				
				$insert_groupK =  mysqli_query($DBcon, "INSERT INTO `document_klaster_iterasi2`(no_doc,klaster) VALUES ($y, $cluster)");
				// echo "Document".$y." ada di klaster".$cluster."<br>";
			}

			$y++;
		}
		$angg_kosong = "[ ".$angg_k." ]";
		$insert_status_no = mysqli_query($DBcon, "UPDATE `status_data_set` SET nonanggota='$angg_kosong' WHERE status='new'");	
}

function jarak_C_doc($clus){
	include 'config/koneksi.php';
	  
	$DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
	    
    if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }

     term_klaster_last($clus, 3);
    
  	 $arr_tklaster = array();
		$term_k1 = mysqli_query($DBcon, "SELECT * FROM `update_cluster_term_last` WHERE klaster=$clus");
		foreach($term_k1 as $word){
			//echo "Term ".$word["term"]." klaster<br>";
			array_push($arr_tklaster, array($word["term"], $word["TF"]));
		}
		$total_tweet = mysqli_query($DBcon, "SELECT * FROM `term_text_twitter`");
		$total = mysqli_num_rows($total_tweet);
		$arr_jarak1 = array();
		$sqrt_cluster = 0;

		$q_tot_doc_c = mysqli_query($DBcon, "SELECT * FROM `document_klaster_iterasi2` WHERE klaster=$clus");
		
			
		
				
		foreach ($q_tot_doc_c as $total) {
				$o = $total["no_doc"];
				$arr_jarak1[$o] = 0;
				$query_sum = mysqli_query($DBcon, "SELECT * FROM `tf_idf_document` WHERE no_doc=$o");
				//echo "Select * from doc ".$o."<br>";
				foreach ($query_sum as $qterm) {
					$termL = $qterm["term"];
					foreach ($arr_tklaster as $klTerm) {
						
						if(strcmp($klTerm[0], $termL) == 0){
					//	echo $termL." ( ";
						$arr_jarak1[$o] = $arr_jarak1[$o] + (sqrt(($qterm["TF"] * $qterm["IDF"]) * ($klTerm[1] * $qterm["IDF"])));
					//	echo ($qterm["TF"] * $qterm["IDF"])." x ".($klTerm[1] * $qterm["IDF"])." ) +";
						}
						else{
							
						}
					}
					// echo " ) + ";
				}
			
			$sqrtD = mysqli_query($DBcon, "SELECT * FROM `vector_document` WHERE no_doc=$o");
			$sqrtND = $sqrtD->fetch_assoc();
			$sqrtC = mysqli_query($DBcon, "SELECT * FROM `update_cluster_term_last` WHERE klaster=$clus");
			foreach ($sqrtC as $apa) {
				$kali = $apa["TF"] * $apa["IDF"];
				$sqrt_cluster = $sqrt_cluster + ($kali * $kali);
			}
			$sqrtNC = sqrt($sqrt_cluster);

			$vectorCND = $sqrtNC * $sqrtND["sqrt"];
			
			$cosin = $arr_jarak1[$o] / $vectorCND;
			
			$insert_jarak =  mysqli_query($DBcon, "INSERT INTO `jarak_c_d`(no_doc,klaster,jarak) VALUES ($o, $clus, $cosin)");
			if($cosin != 0){
		//		echo "<br>Jarak document".$o." terhadap klaster".$clus." adalah ".$cosin." .<br><br>";
			}
		}
		echo "<br>";
}

function jarak_klaster($cl1, $cl2){
	include 'config/koneksi.php';
	  
	$DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
	    
    if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }

		$sqrt_cluster1 = 0;
		$sqrt_cluster2 = 0;
		$sqrtNC1 = 0;
		$sqrtNC2 = 0;
				
			$sqrtC1 = mysqli_query($DBcon, "SELECT * FROM `update_cluster_term_last` WHERE klaster=$cl1");
			foreach ($sqrtC1 as $apa1) {
				$kali1 = $apa1["TF"] * $apa1["IDF"];
				$sqrt_cluster1 = $sqrt_cluster1 +  $kali1;
			}
			$sqrtNC1 = sqrt($sqrt_cluster1);
			// echo "<br>Vector dari cluster1 = ".number_format($sqrtNC1, 6);

			$sqrtC2 = mysqli_query($DBcon, "SELECT * FROM `update_cluster_term_last` WHERE klaster=$cl2");
			foreach($sqrtC2 as $apa2) {
				$kali2 = $apa2["TF"] * $apa2["IDF"];
				$sqrt_cluster2 = $sqrt_cluster2 + $kali2;
			}
			$sqrtNC2 = sqrt($sqrt_cluster2);
			// echo "<br>Vector dari cluster1 = ".number_format($sqrtNC2, 6);
			// echo "Vector C".$cl1." = ".$sqrtNC1."<br>";
			// echo "Vector C".$cl2." = ".$sqrtNC2."<br>";
			$cosinus1 = abs(number_format($sqrtNC2, 6) - number_format($sqrtNC1, 6));
			// echo "<br>Klaster".$cl1." dan vectorklaster = ".number_format($sqrtNC1, 6)
			// ."<br> Klaster".$cl2." dan vector klaster = ".number_format($sqrtNC2, 6)."  ";
			// echo "Nilai SSBC".$cl1."C".$cl2." = ".$cosinus1."<br>";
	return $cosinus1;		
}

function proses_dbi($cl1, $cl2){
	include 'config/koneksi.php';
	  
	$DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
	    
    if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }
     $total_c1 = 0;
     $jml_c1 = mysqli_query($DBcon, "SELECT * FROM `jarak_c_d` WHERE klaster=$cl1");
     $TDC1 = mysqli_query($DBcon, "SELECT * FROM `document_klaster_iterasi2` WHERE klaster=$cl1");
     foreach ($jml_c1 as $datac1) {
     	$total_c1 += $datac1["jarak"];
     }
     $total_c2 = 0;
     $jml_c2 = mysqli_query($DBcon, "SELECT * FROM `jarak_c_d` WHERE klaster=$cl2");
     $TDC2 = mysqli_query($DBcon, "SELECT * FROM `document_klaster_iterasi2` WHERE klaster=$cl2");
     foreach ($jml_c2 as $datac2) {
     	$total_c2 += $datac2["jarak"];
     }
     $total_c1 = number_format($total_c1, 6);
     $total_c2 = number_format($total_c2, 6);
     $jarak_c1c2 = jarak_klaster($cl1, $cl2);

     $Rc1c2 = (($total_c1 / $TDC1->num_rows) + ($total_c2 / $TDC2->num_rows)) / $jarak_c1c2;   
     $aaa = $total_c1 / $TDC1->num_rows;
     $bbb = $total_c2 / $TDC2->num_rows;
     // echo "TOtal dokumen dalam C".$cl1." = ".$TDC1->num_rows."<br>";
     // echo "TOtal dokumen dalam C".$cl2." = ".$TDC2->num_rows."<br>";
     // echo "Nilai SSWC".$cl1." => ".$total_c1." = ".$aaa."<br>";
     // echo "Nilai SSWC".$cl2." => ".$total_c2." = ".$bbb."<br>";
     // echo "Nilai RC".$cl1."C".$cl2." = ".$Rc1c2."<br>";  

     // echo "<br>VectorKlaster1 = ".$total_c1."dan vector klaster2 = ".$total_c2."<br>";
     // echo "Jarak vector dua klaster = ".$jarak_c1c2;
     // echo "<br>RC1C2 = ".$Rc1c2."<br>";
     $insert_pdbi = mysqli_query($DBcon, "INSERT INTO `dbi`(id_datasets,C1,vectorklaster1,C2,vectorklaster2,klaster_cosinus,RC1C2) 
     	VALUES('','$cl1', $aaa, '$cl2', $bbb, $jarak_c1c2, $Rc1c2)");
}	



?>

