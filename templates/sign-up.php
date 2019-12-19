<pre><?php var_dump($errors_sign_up); ?></pre>
<pre><?php var_dump($_POST); ?></pre>
<form class="form container<?php if (count($errors_sign_up) > 0): ?> form--invalid<?php endif; ?>"
      action="sign-up.php" method="post" autocomplete="off">
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item<?php if (isset($errors_sign_up['email'])): ?> form__item--invalid<?php endif; ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=getPostVal('email'); ?>">
        <span class="form__error"><?= $errors_sign_up['email']; ?></span>
    </div>
    <div class="form__item<?php if (isset($errors_sign_up['password'])): ?> form__item--invalid<?php endif; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?=getPostVal('password'); ?>">
        <span class="form__error"><?= $errors_sign_up['password']; ?></span>
    </div>
    <div class="form__item<?php if (isset($errors_sign_up['name'])): ?> form__item--invalid<?php endif; ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=getPostVal('name'); ?>">
        <span class="form__error"><?= $errors_sign_up['name']; ?></span>
    </div>
    <div class="form__item<?php if (isset($errors_sign_up['message'])): ?> form__item--invalid<?php endif; ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?=getPostVal('message'); ?></textarea>
        <span class="form__error"><?= $errors_sign_up['message']; ?></span>
    </div>
    <?php if (count($errors_sign_up) > 0): ?>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <?php endif; ?>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="login.php">Уже есть аккаунт</a>
</form>
