<?php 

ini_set('max_execution_time', 300);
	
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

  $update_cl = mysqli_query($DBcon, "SELECT * FROM `document_klaster`");
  
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

