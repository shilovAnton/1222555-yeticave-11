<section class="lot-item container">
    <h2><?= $lot['lot_name']; ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src=<?= $lot['img']; ?> width="730" height="548" alt="<?= $lot['lot_name']; ?>">
            </div>
            <p class="lot-item__category">Категория: <span><?= $lot['category_name']; ?></span></p>
            <p class="lot-item__description"><?= $lot['description']; ?></p>
        </div>
        <div class="lot-item__right">
            <?php if ($user): ?>
            <div class="lot-item__state">
                <?php $timer = timer($lot['dt_end']); ?>
                <div class="lot-item__timer timer <?php if ($timer[0] < 1): ?> timer--finishing<?php endif; ?>">
                    <?= $timer[0] ?>:<?= $timer[1]; ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">
                            <?php if ($lot['current_price'] === null): ?>
                                Начальная цена
                            <?php else: ?>
                                Текущая цена
                            <?php endif; ?>
                        </span>
                        <span class="lot-item__cost"><?php
                            if ($lot['current_price'] === null) {
                                print format_as_price_in_rub($lot['initial_price']);
                            } else {
                                print format_as_price_in_rub($lot['current_price']);
                            } ?>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= format_as_price_in_rub($lot['bid_step']); ?></span>
                    </div>
                </div>
                <form class="lot-item__form" action="lot.php?id=<?= $lot['id']; ?>"
                      method="post" autocomplete="off">
                    <p class="lot-item__form-item form__item<?php if (isset($errors['cost'])): ?> form__item--invalid<?php endif; ?>">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="cost" placeholder="<?= $min_bid; ?>"
                               value="<?= getPostVal('cost'); ?>">
                        <?php if (isset($errors['cost'])): ?>
                            <span class="form__error"><?= $errors['cost']; ?></span>
                        <?php endif; ?>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <div class="history">
                <h3>История ставок (<span><?= $count; ?></span>)</h3>
                <table class="history__list">
                    <?php foreach ($result_history as $bids): ?>
                        <tr class="history__item">
                            <td class="history__name"><?= htmlspecialchars($bids['user_name']); ?></td>
                            <td class="history__price"><?= htmlspecialchars($bids['bid_price']); ?></td>
                            <td class="history__time"><?= htmlspecialchars($bids['dt_format']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>


