<?php

// ===============Get arguments======================
$refArr = array(
  'hg19' => '/mnt/data/genome/human/hg19/human_g1k_v37_decoy.fasta',
  'hg38' => '/mnt/data/genome/human/hg38/hg38.fa'
  );

$refversion = $_POST['refversion'];

$bedfile = $_FILES['bedfile']['name'];
$bedstring = $_POST['bedstring'];

$tempfile = 'upload/temp.bed';
$outpath = 'upload/result.fa';


if( $bedfile ) {
 if( $_FILES['bedfile']['size'] < 1024*2 ) {
    move_uploaded_file( $_FILES['bedfile']["tmp_name"], $tempfile );
  } else {
    $error = 'Filesize is too big(request less than 2kb)';
    showError($error);
  }
} else if ( $bedstring ) {
  $temp =preg_split('/[,;:-]|(\s)+/', $bedstring);
  if( $refversion=='hg38' ) {
    $temp[0] = "chr".str_replace("chr", "", $temp[0]);
  }
  $temp = sprintf('echo "%s" > %s', implode("\t", $temp), $tempfile);
  exec($temp);
} else {
  $error = 'Need a bed string or a bed file';
  showError($error);
}

$cmd = sprintf('bedtools getfasta -fi %s -fo %s -bed %s', $refArr[$refversion], $outpath, $tempfile);

// echo $cmd;
// exit();


// Show Input
exec('cat upload/temp.bed', $input);
$yourInput = implode(', ', $input);

echo '<div class="panel panel-success">';
echo '<div class="panel-heading">Your Input</div>';
echo '<div class="panel-body">';
printf('<p>Bed Region: %s<p>', $yourInput);
printf('<p>Reference Genome Version: %s<p>', $refversion);
echo '</div>';
echo '</div>';


// echo $cmd;
if(empty($error)) {

  exec($cmd);

  echo '<div class="panel panel-info">';
  printf('<div class="panel-heading">Result<a href="%s" target="_blank" class="btn btn-info" style="margin-left:10px;">下载结果</a></div>', $outpath);
  echo '<div class="panel-body">';
  
  $cmd = sprintf('cat %s', $outpath);
  exec($cmd, $res);
  echo $res[0]."<br>";
  foreach (str_split($res[1], 100) as $k => $v) {
    echo $v."<br >";
  }

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
