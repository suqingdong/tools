<!DOCTYPE html>
<html>
<head>
  <meta name="suqingdong" content="content" charset="UTF-8">
  <title>全部工具</title>
  <link rel="stylesheet" type="text/css" href="static/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="static/css/font-awesome.min.css">

  <style>
    .fa-ul {
      font-size: 20px;
      line-height: 1.5;
    }

    .fa-ul a {
      text-decoration: none;
    }

    .fa-ul a:hover {
      color: red;
    }

  </style>

</head>
<body>

<div class="container">

  <h1>小工具列表</h1>
  <ul class="fa-ul">

  <?php 
  exec('ls -d * | grep -vE "static|README|index" ', $res);
  foreach ($res as $k => $v) {
    printf('<li><a href="%s" target="_blank"><i class="fa-li fa fa-spinner fa-spin"></i> %s</a></li>', $v, $v);
  }
  ?>

  </ul>

</div>


</body>
</html>