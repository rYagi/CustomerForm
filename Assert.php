<?php

class Assert {

  function assertPOST(string $key){
    if (isset($_POST[$key])) {
      return $_POST[$key];
    } else {
      throw new Exception400();
    }
  }

}