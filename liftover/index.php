<html>
<head>
<meta charset="utf-8">
<title>LiftOver | NovoGenolyzer</title>
<link rel="stylesheet" type="text/css" href="../static/css/bootstrap.min.css" />

<style>
</style>

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
  <h1>参考基因组间坐标转换</h1>
  <div class="row">
    <div class="col-md-6">

      <div id="error"></div>  
        
      <form class="form" action="" method="post" enctype="multipart/form-data" >

        <div class="input-group">

          <span class="input-group-addon">物种</span>
          <select class="form-control" name="species">
            <option value="human">Human</option>
          </select>

          <span class="input-group-addon">From</span>
          <select class="form-control" name="from-refversion">
            <option value="hg19">hg19/b37</option>
            <option value="hg38">hg38/b38</option>
          </select>

          <span class="input-group-addon">To</span>
          <select class="form-control" name="to-refversion">
            <option value="hg38">hg38/b38</option>
            <option value="hg19">hg19/b37</option>
          </select>
        </div>
        <br>

        <div class="input-group">
          <span class="input-group-addon">输入Bed文件</span>
          <input type="file" class="form-control" name="bedfile">
        </div> 
        <br>

<!-- 
        <div class="input-group">
          <span class="input-group-addon">输入Bed区间</span>
          <textarea class="form-control" name="bedstring" style="max-height:200px;max-width:100%"></textarea>
        </div> 
        <br>
 -->
        <div class="form-group">
          <label class="control-label">输入Bed区间</label>
          <textarea class="form-control" name="bedstring" style="max-height:200px;max-width:100%;" placeholder="chr1 213941196 213942363" ></textarea>
        </div>

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
            <p>输入Bed区间: 空格分隔的bed字符串</p><br>

            <h4>输出结果: 得到转换后的坐标bed文件</h4>
          </div>
          <div role="tabpanel" class="tab-pane" id="shili">
            <p><a href="test/input.hg19.bed" target="_blank">输入文件(可右键另存为)</a></p>
            <img src="test/input.hg19.bed.png">
            <p><a href="#" >输出结果</a></p>
            <img src="test/output.hg38.bed.png">
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
    $('textarea[name="bedstring"]').val('chr1 213941196 213942363');
  });

  $('select[name="from-refversion"]').change(function(){
    if ( $(this).val()==='hg19' ) {
      $('select[name="to-refversion"]').find('option[value="hg38"]').prop('selected', true);
    } else if ( $(this).val()==='hg38' ) {
      $('select[name="to-refversion"]').find('option[value="hg19"]').prop('selected', true);
    } 
  });

});

</script>



<!-- Handle POST -->
<div class="container">
  
<?php
//echo 'Request Method: '.$_SERVER['REQUEST_METHOD'].'<br>';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  include 'liftover.php';
}
?>

</div>


</body>
</html>