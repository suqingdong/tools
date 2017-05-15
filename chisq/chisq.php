<?php

// add a date prefix
date_default_timezone_set('Asia/Shanghai');
$now = date('YmdHis');

$filename = $_FILES['file']['name'];
$filepath = 'upload/temp';

if ( $filename ) {
	if ( $_FILES['file']['size'] < 1024*2 ) {
		move_uploaded_file( $_FILES['file']['tmp_name'], $filepath);
	} else {
		showError('Filesize is too big (request less than 2kb)');
	}
} else {
	showError('Need a file');
}


$cmd = sprintf('Rscript code/chisq.R %s', $filepath);

// Run system command
if ( empty($error) ) {
	exec($cmd, $res);
	printf('<p class="alert alert-success text-center">检验结果如下</p>');
	if ( count($res)==2 ) {
		printf('<p class="text-info text-center">检验方法：%s</p>', $res[0]);
		printf('<p class="text-primary text-center">P值：%s</p>', $res[1]);
	} else {
		printf('<p class="text-danger text-center">Opps! 请检查输入文件格式</p>');
	}
}


// Handle error message
function showError($error){
  echo '<script>';
  echo '$("#error").addClass("alert alert-danger text-center");';
  printf("$('#error').html('%s<strong>Error:</strong> %s !');", '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', $error);
  echo '</script>';
  exit();
}

