<html>
<head>
<meta charset="utf-8">
<title>Transvar</title>
<link rel="stylesheet" type="text/css" href="../static/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="../static/css/dataTables.bootstrap.min.css" />
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">NovoGenolyzer</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="/homepage">主页</a></li>
        <li><a href="/categories">论坛</a></li>
        <li><a href="/recent">最新</a></li>
        <li><a href="/tags">话题</a></li>
        <li><a href="/popular">热门</a></li>
        <li><a href="/users">会员</a></li>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<div class="container">
  
  <div id="error">    
  </div>

  <form class="form" action="" method="post" enctype="multipart/form-data" >
    <div class="row">

      <div class="col-md-6">

        <div class="input-group">
          <span class="input-group-addon">参考基因组</span>
          <select class="form-control" name="refversion">
            <option value="hg19">hg19(b37)</option>
            <option value="hg38" disabled title="not supported yet">hg38(b38)</option>
            <option value="mm10" disabled title="not supported yet">mm10</option>
          </select>
        </div>        
        <br>


        <div class="input-group">
          <span class="input-group-addon">查询类型</span>
          <select class="form-control" name="search-type" id="search-type">
            <option value="cdna">cDNA</option>
            <option value="gdna">gDNA</option>
            <option value="protein">Protein</option>
            <option value="codon">Codon Search</option>
          </select>
          <span class="input-group-btn">
            <button class="btn btn-default" type="button" id="fill-demo">Demo</button>
          </span>
        </div>        
        <br>

        <div class="input-group">
          <span class="input-group-addon" id="database">数据库</span>
          <div class="form-control">          
            <label><input type="checkbox" name="database[]" value="ccds">CCDS </label>
            <label><input type="checkbox" name="database[]" value="ucsc">UCSC </label>
            <label><input type="checkbox" name="database[]" value="refseq">RefSeq </label>
            <label><input type="checkbox" name="database[]" value="ensembl">Ensembl </label>
            <label><input type="checkbox" name="database[]" value="gencode">GENCODE </label>
            <label><input type="checkbox" name="database[]" value="aceview">AceView </label>
          </div>
          <span class="input-group-btn">
            <button class="btn btn-default" type="button" id="select-all">All</button>
          </span>
        </div>
        <br>


      </div> <!-- class="col-md-6" -->

      <div class="col-md-6">

        <div class="input-group">
          <span class="input-group-addon">查询文件</span>
          <input type="file" class="form-control" name="search-file">
          <span class="input-group-addon"><i class="glyphicon glyphicon-question-sign" id="search-file-help"></i></span>
        </div>        
        <br>

        <div class="form-group">
          <label class="control-label">查询条件</label>
          <textarea class="form-control" name="search-string" id="search-string"  style="max-height:200px;max-width:100%;" placeholder="eg. COL2A1:c.4251_4253" ></textarea>
        </div>

      </div> <!-- class="col-md-6" -->

    </div>
    
    <button type="submit" class="btn btn-success" style="width:100%;margin-left:0%;">开始查询</button>
  
  </form>
</div>  <!-- container -->

<!-- Modal -->
<div class="modal fade" id="search-file-help-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title">查询文件格式说明</h3>
      </div>
      <div class="modal-body">
        <h4>根据输入列表文件进行批量查询</h4>
        <p>例1, cDNA批量查询,下载<a href="input_table.txt" target="_blank">测试文件</a>(查询类型选择cDNA)</p>
        <pre>PIK3CA:c.1633G>A
ABCB11:c.1198-8C>A
ABCB11:c.1198-8_1202
ACIN1:c.1932_1933insATTCAC
AATK:c.3976_3977insCGCCCA
        </pre>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> <!-- Modal -->




<script src="../static/js/jquery.min.js"></script>
<script src="../static/js/bootstrap.min.js"></script>
<script src="../static/js/jquery.dataTables.min.js"></script>
<script src="../static/js/dataTables.bootstrap.min.js"></script>

<script>

  $('#search-type').change(function(){
    $('#search-string').text('');
  });

  $('#fill-demo').click(function(){
    var searchType = $('#search-type').find('option:selected').val();
    if(searchType==='protein') {
      $('#search-string').text('PIK3CA:p.E545K');
    } else if(searchType==='gdna') {
      $('#search-string').text('chr3:g.178936091G>A');      
    } else if(searchType==='cdna') {
      $('#search-string').text('PIK3CA:c.1633G>A');      
    } else if(searchType==='codon') {
      $('#search-string').text('CDKN2A:p.58');      
    }

    $('input[name="database[]"]').each(function(){
      if(this.value==='ccds'){  //choose ccds only
        this.checked = true;
      } else {
        this.checked = false;
      }
    });

  });

  $('#search-file-help').click(function(){
    console.log('help for search file');
    $('#search-file-help-modal').modal();
  });


  $('#select-all').click(function(){
    var selectedALL = true;
    $('input[name="database[]"]').each(function() {
      if(! this.checked){
        selectedALL = false;
      }
    });
    if(selectedALL) {
      $('input[name="database[]"]').each(function() {
        this.checked = false;
      });
    } else {
      $('input[name="database[]"]').each(function() {
        this.checked = true;
      });      
    }
  });


</script>



<!-- Handle POST -->
<div class="container">

<?php
//echo 'Request Method: '.$_SERVER['REQUEST_METHOD'].'<br>';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  include 'transvar.php';
}
?>
  
</div>



</body>
</html>