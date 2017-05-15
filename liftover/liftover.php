<?php

// ===============Get arguments======================
$refChain = array(
  'hg19'.'hg38' => 'bin/hg19ToHg38.over.chain',
  'hg38'.'hg19' => 'bin/hg38ToHg19.over.chain'
  );


$species = $_POST['species'];

$from_refversion = $_POST['from-refversion'];
$to_refversion = $_POST['to-refversion'];

$bedfile = $_FILES['bedfile']['name'];
$bedstring = $_POST['bedstring'];

$tempfile = 'upload/input.bed';
$outpath = 'upload/output.bed';
$unmap = 'upload/unmap';


if( $bedfile ) {
 if( $_FILES['bedfile']['size'] < 1024*2 ) {
    move_uploaded_file( $_FILES['bedfile']["tmp_name"], $tempfile );
  } else {
    $error = 'Filesize is too big(request less than 2kb)';
    showError($error);
  }
} else if ( $bedstring ) {
  $temp =preg_split('/[,;:-]|(\s)+/', $bedstring);
  $temp = sprintf('echo "%s" > %s', implode("\t", $temp), $tempfile);
  exec($temp);
} else {
  $error = 'Need a bed string or a bed file';
  showError($error);
}

$cmd = sprintf('./bin/liftOver %s %s %s %s', $tempfile, $refChain[$from_refversion.$to_refversion], $outpath, $unmap);

// echo $cmd;
// exit();


// Show Input
exec('cat upload/input.bed', $input);

printf('<div class="panel panel-success">');
printf('<div class="panel-heading">Your Input</div>');
printf('<div class="panel-body">');
printf('<p>Spieces: %s<p>', $species);
printf('<p>Reference Change: %s => %s<p>', $from_refversion, $to_refversion);
printf('<p>Input bed region:<p><pre>');
foreach($input as $k => $v) {
  printf('%s<br>', $v);
}
printf('</pre>');
printf('</div>');
printf('</div>');


// echo $cmd;
if(empty($error)) {

  exec($cmd);

  echo '<div class="panel panel-info">';
  printf('<div class="panel-heading">Result<a href="%s" target="_blank" class="btn btn-info" style="margin-left:10px;">下载结果</a></div>', $outpath);
  echo '<div class="panel-body">';
  
  $cmd = sprintf('cat %s', $outpath);
  exec($cmd, $res);

  printf('<pre>');
  foreach ($res as $k => $v) {
    echo $v."<br >";
  }
  printf('</pre>');

  echo '</div>';
  echo '</div>';
  echo '</div>';
}


function showError($error){
  echo '<script>';
  echo '$("#error").addClass("alert alert-danger text-center");';
  printf("$('#error').html('%s<strong>Error:</strong> %s !');", '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', $error);
  echo '</script>';
  exit();
}

?>
