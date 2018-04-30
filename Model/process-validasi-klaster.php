<?php 

ini_set('max_execution_time', 300);

include 'config/koneksi.php';

  $arr_anggota_c = array();
  $klas = "";
  $tiapanggota = "";
  $arr_kl = "";
  $q_klaster = mysqli_query($DBcon, "SELECT DISTINCT klaster FROM `document_klaster_iterasi2`");
  foreach ($q_klaster as $q_klasterP) {
    $o = $q_klasterP["klaster"];
    $klas .= $o.", ";
    $update_cl = mysqli_query($DBcon, "SELECT * FROM `document_klaster_iterasi2`");
    $str = "";
    //echo "Array klaster ke".$o." = ";
    foreach ($update_cl as $que_cluster) {
      if($que_cluster["klaster"] == $o){
        $str .= " ".$que_cluster["no_doc"];
      }
    }
    $tiapanggota .= "[ ".$str." ] ";
    //echo $str."<br>";
    $arr_kl = $str.", ".$arr_kl;
  }
  $ch_max = 0;

  $query_dbi = mysqli_query($DBcon, "SELECT * FROM `dbi`");
  foreach ($query_dbi as $dat_dbi) {
    if(isset($ch_max)){
      $ch_max = $dat_dbi["RC1C2"];
    }elseif($ch_max <= $dat_dbi["RC1C2"]){
      $ch_max = $dat_dbi["RC1C2"];
    }
  }
  $res_dbi = $ch_max / ($q_klaster->num_rows);

  // echo "Terdapat 3 klaster yaitu klaster ".$klas;
  // echo "<br>Dengan tiap anggota ".$tiapanggota;

  // echo "DBI = ".$res_dbi;

  if ($angg = mysqli_query($DBcon, "UPDATE `status_data_set` SET klaster='$klas', anggota='$arr_kl', status='finish', result_dbi=$res_dbi WHERE status='new'")) {
    //mysqli_query($DBcon, "TRUNCATE TABLE `dbi`");
    mysqli_query($DBcon, "TRUNCATE TABLE `document_klaster_next`");
    mysqli_query($DBcon, "TRUNCATE TABLE `document_klaster`");
    mysqli_query($DBcon, "TRUNCATE TABLE `document_klaster_iterasi2`");
    // mysqli_query($DBcon, "TRUNCATE TABLE `jarak_c_d`");
    mysqli_query($DBcon, "TRUNCATE TABLE `jarak_cosinus`");
    mysqli_query($DBcon, "TRUNCATE TABLE `jarak_cosinus_next`");
    mysqli_query($DBcon, "TRUNCATE TABLE `jarak_cosinus_next2`");
    mysqli_query($DBcon, "TRUNCATE TABLE `term_text_twitter`");
    mysqli_query($DBcon, "TRUNCATE TABLE `table_term`");
    mysqli_query($DBcon, "TRUNCATE TABLE `text_twitter`");
    mysqli_query($DBcon, "TRUNCATE TABLE `tf_idf_document`");
    mysqli_query($DBcon, "TRUNCATE TABLE `update_cluster_term`");
    mysqli_query($DBcon, "TRUNCATE TABLE `vector_document`");
    mysqli_query($DBcon, "TRUNCATE TABLE `jarak_c_d`");
    mysqli_query($DBcon, "TRUNCATE TABLE `update_cluster_term_last`");

    echo "Record deleted successfully";
    echo '<script>window.alert("Klasterisasi berhasil divalidasi");
    window.location=("index.php?halaman=klastering")</script>';
} else {
    echo "Error deleting record: " . mysqli_error($DBcon);
}

function kontent_klaster($clus){
  include 'config/koneksi.php';
    
    $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
      
     if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }
     $arr_kontent = "( ";
    
     $update_cl41 = mysqli_query($DBcon, "SELECT * FROM `update_cluster_term_last` WHERE klaster=$clus");
  foreach ($update_cl41 as $iter41) {
    if(strcmp($iter41["term"], "koneksi") || strcmp($iter41["term"], "bayar") || strcmp($iter41["term"], "cover")){
      $arr_kontent .= $iter41["term"]." ";
      
    }
    elseif($iter41["TF"] >= 4){
      $arr_kontent .= $iter41["term"]." ";
      
    }else{
      continue;
    }
  }
  $arr_kontent .= " )";
   return $arr_kontent;
}
  
?>