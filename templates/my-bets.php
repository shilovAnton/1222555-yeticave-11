<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <?php foreach ($my_bids as $bid): ?>
            <?php $timer = timer($bid['dt_end']);
            $is_winner = (int)$bid['user_id_winner'] === $_SESSION['user']['id'];
            $is_end = ($timer[0] < 1) && ($timer[1] < 1);

            $is_finishing = ($timer[0] < 1) && ($timer[1] > 0);

            $timer_class = 'timer';
            $timer_text = $timer[0] . ':' . $timer[1];

            $rates_item_class = 'rates__item';

            if ($is_winner) {
                $rates_item_class .= ' rates__item--win';
                $timer_class .= ' timer--win';
                $timer_text = 'Ставка выиграла';
            } elseif ($is_finishing) {
                $timer_class .= ' timer--finishing';
            } elseif ($is_end) {
                $rates_item_class .= ' rates__item--end';
                $timer_class .= ' timer--end';
                $timer_text = 'Торги окончены';
            }
            ?>
            <tr class="<?= $rates_item_class; ?>">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="<?= $bid['img']; ?>" width="54" height="40" alt="<?= $bid['lot_name']; ?>">
                    </div>
                    <h3 class="rates__title"><a
                            href="<?php if (!$is_end): ?>lot.php?id=<?= $bid['id']; ?><?php endif; ?>"><?= $bid['lot_name']; ?></a>
                    </h3>
                </td>
                <td class="rates__category">
                    <?= $bid['category_name']; ?>
                </td>

                <td class="rates__timer">
                    <div
                        class="<?= $timer_class; ?>">
                        <?= $timer_text; ?>
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
