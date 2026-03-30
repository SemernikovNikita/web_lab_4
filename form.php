<html>
  <head>
    <style>
/* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
.error {
  border: 2px solid red;
}
    </style>
  </head>
  <body>

<?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>

    <form action="" method="POST">
      <input name="full_name" <?php if ($errors['full_name']) {print 'class="error"';} ?> value="<?php print $values['full_name']; ?>" />
      <input name="phone" <?php if ($errors['phone']) {print 'class="error"';} ?> value="<?php print $values['phone']; ?>" />
      <input name="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" />
      <input name="birth_date" <?php if ($errors['birth_date']) {print 'class="error"';} ?> value="<?php print $values['birth_date']; ?>" />
      <input name="gender" <?php if ($errors['gender']) {print 'class="error"';} ?> value="<?php print $values['gender']; ?>" />
      <input name="biography" <?php if ($errors['biography']) {print 'class="error"';} ?> value="<?php print $values['biography']; ?>" />
      <input name="agreement" <?php if ($errors['agreement']) {print 'class="error"';} ?> value="<?php print $values['agreement']; ?>" />
      <input name="languages" <?php if ($errors['languages']) {print 'class="error"';} ?> value="<?php print $values['languages']; ?>" />
      <input type="submit" value="ok" />
    </form>
  </body>
</html>
