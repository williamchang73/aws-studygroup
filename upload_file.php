<?php
echo "<h1>upload result : </h1>";
$allowedExts = array("gif", "jpeg", "jpg", "png");
$extension = end(explode(".", $_FILES["file"]["name"]));
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
    $targetFolder = "/home/ubuntu/workspace/studygroup/img/";
    $targetFileName = time().".jpg";
      move_uploaded_file($_FILES["file"]["tmp_name"],
      $targetFolder . $targetFileName);
      echo "Stored in: " .$targetFolder . $targetFileName . "<br>";
    }
  }
else
  {
  echo "Invalid file";
  }
echo '<br><a href="/img/'.$targetFileName.'" target="_blank"><img src="/img/'.$targetFileName.'" width="500px" height="500px"></a>';
echo '<br><br><input onclick="javascript:location.href=\'/\'" type="button" value="Back">';
?>
