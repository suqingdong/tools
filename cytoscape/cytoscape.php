<?php

// add a date prefix
date_default_timezone_set('Asia/Shanghai');
$now = date('YmdHis');

$filename = $_FILES['file']['name'];
// $filepath = sprintf('upload/%s.%s', $now, $filename);
$filepath = 'upload/temp';
$outpath = 'upload/temp.json';

if ( $filename ) {
  if ( $_FILES['file']['size'] < 1024*10 ) {
    move_uploaded_file( $_FILES['file']['tmp_name'], $filepath);
  } else {
    showError('Filesize is too big (request less than 10kb)');
  }
} else {
  showError('Need a file');
}

$cmd = sprintf('python code/txt2json.py %s %s', $filepath, $outpath);

// echo $cmd;
// exit();

// Run system command
if ( empty($error) ) {
  exec($cmd, $res);

  if ($res[0]) {
    printf('<p class="alert alert-danger text-center">Opps! 出现错误，请检查输入文件格式。</p>');
    exit();
  }

  printf('<p class="alert alert-success text-center">网络图绘制完成</p>');
  printf('<div id="cy"></div>');
}


// Handle error message
function showError($error){
  echo '<script>';
  echo '$("#error").addClass("alert alert-danger text-center");';
  printf("$('#error').html('%s<strong>Error:</strong> %s !');", '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', $error);
  echo '</script>';
  exit();
}


?>

<script>

var elements;

var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {
  if (xmlhttp.readyState===4 && xmlhttp.status===200) {
    elements = JSON.parse(xmlhttp.responseText);
  }
};

xmlhttp.open('POST', '<?php echo $outpath;?>', false);

xmlhttp.send();



var cy = cytoscape({
  container: $('#cy'),
  elements: elements,
  style: [
    {
      selector: 'node',
      style: {
        'background-color': 'yellow',
        'label': 'data(id)',
      }
    },
    {
      selector: 'node[type="source"]',
      style: {
        'background-color': 'red',
        'label': 'data(id)',
      }
    },
    {
      selector: 'edge',
      style: {
        'width': 1,
        'line-color': '#ccc',
        'target-arrow-color': '#ccc',
        'target-arrow-shape': 'triangle'
      }
    }
  ],
  layout: {
    name: 'random',
  },
  boxSelectionEnabled: true
});

</script>

<div class="text-center">
  <a class="btn btn-info" onclick="cy.elements().layout({'name':'random'}).run()">刷新图像</a>
  <a href="" class="btn btn-success" target="_blank" onclick="$(this).attr('href', cy.png())">保存PNG</a>
  <a href="" class="btn btn-danger" target="_blank" onclick="$(this).attr('href', cy.jpg())">保存JPG</a> 
  <a class="btn btn-warning" onclick="cy.fit()">Fit</a>
  <a class="btn btn-primary" onclick="cy.center()">Center</a>
</div>