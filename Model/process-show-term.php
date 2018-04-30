<thead>
                <tr>
                  <th>Term Kata Dasar</th>
                  <th>Frekuensi Term</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Term Kata Dasar</th>
                  <th>Frekuensi Term</th>
                  
                </tr>
              </tfoot>
              <tbody id="data-content">
<?php
  $tweet1 = mysqli_query($DBcon, "SELECT * FROM `table_term`");
  

  foreach ($tweet1 as $result12) {
  ?>
    <tr>
      <td><?php echo $result12["term"];?></td>
      <td><?php echo $result12["count"];?></td>
    </tr>
    <?php
  }
?>

</tbody>