<?php 

ini_set('max_execution_time', 300);


$update_cl = mysqli_query($DBcon, "SELECT * FROM `status_data_set`");


?>
<thead>
    <tr>
      <th>No Datasets</th>
      <th>Tanggal</th>
      <th>Pusat Cluster</th>
      <th>Cluster1</th>
      <th>Cluster2</th>
      <th>Cluster3</th>
      <th>Document Out of Cluster</th>
      <th>Result DBI</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th>No Datasets</th>
      <th>Tanggal</th>
      <th>Pusat Cluster</th>
      <th>Cluster1</th>
      <th>Cluster2</th>
      <th>Cluster3</th>
      <th>Document Out of Cluster</th>
      <th>Result DBI</th>
    </tr>
  </tfoot>
  <tbody id="data-content">
<?php 

ini_set('max_execution_time', 300);

//`text_twitter`
  

//$tweet = $_POST["text"];

//end foreach string1
  
  foreach ($update_cl as $result3) {
    ?>
    <tr>
      <td><?php echo $result3["id_datasets"];?></td>
      <td><?php echo $result3["tanggal"];?></td>
      <td><?php echo $result3["klaster"];?></td>
      <?php $arr_kl = explode(', ', $result3["anggota"]);
          foreach ($arr_kl as $kla ) {
            if(strlen($kla) > 3){
            ?><td><?php echo $kla;?></td>
       <?php
            }
          }
       ?>
      <td><?php echo $result3["nonanggota"];?></td>
      <td><?php echo $result3["result_dbi"];?></td>
    </tr>
    
    <?php
  }

?>

</tbody>