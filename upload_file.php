<?php
require dirname(__FILE__) . "/3rd_party/aws-sdk-php/sdk.class.php";

echo "<h1>upload result : </h1>";
$allowedExts = array(
    "gif",
    "jpeg",
    "jpg",
    "png"
);
$extension   = end(explode(".", $_FILES["file"]["name"]));
if (in_array($extension, $allowedExts)) {
    if ($_FILES["file"]["error"] > 0) {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    } else {
        echo "Upload: " . $_FILES["file"]["name"] . "<br>";
        echo "Type: " . $_FILES["file"]["type"] . "<br>";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
        $targetFolder   = dirname(__FILE__) . "/img/";
        $targetFileName = time() . ".jpg";
        $isUploadS3 = uploadToS3($targetFileName, $_FILES["file"]["tmp_name"]);
        if($isUploadS3){
            response($targetFileName);
        }else{
            echo 'upload to s3 failed';
        }

    }
} else {
    echo "Invalid file";
}



//save to AWS S3
function uploadToS3($targetFileName, $filePath)
{
    $options = array();
    $options['key'] = '';
    $options['secret'] = ''; 
    
    $s3 = new AmazonS3($options);
    $bucket = "aws-study-group";
    $exists = $s3->if_bucket_exists($bucket);
    $isUploadS3 = false;
    if ($exists) {
        $s3->create_object($bucket, "images/".$targetFileName, array('fileUpload' => $filePath, "acl" => AmazonS3::ACL_PUBLIC));
        $file_upload_response = $s3->batch()->send();
        if ($file_upload_response->areOK()) {
            $isUploadS3 = true;
        }
    }
    return $isUploadS3;
}


function response($targetFileName){
    $s3Domain = "aws-study-group.s3-ap-southeast-1.amazonaws.com";
    $cloudfrontDomain = "d1qjbwzye6rcb4.cloudfront.net";

    $s3URL = 'https://'.$s3Domain.'/images/'.$targetFileName;
    $cloudfrontURL = 'https://'.$cloudfrontDomain.'/images/'.$targetFileName;

    //show s3
    echo '<br>s3 url : ' . $s3URL;
    echo '<br>cloudfront url : ' . $cloudfrontURL;
    echo '<hr>';
    echo '<br><a href="'.$cloudfrontURL.'" target="_blank"><img src="'.$cloudfrontURL.'" width="500px" height="500px"></a>';
    echo '<br><br><input onclick="javascript:location.href=\'/\'" type="button" value="Back">';

}


?>