<?php

// required args
$xindex = $_POST['xindex'];
$yindex = $_POST['yindex'];
if( empty($xindex) ) {
  showError('X Index is required');
}
if( empty($yindex) ) {
  showError('Y Index is required');
}

// add a date prefix to filename
date_default_timezone_set('Asia/Shanghai');
$now = date('YmdHis');

$filename = $_FILES['file']['name'];
$filepath = sprintf('upload/%s.%s', $now, $filename);

if ( $filename ) {
  if ( $_FILES['file']['size'] < 1024*1024*4 ) {
    move_uploaded_file( $_FILES['file']['tmp_name'], $filepath);
  } else {
    showError('Filesize is too big (request less than 4M)');
  }
} else {
  showError('Need a file');
}


// replace extension to png for outfile
$temp = explode('.', $filepath);
$temp[count($temp)-1] = 'png';
$outpath = implode('.', $temp);




$cmd = sprintf('Rscript code/volcano.R -i %s -o %s --xindex %s --yindex %s', $filepath, $outpath, $xindex, $yindex);


// optional args
$optionsArr = array(
    'xthread' => $_POST['xthread'],
    'ythread' => $_POST['ythread'],
    'xmax' => $_POST['xmax'],
    'ymax' => $_POST['ymax'],
    'title' => $_POST['title'],
    'color' => $_POST['color'],
    'height' => $_POST['height'],
    'width' => $_POST['width']
  );


foreach ($optionsArr as $k => $v) {
  if ( ! empty($v) ) {
    $cmd .= sprintf(' --%s "%s"', $k, $v);
  }
}

// echo $cmd;
// exit();



// Run system command
if ( empty($error) ) {
  exec($cmd);      

  printf('<p class="alert alert-success text-center">图像已绘制完毕</p>');
  printf('<a href="%s" target="_blank"><img src="%s" width="800px" class="img img-responsive"></a>', $outpath, $outpath);
}


// Handle error message
function showError($error){
  echo '<script>';
  echo '$("#error").addClass("alert alert-danger text-center");';
  printf("$('#error').html('%s<strong>Error:</strong> %s !');", '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', $error);
  echo '</script>';
  exit();
}

