<?php
require dirname(__FILE__) . "/3rd_party/aws-sdk-php/sdk.class.php";
require dirname(__FILE__) . "/config.php";

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
    $options['key'] = AWS_KEY;
    $options['secret'] = AWS_SECERT;
    
    $s3 = new AmazonS3($options);
    $exists = $s3->if_bucket_exists(AWS_S3_BUCKET);
    $isUploadS3 = false;
    if ($exists) {
        $s3->create_object(AWS_S3_BUCKET, "images/".$targetFileName, array('fileUpload' => $filePath, "acl" => AmazonS3::ACL_PUBLIC));
        $file_upload_response = $s3->batch()->send();
        if ($file_upload_response->areOK()) {
            $isUploadS3 = true;
        }
    }else{
        echo "the bucket is not exist !!";
    }
    return $isUploadS3;
}


function response($targetFileName){
    $s3URL = 'https://'.AWS_S3_DOMAIN.'/images/'.$targetFileName;
    $cloudfrontURL = 'https://'.AWS_CLOUDFRONT_DOMAIN.'/images/'.$targetFileName;

    //show s3
    echo '<br>s3 url : ' . $s3URL;
    echo '<br>cloudfront url : ' . $cloudfrontURL;
    echo '<hr>';
    echo '<br><a href="'.$cloudfrontURL.'" target="_blank"><img src="'.$cloudfrontURL.'" width="500px" height="500px"></a>';
    echo '<br><br><input onclick="javascript:location.href=\'/\'" type="button" value="Back">';

}


?>