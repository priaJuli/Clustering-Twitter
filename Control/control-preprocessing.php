<?php
    if(!isset($_GET['act'])){
      include "config/koneksi.php";

      $search = mysqli_query($DBcon, "SELECT * FROM `text_twitter`");
      if(mysqli_num_rows($search) > 0){
        
      }else{
        echo '<script>window.alert("Lakukan Crawling Data Terlebih Dahulu");window.location.href="index.php?halaman=Get-tweet";</script>';
      }
    }
    elseif($_GET['act'] == 'token') {
      include "Model/tokenizer-master/try.php";      
      include_once "Model/twitteroauth-master/View/tables-token.php"; 

    } elseif ($_GET['act'] == 'stemming') {
      include "Model/tokenizer-master/try.php";
      include "Model/sastrawi-master/try.php";

      include_once "Model/twitteroauth-master/View/tables-proses.php"; 
    }
?>