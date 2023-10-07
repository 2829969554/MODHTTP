<?php
header('Access-Control-Allow-Origin: *');
//var_dump($_SERVER);
function is_https() {
    if ( !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        return true;
    } elseif ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
        return true;
    } elseif ( !empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
        return true;
    }
    return false;
}

if($_SERVER['REQUEST_METHOD'] == 'POST' ){

  if ($_FILES["file"]["error"] > 0){
    echo "error:".$_FILES["file"]["error"];

    }else{
    $name=$_FILES['file']['name'];
    $type=$_FILES['file']['type'];
    $file=$_FILES['file']['tmp_name'];
    $size=$_FILES['file']['size'];


 //print_r($_FILES);   	
    }
	$fh = fopen($file, "rb");
	$head = fread($fh, $size);
	fclose($fh);

$myfile = fopen('file/'.sha1($file).$name, "w+") or die("Unable to open file!");
fwrite($myfile, $head);
fclose($myfile);

if(is_https()){
echo 'https://'.$_SERVER['HTTP_HOST'].'/pg/file/'.sha1($file).$name;  
}else{
echo 'http://'.$_SERVER['HTTP_HOST'].'/pg/file/'.sha1($file).$name;       
}
}else{
    echo "
<h1>文件上传保存到数据库</h1>
<h2>上传文件得到外部连接</h2>
  上传文件最大限制:".ini_get('upload_max_filesize');
    echo '
    <br/>
    <form active="" method="post" enctype="multipart/form-data">
<input type="file" name="file"></input>
<input type="submit" name="submit" value="Submit" />
</form>
    ';  

}
?>