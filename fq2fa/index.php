<html>
<head>
<meta charset="utf-8">
<title>Fastq2Fasta</title>
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
        <li><a href="/categories">生信大课堂</a></li>
        <li><a href="/recent">最新</a></li>
        <li><a href="/tags">话题</a></li>
        <li><a href="/popular">热门</a></li>
        <li><a href="/users">会员</a></li>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<div class="container">
  <h1>将Fastq文件转换成Fasta文件</h1>
  <div class="row">
    <div class="col-md-6">

      <div id="error"></div>  
        
      <form class="form" action="" method="post" enctype="multipart/form-data" >

        <div class="input-group">
          <span class="input-group-addon">输入文件</span>
          <input type="file" class="form-control" name="file">
        </div> 
        <br>



        <div class="input-group">
          <span class="input-group-addon">是否输出压缩文件:</span>
          <select class="form-control" name="yasuo">
            <option value="false">否</option>
            <option value="true">是</option>
          </select>
        </div>
        <br />

        <button type="submit" class="btn btn-success" style="width:100%;margin-left:0%;">开始转换</button>

      </form>
    </div> <!-- col-md-6 -->

    <div class="col-md-6">

      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#shuoming" aria-controls="shuoming" role="tab" data-toggle="tab">说明</a></li>
        <li role="presentation"><a href="#shili" aria-controls="shili" role="tab" data-toggle="tab">示例</a></li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="shuoming">
          <h3>说明</h3>
        <p>输入文件: Fastq格式文件(接受.gz压缩文件)</p>
        <p>输出文件: Fasta格式文件</p>
        </div>
        <div role="tabpanel" class="tab-pane" id="shili">
          <p><a href="code/test.fq" target="_blank">输入文件(可右键另存为)</a></p>
          <img src="code/test.fq.png" width="100%">
        </div>
      </div>

    </div><!-- col-md-6 -->
  </div> <!-- row -->
</div> <!-- container -->




<script src="../static/js/jquery.min.js"></script>
<script src="../static/js/bootstrap.min.js"></script>


<!-- Handle POST -->
<div class="container">
  
<?php
//echo 'Request Method: '.$_SERVER['REQUEST_METHOD'].'<br>';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  include 'fq2fa.php';
}
?>

</div>



</body>
</html>