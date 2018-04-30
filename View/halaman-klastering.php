
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.php">Dasboard</a>
        </li>
        <li class="breadcrumb-item active">Hasil Klastering</li>
        
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          
          <button onclick="window.location.href='index.php?halaman=klastering&act=process'">Process</button>

          <button onclick="window.location.href='index.php?halaman=klastering&act=term'">Show TermKata</button>
          <button onclick="window.location.href='index.php?halaman=klastering&act=tfidf'">Show TF-IDF</button>
          <button onclick="window.location.href='index.php?halaman=klastering&act=jarak'">Show JarakDocument</button>
          <button onclick="window.location.href='index.php?halaman=klastering&act=iterasi1'">Show Iterasi1</button>
          <button onclick="window.location.href='index.php?halaman=klastering&act=result'">Show ResultKlaster</button>
          <button onclick="window.location.href='index.php?halaman=klastering&act=validasi'" onclick="return confirm('Are your sure?')">Validasi HasilKlastering</button>
          
          </div>
        <div class="card-body">
        

          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <?php
                include 'Control/control-klastering.php';
              ?>
            </table>
          </div>


        </div>
        
      </div>
    </div>