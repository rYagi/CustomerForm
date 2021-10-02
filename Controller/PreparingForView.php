<?php
require_once 'Assert.php';
require_once 'Controller/Validate.php';

/**
 * HTML表示をするために中間処理をするクラス
 * Viewではなく、Viewに情報を渡す前に中間処理をする
 */
class PreparingForView {
  const REGIST_SUCCESS = '下記内容の送信に成功しました';
  const REGIST_FAIL = '下記内容の送信に失敗しました';

  /**
   * HTMLを出力する
   */
  static private function render(string $_file, array $_args) : string {
    extract($_args);
    ob_start();
    ob_implicit_flush(0);

    require_once 'View/ViewUtility.php';  // Viewのための汎用関数を読み込み
    require_once 'Utility.php';           // 汎用関数を読み込み
    require_once $_file;
    return ob_get_clean();
  }

  /**
   * POSTされた項目の存在をチェックして取得
   */
  static private function getPostItems() : array {
    $assert = new Assert();
    $subject       = $assert->assertPOST('subject');
    $customerName = $assert->assertPOST('customerName');
    $mail          = $assert->assertPOST('mail');
    $phoneNumber  = $assert->assertPOST('phoneNumber');
    $inquiry       = $assert->assertPOST('inquiry');
    return compact('subject', 'customerName', 'mail', 'phoneNumber', 'inquiry');
  }

  /**
   * formを表示する（GET）
   */
  static public function form() : Response {
    $items = [];
    $content = self::render('View/Form.php', compact('items'));
    return Response::ok($content);
  }

  /**
   * formに項目をPOST送信
   */
  static public function postForm() : Response {
    $postItems = self::getPostItems();
    extract($postItems);

    // フォームページ→確認ページ　の際にヴァリデーションしているので、確認ページ→フォームページではヴァリデーションはしない
    $content = self::render('View/Form.php', compact('subject', 'customerName', 'mail', 'phoneNumber', 'inquiry'));
    return Response::ok($content);
  }

  /**
   * confirmに項目をPOST送信
   */
  static public function postConfirm() : Response {
    $postItems = self::getPostItems();
    extract($postItems);

    $validate = new Validate();
    $errors = $validate->validateInputted($subject, $customerName, $mail, $phoneNumber, $inquiry);

    if (empty($errors)){
      $content = self::render('View/Confirm.php', compact('subject', 'customerName', 'mail', 'phoneNumber', 'inquiry'));
      return Response::ok($content);
    } else{
      $content = self::render('View/Form.php', compact('errors', 'subject', 'customerName', 'mail', 'phoneNumber', 'inquiry'));
      return Response::badRequest($content);
    }
  }

  /**
   * completeに項目をPOST送信
   * メールを管理者と問い合わせ者に送信する
   */
  static public function postComplete() : Response {
    $postItems = self::getPostItems();
    extract($postItems);

    // フォームページ→確認ページ　の際にヴァリデーションしているので、確認ページ→完了ページではヴァリデーションはしない

    $utility = new Utility();
    
    mb_language('Japanese');
    mb_internal_encoding('UTF-8');
    $toAdmin = 'admin@admin.jp'; // 適宜変更してください
    $title    = 'お問い合わせフォーム';
    $message  = '弊社のお問い合わせフォームにて下記内容をご入力いただきました' . "\r\n\r\n" 
    . '件名：'. $utility->changeSubjectFromEnToJa($subject) . "\r\n" 
    . 'お名前：'. $customerName . "\r\n" 
    . 'メールアドレス：'. $mail . "\r\n" 
    . '電話番号：'. $phoneNumber . "\r\n" 
    . 'お問い合わせ内容：'. $inquiry;
    $header   = 'From:test_form@examle.com';

    // 管理者へメール送信
    $bAdmin = mb_send_mail($toAdmin, $title, $message, $header );

    // 問い合わせ者へメール送信
    $bCustomer = mb_send_mail($mail, $title, $message, $header );

    $mailMessage = ($bAdmin && $bCustomer) ? self::REGIST_SUCCESS : self::REGIST_FAIL;

    $content = self::render('View/Complete.php', compact('subject', 'customerName', 'mail', 'phoneNumber', 'inquiry', 'mailMessage'));
    return Response::ok($content);
  }

}
