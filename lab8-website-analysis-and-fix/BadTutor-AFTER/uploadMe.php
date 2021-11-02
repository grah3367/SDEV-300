
<?php
// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
// of $_FILES.


$uploaddir = 'temp/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
$fileType = $_FILES['userfile']['type'];
$fileSize = $_FILES['userfile']['size'];
$maxsize = 3000000;
$acceptedTypes = array( 
						'pdf' => 'application/pdf',
						'msword' => 'application/msword',
						'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
						);
$e = array();

//$finfo = finfo_open(FILEINFO_MIME_TYPE);
$finfo = new finfo(FILEINFO_MIME_TYPE);
//$mime = finfo_file($finfo, $_FILES['userfile']['tmp_name']);
//$fileMIME = mime_content_type($_FILES['userfile']['tmp_name']);

$ext = array_search(
        $finfo->file($_FILES['userfile']['tmp_name']),
		$acceptedTypes,
		true		
		);
		
if(!$ext){
	echo "invalid file format, please go back and try again <a href=\"UploadResume.html\">Back to file upload</a>";
	 throw new RuntimeException('Invalid file format.');
}

if($fileSize > $maxsize){
	echo "Exceeded filesize limit. please go back and try again <a href=\"UploadResume.html\">Back to file upload</a>";
	throw new RuntimeException('Exceeded filesize limit.');
}

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "Your resume was successfully uploaded.\n  <a href=\"UploadResume.html\">Back to file upload</a> | <a href=\"index.html\">Homepage</a>";
} else {
    echo "Possible file upload attack!\n";
}

//echo 'Here is some more debugging info:';
//print_r($_FILES);




?>
