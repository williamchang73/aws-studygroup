<?php
require dirname(__FILE__) . "/3rd_party/aws-sdk-php/sdk.class.php";
require dirname(__FILE__) . "/config.php";
require dirname(__FILE__) . "/db_image.php";

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
        echo "Invalid file";
    } else {
        echo "Upload: " . $_FILES["file"]["name"] . "<br>";
        echo "Type: " . $_FILES["file"]["type"] . "<br>";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
        $targetFolder   = dirname(__FILE__) . "/img/";
        $targetFileName = time() . ".jpg";

        //create image hash
        $hashcode = hash_file('md5', $_FILES["file"]["tmp_name"]);
        $url = getImageURLByHashcode($hashcode);
        if($url){
            echo '<br><font color="red">from database</font><br>';
            //just return
            response($url);
        }else{ //need to upload to s3
            echo '<br><font color="red">upload to S3</font><br>';
            $isUploadS3 = uploadToS3($targetFileName, $_FILES["file"]["tmp_name"]);
            if($isUploadS3){
                saveImage($hashcode, getCloudFrontURL($targetFileName));
                response($targetFileName);
            }else{
                echo 'upload to s3 failed';
            }
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


function getCloudFrontURL($targetFileName){
    return 'https://'.AWS_CLOUDFRONT_DOMAIN.'/images/'.$targetFileName;
}

function response($targetFileName){
    //already exist in db
    if(strpos($targetFileName, 'https')===0){ 
        $returnURL = $targetFileName;
    }else{
        $returnURL = getCloudFrontURL($targetFileName);
        $s3URL = 'https://'.AWS_S3_DOMAIN.'/images/'.$targetFileName;
        echo '<br>s3 url : ' . $s3URL;
    }

    echo '<br>return url : ' . $returnURL;
    echo '<hr>';
    echo '<br><a href="'.$returnURL.'" target="_blank"><img src="'.$returnURL.'" width="500px" height="500px"></a>';
    echo '<br><br><input onclick="javascript:location.href=\'/index.htm\'" type="button" value="Back">';

}


?>