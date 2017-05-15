<html>
<head>
<meta charset="utf-8">
<title>表格筛选</title>
<link rel="stylesheet" type="text/css" href="src/css/bootstrap.min.css" />
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
        <li><a href="http://211.159.153.95/home">主页</a></li>
        <li><a href="http://211.159.153.95/categories">生信大课堂</a></li>
        <li><a href="http://211.159.153.95/recent">最新</a></li>
        <li><a href="http://211.159.153.95/tags">话题</a></li>
        <li><a href="http://211.159.153.95/popular">热门</a></li>
        <li><a href="http://211.159.153.95/users">会员</a></li>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<div class="container">
	<h1>表格筛选</h1>
	<div class="row">
		<div class="col-md-6">
			<form class="navbar-form navbar-left" action="file_handle.php" method="post" enctype="multipart/form-data" >
				<div class="form-group">
				  <label>输入文件: </label>
				  <input type="file" class="form-control" name="file1" id="file1">
				</div>
				<br /><br />
				<div class="form-group">
				  <label>过滤文件: </label>
				  <input type="file" class="form-control" name="file2" id="file2">
				</div>
				<br /><br />				
				<div class="form-group">
				  <label >按第几列筛选: </label>
				  <input type="text" class="form-control" name="column" id="column">
				</div>
				<br /><br />

				<button type="submit" class="btn btn-success" id="submit">提交</button>
				<a class="btn btn-warning" id="clear">重置</a>
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
					<p>输入文件: 需要过滤的原始文件，以制表符(Tab)分隔</p>
					<p>过滤文件: 用于过滤的文件</p>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="shili">
			    	<p><a href="upload/screen.txt" target="_blank">输入文件(右键另存为)</a></p>
			    	<img src="src/images/screen.png">
			    	<p><a href="upload/screen2.txt" target="_blank">过滤文件(右键另存为)</a></p>
			    	<img src="src/images/screen2.png">
			    </div>
			  </div>
			</div>
		</div>
	</div>
</div>




<script src="src/js/jquery.min.js"></script>
<script src="src/js/bootstrap.min.js"></script>

<script>
	$(document).ready(function() {
		$('#clear').on('click', function (argument) {
			$('#file1').val('');
			$('#file2').val('');
		});
	});	
</script>

</body>
</html>