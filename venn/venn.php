<?php

// add a date prefix
date_default_timezone_set('Asia/Shanghai');
$now = date('YmdHis');

$filename = $_FILES['file']['name'];
$filepath = sprintf('upload/%s.%s', $now, $filename);

if ( $filename ) {
	if ( $_FILES['file']['size'] < 1024*2 ) {
		move_uploaded_file( $_FILES['file']['tmp_name'], $filepath);
	} else {
		showError('Filesize is too big (request less than 2kb)');
	}
} else {
	showError('Need a file');
}


// replace extension to png
$temp = explode('.', $filepath);
$temp[count($temp)-1] = 'png';
$outpath = implode('.', $temp);

$cmd = sprintf('Rscript code/venn.R %s %s', $filepath, $outpath);

// Run system command
if ( empty($error) ) {
	exec($cmd);       //no return value
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

