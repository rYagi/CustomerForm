<?php ob_start(); ob_implicit_flush(0); ?>

<?php if(empty($errors) === false) { ?>
<ul>
<?php foreach ($errors as $error) { ?>
  <li>
    <?php safeEcho($error) ?>
  </li>
<?php } ?>
</ul>
<?php } ?>

<form action="/confirm" method="post">
  <ul>
    <li>
      <label>
        件名
        <select name="subject">
          <option value="opinion" 
          <?php if(isset($subject)){
                  if($subject === 'opinion'){
                    echo 'selected';
                  }
                }  ?>
           >ご意見</option>
          <option value="impressions" 
          <?php if(isset($subject)){
                  if($subject === 'impressions'){
                    echo 'selected';
                  }
                }  ?>
          >ご感想</option>
          <option value="others" 
          <?php if(isset($subject)){
                  if($subject === 'others'){
                    echo 'selected';
                  }
                }  ?>
          >その他</option>
        </select>
      </label>
    </li>
    <li>
      <label>
        名前
        <input type="text" name="customerName" value="<?php safeEcho($customerName) ?>">
      </label>
    </li>
    <li>
      <label>
        メールアドレス
        <input type="text" name="mail" value="<?php safeEcho($mail) ?>">
      </label>
    </li>
    <li>
      <label>
        電話番号
        <input type="text" name="phoneNumber" value="<?php safeEcho($phoneNumber) ?>">
      </label>
    </li>
    <li>
      <label>
        お問い合わせ内容<br>
        <textarea name="inquiry" rows="5"><?php safeEcho($inquiry) ?></textarea>
      </label>
    </li>
  </ul>
  <button type="submit">送信</button>
</form>

<?php
$title = 'フォーム入力';
$body = ob_get_clean();
require 'View/Layout.php';
?>