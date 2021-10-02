<?php ob_start(); ob_implicit_flush(0); ?>

<form action="/complete" method="post">
  <ul>
    <li>
      <label>
        件名：<?php 
        $utility = new Utility();
        safeEcho($utility->changeSubjectFromEnToJa($subject)); 
        ?>
      </label>
      <input type="hidden" name="subject" value="<?php echo $subject ?>">
    </li>
    <li>
      <label>
        名前：<?php safeEcho($customerName) ?>
      </label>
      <input type="hidden" name="customerName" value="<?php echo $customerName ?>">
    </li>
    <li>
      <label>
        メールアドレス：<?php safeEcho($mail) ?>
      </label>
      <input type="hidden" name="mail" value="<?php echo $mail ?>">
    </li>
    <li>
      <label>
        電話番号：<?php safeEcho($phoneNumber) ?>
      </label>
      <input type="hidden" name="phoneNumber" value="<?php echo $phoneNumber ?>">
    </li>
    <li>
      <label>
        お問い合わせ内容：<?php safeEcho($inquiry) ?>
      </label>
      <input type="hidden" name="inquiry" value="<?php echo $inquiry ?>">
    </li>
  </ul>
  <button type="submit">送信</button>
</form>

<form action=/ method="post">
<input type="hidden" name="subject" value="<?php echo $subject ?>">
<input type="hidden" name="customerName" value="<?php echo $customerName ?>">
<input type="hidden" name="mail" value="<?php echo $mail ?>">
<input type="hidden" name="phoneNumber" value="<?php echo $phoneNumber ?>">
<input type="hidden" name="inquiry" value="<?php echo $inquiry ?>">
<button type="submit">修正</button>
</form>

<?php 
$title = '確認ページ';
$body = ob_get_clean();
require 'View/Layout.php';
?>