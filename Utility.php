<?php

class Utility {

  public $messages = [];

  public function isTrue(bool $condition, string $message) : void {
    if($condition === false){
      array_push($this->messages, $message);
    }
  }

  public function changeSubjectFromEnToJa(string $subject) : string {
    switch($subject){
      case 'opinion':
        return 'ご意見';
      case 'impressions':
        return 'ご感想';
      case 'others':
        return 'その他';
    }
    throw new Exception400();
  }

}
