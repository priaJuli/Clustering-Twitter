<thead>
    <tr>
      <th>No Doc</th>
      <th>Kata Dasar</th>
      <th>Term Frequency</th>
      <th>Inverse Document Frequency</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th>No Doc</th>
      <th>Kata Dasar</th>
      <th>Term Frequency</th>
      <th>Inverse Document Frequency</th>
    </tr>
  </tfoot>
  <tbody id="data-content">
<?php 

ini_set('max_execution_time', 300);

//`text_twitter`


//$tweet = $_POST["text"];

//end foreach string1

  $tweet1 = mysqli_query($DBcon, "SELECT * FROM `tf_idf_document`");
  
  foreach ($tweet1 as $result12) {
  ?>
    <tr>
      <td><?php echo $result12["no_doc"];?></td>
      <td><?php echo $result12["term"];?></td>
      <td><?php echo $result12["TF"];?></td>
      <td><?php echo $result12["IDF"];?></td>
    </tr>
    <?php
  }

?>

</tbody>
