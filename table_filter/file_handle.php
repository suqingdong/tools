<?php

$upload = 'upload/';
$file1 = $upload.$_FILES['file1']['name'];
$file2 = $upload.$_FILES['file2']['name'];
$column = $_POST['column']['value'];

$file_list = array('file1', 'file2');
foreach ($file_list as $file) {
	$allowedExts = array("txt", "gff", "vcf");
	$temp = explode(".", $_FILES[$file]["name"]);	
	$extension = end($temp);     // 获取文件后缀名
	if ((($_FILES[$file]["type"] == "text/plain"))
	&& ($_FILES[$file]["size"] < 204800)   // 小于 200 kb
	&& in_array($extension, $allowedExts))
	{
		if ($_FILES[$file]["error"] > 0)
		{
			echo "错误：: ".$_FILES[$file]["error"]."<br>";
		}
		else
		{

			if (file_exists($upload.$_FILES[$file]["name"]))
			{
				echo "<p class='alert alert-warning'>".$_FILES[$file]["name"] . " 文件已经存在。 "."</p>";
			}
			else
			{
				move_uploaded_file($_FILES[$file]["tmp_name"], $upload.$_FILES[$file]["name"]);
				echo "文件存储在: ".$upload.$_FILES[$file]["name"]."<br />";
			}
		}
	}
	else
	{
		echo "非法的文件格式";
	}

}

$outfile = str_replace('.txt', '.filtered.xls', $file1);
$outjson = str_replace('.xls', '.json', $outfile);
$cmd = sprintf('python code/table_filter.py %s %s %s %s && ', $file1, $file2, $column, $outfile);
$cmd .= sprintf('python code/txt2json.py %s %s', $outfile, $outjson);

// echo $cmd;
system($cmd);

$url = sprintf('result.php?outfile=%s&&outjson=%s', $outfile, $outjson);
// header($url);   //can not have echo before

?>


<script>
	window.location.href='<?php echo $url?>';
</script>