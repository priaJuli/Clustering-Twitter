<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Crawling Twitter</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Crawling Data Twitter
          <button onclick="window.location.href='index.php?halaman=preprocessing'">Text Preprocessing</button>
          </div>
        <div class="card-body">
        <form action="" method="post" id="formAction">
          <label><input type="date" name="until" value="<?php echo date("Y-m-d");?>" /> </label>
          
          <button type="submit" name="submit" value="submit">Submit</button>
          <button type="submit" name="reset" value="reset">Reset</button>
            
        </form>
        </div>
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No Document</th>
                  <th>Text Data</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No Document</th>
                  <th>Text Data</th>
                  
                </tr>
              </tfoot>
              <tbody id="data-content">
                <?php 
                if(isset($_POST["until"])){
                  require_once "Model/twitteroauth-master/autoload.php";
                  include "Model/twitteroauth-master/tweetBiznetTables.php";  
                }elseif(isset($_POST["reset"])){
                  require_once "Model/twitteroauth-master/autoload.php";
                  
                  include "Model/twitteroauth-master/tweetBiznetTables.php";  
                }
                ?>
              </tbody>
            </table>
          </div>


        </div>
        
      </div>
    </div>