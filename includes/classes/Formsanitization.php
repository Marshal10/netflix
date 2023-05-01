<?php
  class Formsanitization{

    public static function sanitizeFirstName($inputText){
        $inputText=strip_tags($inputText);
        $inputText=str_replace(" ","",$inputText);
        $inputText=strtolower($inputText);
        $inputText=ucfirst($inputText);

        return $inputText;
    }

    public static function sanitizeLastName($inputText){
      $inputText=strip_tags($inputText);
      $inputText=str_replace(" ","",$inputText);
      $inputText=strtolower($inputText);
      $inputText=ucfirst($inputText);

      return $inputText;
  }

  public static function sanitizeUserName($inputText){
    $inputText=strip_tags($inputText);
    $inputText=str_replace(" ","",$inputText);

    return $inputText;
}

public static function sanitizePassword($inputText){
  $inputText=strip_tags($inputText);

  return $inputText;
}

public static function sanitizeEmail($inputText){
  $inputText=strip_tags($inputText);
  $inputText=str_replace(" ","",$inputText);

  return $inputText;
}
  }
?>