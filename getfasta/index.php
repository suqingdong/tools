<html>
<head>
<meta charset="utf-8">
<title>GetFasta | NovoGenolyzer</title>
<link rel="stylesheet" type="text/css" href="../static/css/bootstrap.min.css" />
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
        <li><a href="/home">主页</a></li>
        <li><a href="/categories">论坛</a></li>
        <li><a href="/recent">最新</a></li>
        <li><a href="/tags">话题</a></li>
        <li><a href="/popular">热门</a></li>
        <li><a href="/users">会员</a></li>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<div class="container">
  <h1>根据输入Bed区间，获取fasta序列文件</h1>
  <div class="row">
    <div class="col-md-6">

      <div id="error"></div>  
        
      <form class="form" action="" method="post" enctype="multipart/form-data" >

        <div class="input-group">
          <span class="input-group-addon">参考基因组</span>
          <select class="form-control" name="refversion">
            <option value="hg19">hg19/b37</option>
            <option value="hg38">hg38/b38</option>
          </select>
        </div>
        <br>

        <div class="input-group">
          <span class="input-group-addon">输入Bed文件</span>
          <input type="file" class="form-control" name="bedfile">
        </div> 
        <br>

        <div class="input-group">
          <span class="input-group-addon">输入Bed区间</span>
          <input type="text" class="form-control" name="bedstring" placeholder="1:100000-100100">
        </div> 
        <br>


        <button type="button" class="btn btn-warning" style="width:49%;" id="demo">Demo</button>
        <button type="submit" class="btn btn-success" style="width:50%;">开始获取</button>
        
      </form>

    </div>
    <div class="col-md-6">
      <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#shuoming" aria-controls="shuoming" role="tab" data-toggle="tab">说明</a></li>
          <li role="presentation"><a href="#shili" aria-controls="shili" role="tab" data-toggle="tab">示例</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="shuoming">
            <h3>说明</h3><br>
            <h4>可上传Bed文件或输入bed区间</h4><br>

            <p>输入Bed文件: Tab分隔的bed文件</p>
            <p>输入Bed区间: chr:start-end格式的字符串</p><br>

            <h4>输出结果: 得到的对应区间的fasta序列</h4>
          </div>
          <div role="tabpanel" class="tab-pane" id="shili">
            <p><a href="upload/test.txt" target="_blank">输入文件(可右键另存为)</a></p>
            <img src="upload/test.txt.png">
            <p><a href="#" >输出结果</a></p>
            <img src="upload/test.png" width="500px">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="../static/js/jquery.min.js"></script>
<script src="../static/js/bootstrap.min.js"></script>

<script>
  
$(document).ready(function() {
  $('#demo').click(function() {
    if( $('select[name="refversion"]').val()==='hg19' ) {
      $('input[name="bedstring"]').val('1:100000-100100');
    } else if ( $('select[name="refversion"]').val()==='hg38' ) {
      $('input[name="bedstring"]').val('chr1:100000-100100');
    }
  });
});

</script>



<!-- Handle POST -->
<div class="container">
  
<?php
//echo 'Request Method: '.$_SERVER['REQUEST_METHOD'].'<br>';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  include 'getfasta.php';
}
?>

</div>


</body>
</html>