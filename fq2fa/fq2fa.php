<?php

// add a date prefix
date_default_timezone_set('Asia/Shanghai');
$now = date('YmdHis');

$filename = $_FILES['file']['name'];
$filepath = sprintf('upload/%s.%s', $now, $filename);

if ( $filename ) {
	if ( $_FILES['file']['size'] < 1024*1024*5 ) {
		move_uploaded_file( $_FILES['file']['tmp_name'], $filepath);
	} else {
		showError('Filesize is too big (request less than 5M)');
	}
} else {
	showError('Need a file');
}

$yasuo = $_POST['yasuo'];

// replace extension to png
$temp = explode('.', $filepath);
$temp[count($temp)-1] = 'fa';
$outpath = implode('.', $temp);

$cmd = sprintf('sh code/fq2fa.sh %s %s', $filepath, $outpath);

if($yasuo=='true') {
	$outpath .= '.gz';
	$cmd = sprintf('sh code/fq2fa.sh %s %s -z', $filepath, $outpath);
}

// echo $cmd;
// exit();


// Run system command
if ( empty($error) ) {
	exec($cmd);       //no return value
	printf('<p class="alert alert-success text-center">数据格式转换完成</p>');
	printf('<a href="%s" target="_blank" class="btn btn-default">下载结果</a>', $outpath);
}


// Handle error message
function showError($error){
  echo '<script>';
  echo '$("#error").addClass("alert alert-danger text-center");';
  printf("$('#error').html('%s<strong>Error:</strong> %s !');", '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', $error);
  echo '</script>';
  exit();
}

