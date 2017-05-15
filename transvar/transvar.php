<?php

// ===============Get arguments======================
$refversion = $_POST['refversion'];
$searchType = $_POST['search-type'];


$searchArray = array(
  'protein' => 'panno', 
  'gdna' => 'ganno', 
  'cdna' => 'canno', 
  'codon' => 'codonsearch',
  );

$cmd = 'export PYTHONPATH=/usr/local/software/transvar/lib/python2.7/site-packages && ';
$cmd .= sprintf(' transvar %s', $searchArray[$searchType]);

$cmd .= sprintf(' --refversion %s', $refversion);

// get checkbox values(array)
if( isset($_POST['database']) ) {
  $database = $_POST['database'];
  foreach( $database as $k => $v ) {
    $cmd .= sprintf(' --%s', $v);
  }
} else {
  $error = 'No database selected';
  showError($error);
}


// ===========================File Upload==============================
$filename = $_FILES['search-file']['name'];
$searchString = $_POST['search-string'];
$tempfile = 'upload/temp';

if( $filename ) {
 if( $_FILES['search-file']['size'] < 1024*2 ) {
    move_uploaded_file( $_FILES['search-file']["tmp_name"], $tempfile );
  } else {
    $error = 'Filesize is too big(request less than 2kb)';
    showError($error);
  }
} else if ( $searchString ) {  
  // search with string(save search list to a temp file)
  $temp = sprintf('echo "%s" > %s', $searchString, $tempfile);
  system($temp);
} else {
  $error = 'Need a string or a file';
  showError($error);
}
$cmd .= sprintf(' -l %s -m 1 -o 1', $tempfile);



// Show Input
exec('cat upload/temp', $input);
$yourInput = implode(', ', $input);
$yourDatabase = implode(', ', $database);

echo '<div class="panel panel-success">';
echo '<div class="panel-heading">Your Input</div>';
echo '<div class="panel-body">';
printf('<p>Search Item: %s<p>', $yourInput);
printf('<p>Use Database: %s<p>', $yourDatabase);
echo '</div>';
echo '</div>';


// echo $cmd;
if(empty($error)) {

  echo '<div class="panel panel-info">';
  echo '<div class="panel-heading">Search Result</div>';

  exec($cmd, $res);

  if (count($res)==1){
    echo '<h4 class="text-center text-danger">Opps! no result found, check your input and try again.</h4>';
  } else {    
    echo '<table class="table table-hover table-bordered table-striped" id="result" cellspacing="0" width="100%">';
    foreach ($res as $k => $v) {
      $linelist = explode("\t", $v);
      if($k==0) {
        echo '<thead><tr class="text-info">';
        foreach ($linelist as $k1 => $v1) {
          echo '<th>'.ucwords($v1).'</th>';   //uwwords: upper the first letter of a word
        }
        echo '</tr></thead>';
        echo '<tbody>';
      } else {
        echo '<tr>';
        foreach ($linelist as $k2 => $v2) {
          echo '<td>'.$v2.'</td>';
        }
        echo '</tr>';
      }
    }
    echo '</tbody>';
    echo '</table>';
  } 

  echo '</div>';
  echo '</div>';


  echo '<script>';
  echo 'var dt = $("#result").dataTable({"scrollY":"250px", "scrollX":"true", "processing":true});';
  echo '</script>';



}


function showError($error){
  echo '<script>';
  echo '$("#error").addClass("alert alert-danger text-center");';
  printf("$('#error').html('%s<strong>Error:</strong> %s !');", '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', $error);
  echo '</script>';
  exit();
}

// function showError($error){
//   echo '<script>';
//   echo 'var error = document.getElementById("error");';
//   echo 'error.classList = "alert alert-danger text-center";';
//   echo 'error.innerHTML = "Error: '.$error.' !";';
//   echo '</script>';
//   exit();
// }

?>
