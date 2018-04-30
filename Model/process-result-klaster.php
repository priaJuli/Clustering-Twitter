<?php 

ini_set('max_execution_time', 300);

$update_cl = mysqli_query($DBcon, "SELECT * FROM `document_klaster_iterasi2`");
$total = mysqli_query($DBcon, "SELECT * FROM `term_text_twitter`");
$min_doc = mysqli_num_rows($total) - mysqli_num_rows($update_cl);
echo "Terdapat ".$min_doc." document yang tidak berada di klaster apapun";
?>
<thead>
    <tr>
      <th>No Document</th>
      <th>Klaster</th>
      
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th>No Document</th>
      <th>Klaster</th>
      
    </tr>
  </tfoot>
  <tbody id="data-content">
<?php 

ini_set('max_execution_time', 300);

//`text_twitter`
  

//$tweet = $_POST["text"];

//end foreach string1

  
  
  foreach ($update_cl as $result12) {
  ?>
    <tr>
      <td><?php echo $result12["no_doc"]." ( ";
      $stringdoc = mysqli_query($DBcon, "SELECT * FROM `term_text_twitter` WHERE no_doc=$result12[no_doc]");
      foreach ($stringdoc as $stra) {
        echo $stra["term"];
      }
      ?> )</td>
      <td><?php echo $result12["klaster"];?></td>
    </tr>
    <?php
  }

?>

</tbody>