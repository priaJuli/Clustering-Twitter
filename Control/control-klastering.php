
<?php
    if(!@$_GET['act']){
      echo "<p><b2>Halaman hasil Process Klastering</b2></p>";
      include "config/koneksi.php";

      $search = mysqli_query($DBcon, "SELECT * FROM `text_twitter`");
      if(mysqli_num_rows($search) > 0){
        
      }else{
        echo '<script>window.alert("Lakukan Crawling Data Terlebih Dahulu");window.location.href="index.php?halaman=Get-tweet";</script>';

      }
    } 
    elseif($_GET['act'] == 'process') {
      include 'config/koneksi.php';
      include "Model/tokenizer-master/try.php";
      include "Model/sastrawi-master/try.php";
      include_once "Model/process-term-all.php"; 

      echo '<script>window.alert("Berhasil Process Term");window.location=("index.php?halaman=klastering&act=term")</script>';
    } elseif ($_GET['act'] == 'tfidf') {
      include 'config/koneksi.php';
      include_once "Model/process-tidf-doc.php"; 
    } elseif ($_GET['act'] == 'term') {
      include 'config/koneksi.php';
      include_once "Model/process-show-term.php"; 
    } elseif ($_GET['act'] == 'jarak') {
      include 'config/koneksi.php';
      include_once "Model/process-jarak-document.php"; 
    } elseif ($_GET['act'] == 'iterasi1') {
      include 'config/koneksi.php';
      include_once "Model/process-group-klaster.php"; 
    } elseif ($_GET['act'] == 'result') {
      include 'config/koneksi.php';
      include_once "Model/process-result-klaster.php"; 
    } elseif ($_GET['act'] == 'validasi') {
      include 'config/koneksi.php';
      include_once "Model/process-validasi-klaster.php"; 
    }
?>
