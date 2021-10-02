<?php ob_start(); ob_implicit_flush(0); ?>

<?php echo $mailMessage ?><br>

<form action="/complete" method="post">
  <ul>
    <li>
      <label>
        件名：<?php
        $utility = new Utility();
        safeEcho($utility->changeSubjectFromEnToJa($subject)); 
        ?>
      </label>
    </li>
    <li>
      <label>
        名前：<?php safeEcho($customerName) ?>
      </label>
    </li>
    <li>
      <label>
        メールアドレス：<?php safeEcho($mail) ?>
      </label>
    </li>
    <li>
      <label>
        電話番号：<?php safeEcho($phoneNumber) ?>
      </label>
    </li>
    <li>
      <label>
        お問い合わせ内容：<?php safeEcho($inquiry) ?>
      </label>
    </li>
  </ul>
</form>

<a href="/">フォームページへ戻る</a>

<?php 
$title = '送信完了ページ';
$body = ob_get_clean();
require 'View/Layout.php';
?>