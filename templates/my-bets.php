<pre><?= var_dump($my_bids); ?></pre>
<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <?php foreach ($my_bids as $bid): ?>
        <tr class="rates__item">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="<?= $bid['img']; ?>" width="54" height="40" alt="<?= $bid['lot_name']; ?>">
                </div>
                <h3 class="rates__title"><a href="lot.php?id=<?= $bid['id']; ?>"><?= $bid['lot_name']; ?></a></h3>
            </td>
            <td class="rates__category">
                <?= $bid['category_name']; ?>
            </td>

            <td class="rates__timer">
                <?php $timer = timer($bid['dt_end']); ?>
                <div class="timer<?php if ($timer[0] < 1): ?> timer--finishing<?php endif; ?>">
                    <?= $timer[0] ?> : <?= $timer[1]; ?>
                </div>
            </td>

            <td class="rates__price">
                <?= format_as_price_in_rub($bid['bid_price']); ?>
            </td>
            <td class="rates__time">
                <?= $bid['dt_format']; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>
