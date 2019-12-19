<form class="form form--add-lot container<?php if (count($errors) > 0): ?> form--invalid<?php endif; ?>"
      action="add.php" method="post" enctype="multipart/form-data">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item<?php if (isset($errors['lot_name'])): ?> form__item--invalid<?php endif; ?>">
            <!-- form__item--invalid -->
            <label for="lot-name">Наименование <sup>*</sup></label>
            <input id="lot-name" type="text" name="lot_name" placeholder="Введите наименование лота" value="<?=getPostVal('lot_name'); ?>">
            <?php if (isset($errors['lot_name'])): ?>
                <span class="form__error"><?= $errors['lot_name']; ?></span>
            <?php endif; ?>
        </div>
        <div class="form__item<?php if (isset($errors['category_id'])): ?> form__item--invalid<?php endif; ?>">
            <label for="category">Категория <sup>*</sup></label>
            <select id="category" name="category_id">
                <option value="">Выберите категорию</option>
                <?php foreach ($categories as $value): ?>
                    <option value="<?= $value['id']; ?>"<?php if (!empty($_POST['category_id'])): ?>selected<?php endif; ?>><?= $value['category_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['category_id'])): ?>
                <span class="form__error"><?= $errors['category_id']; ?></span>
            <?php endif; ?>
        </div>
    </div>
    <div
        class="form__item form__item--wide<?php if (isset($errors['description'])): ?> form__item--invalid<?php endif; ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="description" placeholder="Напишите описание лота"><?=getPostVal('description'); ?></textarea>
        <?php if (isset($errors['description'])): ?>
            <span class="form__error"><?= $errors['description']; ?></span>
        <?php endif; ?>
    </div>
    <div class="form__item form__item--file<?php if (isset($errors['img'])): ?> form__item--invalid<?php endif; ?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="lot-img" name="img">
            <label for="lot-img">
                Добавить
            </label>
        </div>
        <?php if (isset($errors['img'])): ?>
            <span class="form__error"><?= $errors['img']; ?></span>
        <?php endif; ?>
    </div>
    <div class="form__container-three">
        <div
            class="form__item form__item--small<?php if (isset($errors['initial_price'])): ?> form__item--invalid<?php endif; ?>">
            <label for="lot-rate">Начальная цена <sup>*</sup></label>
            <input id="lot-rate" type="text" name="initial_price" placeholder="0" value="<?=getPostVal('initial_price'); ?>">
            <?php if (isset($errors['initial_price'])): ?>
                <span class="form__error"><?= $errors['initial_price']; ?></span>
            <?php endif; ?>
        </div>
        <div
            class="form__item form__item--small<?php if (isset($errors['bid_step'])): ?> form__item--invalid<?php endif; ?>">
            <label for="lot-step">Шаг ставки <sup>*</sup></label>
            <input id="lot-step" type="text" name="bid_step" placeholder="0" value="<?=getPostVal('bid_step'); ?>">
            <?php if (isset($errors['bid_step'])): ?>
                <span class="form__error"><?= $errors['bid_step']; ?></span>
            <?php endif; ?>
        </div>
        <div class="form__item<?php if (isset($errors['dt_end'])): ?> form__item--invalid<?php endif; ?>">
            <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
            <input class="form__input-date" id="lot-date" type="text" name="dt_end"
                   placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?=getPostVal('dt_end'); ?>">
            <?php if (isset($errors['dt_end'])): ?>
                <span class="form__error"><?= $errors['dt_end']; ?></span>
            <?php endif; ?>
        </div>
    </div>
    <?php if (count($errors) > 0): ?>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <?php endif; ?>
    <button type="submit" class="button">Добавить лот</button>
</form>
