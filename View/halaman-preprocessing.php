
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Hasil Preprocessing</li>
        <li class="breadcrumb-item">
          <a href="index.php?halaman=preprocessing&act=token">Tokenization</a>
        </li>
        <li class="breadcrumb-item">
          <a href="index.php?halaman=preprocessing&act=stemming">Stemming</a>
        </li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Hasil Text Preprocessing
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
              <tbody>
                <?php
                  include 'Control/control-preprocessing.php';
                ?>
              </tbody>
            </table>
          </div>
        </div>
        
      </div>
    </div>