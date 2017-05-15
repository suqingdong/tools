<html>
<head>
    <title>筛选结果DataTables</title>
    <link rel="stylesheet" type="text/css" href="src/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="src/css/jquery.dataTables.css">
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
    <p class="alert alert-success">文件筛选已完成，可点击查看或下载</p>
    <a onclick="loadData()" id='showResult' class="btn btn-warning">查看结果</a>
    <a class="btn btn-success" href="<?php echo $_GET['outfile']?>" target="_blank">下载结果</a>
    <hr />
    <table class="display" id="result" cellspacing="0" width="100%">
        <thead>
            <tr>
            </tr>
        </thead>
    </table>
</div>



<script src="src/js/jquery.min.js"></script>
<script src="src/js/bootstrap.min.js"></script>
<script src="src/js/jquery.dataTables.min.js"></script>

<script>
var loadData = function () {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if ( xmlhttp.readyState === 4 && xmlhttp.status === 200 ) {

            // Create thead DOM
            var json = JSON.parse(xmlhttp.responseText);
            for ( var i=0; i<json['header'].length; i++ ) {
                $('#result thead tr').append('<th>'+json['header'][i]+'</th>');
            };

            // AJAX load tbody
            $('#result').dataTable({
                "ajax": "<?php echo $_GET['outjson']?>",
                "scrollY": "500px",
                "scrollX": true,
                // "lengthMenu": [[5,10,50,-1],[5,10,50,'All']],
            });


            $('#showResult').attr('disabled', 'disabled');

        };
    };
    xmlhttp.open('GET', '<?php echo $_GET["outjson"]?>', true);
    xmlhttp.send();
};
</script>
    
</body>
</html>