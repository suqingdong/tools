<html>
<head>
<meta charset="utf-8">
<title>Volcano</title>
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
  <h1>根据输入表格，绘制火山图</h1>
  <div class="row">
    <div class="col-md-6">

      <div id="error"></div>  
        
      <form class="form" action="" method="post" enctype="multipart/form-data" >

        <a class="btn btn-warning">必选参数</a><br><br>
        <div id="required">
          <div class="input-group">
            <span class="input-group-addon">输入文件</span>
            <input type="file" class="form-control" name="file">
          </div> 
          <br>

          <div class="input-group">
            <span class="input-group-addon">以第几列为X</span>
            <input type="text" class="form-control" name="xindex" />
          </div>
          <br>

          <div class="input-group">
            <span class="input-group-addon">以第几列为Y</span>
            <input type="text" class="form-control" name="yindex" />
          </div>
          <br>

        </div>

        <a class="btn btn-info" onclick="$('#optional').fadeToggle(500)">可选参数</a><br><br>
        <div id="optional" hidden>

          <div class="input-group">
            <span class="input-group-addon">X阈值</span>
            <select class="form-control" onchange="setValue('xthread')">
              <option value="2">2</option>
              <option value="4">4</option>
              <input type="hidden" name="xthread" value="2" />
            </select>
          </div>
          <br>

          <div class="input-group">
            <span class="input-group-addon">Y阈值</span>
            <select class="form-control" onchange="setValue('ythread')">
              <option value="0.05">0.05</option>
              <option value="0.01">0.01</option>
              <input type="hidden" name="ythread" value="0.01" />
            </select>
          </div>
          <br>

          <div class="input-group">
            <span class="input-group-addon">X轴最大值</span>
            <input type="text" class="form-control" name="xmax" />
          </div>
          <br>
          
          <div class="input-group">
            <span class="input-group-addon">Y轴最大值</span>
            <input type="text" class="form-control" name="ymax" />
          </div>
          <br>

          <div class="input-group">
            <span class="input-group-addon">图片标题</span>
            <input type="text" class="form-control" name="title" />
          </div>
          <br>

          <div class="input-group">
            <span class="input-group-addon">图片高度</span>
            <input type="text" class="form-control" name="height" />
          </div>
          <br>

          <div class="input-group">
            <span class="input-group-addon">图片宽度</span>
            <input type="text" class="form-control" name="width" />
          </div>          
          <br>

          <div class="input-group">
            <span class="input-group-addon">图片颜色</span>
            <input type="text" class="form-control" name="color" />
          </div>          
          <br>

        </div>


        <button type="submit" class="btn btn-success" style="width:100%;margin-left:0%;">开始绘制</button>
        
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
            <h3>说明</h3>
          <p>输入文件: 表格文件</p>
          <p>输出文件: 图像文件</p>
          </div>
          <div role="tabpanel" class="tab-pane" id="shili">
            <p><a href="code/test.txt" target="_blank">输入文件(可右键另存为)</a></p>
            <img src="code/test.txt.png" width="100%">
            <p><a href="#" >输出结果</a></p>
            <img src="code/test.png" width="100%">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="../static/js/jquery.min.js"></script>
<script src="../static/js/bootstrap.min.js"></script>

<script>
  
function setValue(name) {
  var element = $('input[name="'+name+'"]');
  var value = element.parent().find('option:selected').val();
  element.val(value);
  console.log(element.val());
}

</script>



<!-- Handle POST -->
<div class="container">
  
<?php
//echo 'Request Method: '.$_SERVER['REQUEST_METHOD'].'<br>';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  include 'volcano.php';
}
?>

</div>


</body>
</html>