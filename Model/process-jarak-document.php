<?php 

ini_set('max_execution_time', 300);
	
?>
<thead>
    <tr>
      <th>No Document</th>
      <th>Klaster</th>
      <th>Jarak Cosinus</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th>No Document</th>
      <th>Klaster</th>
      <th>Jarak Cosinus</th>
    </tr>
  </tfoot>
  <tbody id="data-content">
<?php 

ini_set('max_execution_time', 300);

//`text_twitter`


//$tweet = $_POST["text"];

//end foreach string1

  $update_cl = mysqli_query($DBcon, "SELECT * FROM `jarak_cosinus`");
  
  foreach ($update_cl as $result12) {
  ?>
    <tr>
      <td><?php echo $result12["no_doc"];?></td>
      <td><?php echo $result12["klaster"];?></td>
      <td><?php 
      if($result12["jarak_cosinus"] == 0){
      	echo "Tidak Ada Kemiripan";
      }else{
      	echo $result12["jarak_cosinus"];
      }
      ?></td>

    </tr>
    <?php
  }

?>

</tbody>