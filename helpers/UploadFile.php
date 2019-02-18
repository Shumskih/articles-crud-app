<?php

class UploadFile
{
  public static function upload($imgDir, $data)
  {
    $name = null;

    @mkdir($imgDir, 0777);

    $tmp =$data['tmp_name'];

    if (is_uploaded_file($tmp)) {
      $info = @getimagesize($tmp);

      if (preg_match('{image/(.*)}is', $info['mime'], $p)) {
        $name = "$imgDir" . time() . "." . $p[1];
        move_uploaded_file($tmp, ROOT . '/' . $name);
      } else {
        echo "<h2>You are trying to upload unsupported file format!</h2>";
      }
    } else {
      echo "<h2>Download Error! #{$data['error']}!</h2>";
    }

    return $name;
  }
}