<?php
require_once 'Utility.php';

class Validate {

  const MSG_EMPTY_SUBJECT       = '件名を選択してください';
  const MSG_EMPTY_CUSTOMER_NAME = 'お名前を入力してください';
  const MSG_EMPTY_MAIL          = 'メールアドレスを入力してください';
  const MSG_INVALID_MAIL        = 'メールアドレスの形式を正しく入力してください';
  const MSG_EMPTY_PHONE_NUMBER  = '電話番号を入力してください';
  const MSG_NUMBER_PHONE_NUMBER = '電話番号は半角数字のみで入力してください';
  const MSG_EMPTY_INQUIRY       = 'お問い合わせ内容を入力してください';

  public function validateInputted(string $subject, string $customerName, string $mail, string $phoneNumber, string $inquiry) : array {

    $utility = new Utility();
    $utility->isTrue(empty($subject) === false, self::MSG_EMPTY_SUBJECT);
    
    $utility->isTrue(empty($customerName) === false, self::MSG_EMPTY_CUSTOMER_NAME);
    
    $utility->isTrue(empty($mail) === false, self::MSG_EMPTY_MAIL);
    if( empty($mail) === false ){
      $utility->isTrue(filter_var($mail, FILTER_VALIDATE_EMAIL), self::MSG_INVALID_MAIL);
    }

    $utility->isTrue(empty($phoneNumber) === false, self::MSG_EMPTY_PHONE_NUMBER);
    $utility->isTrue(preg_match('/^[0-9]*$/', $phoneNumber), self::MSG_NUMBER_PHONE_NUMBER);
    
    $utility->isTrue(empty($inquiry) === false, self::MSG_EMPTY_INQUIRY);

    return $utility->messages;
  }
  
}