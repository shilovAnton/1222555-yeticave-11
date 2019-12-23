<div class="container">
    <section class="lots">
            <h2>Все лоты в категории «<span><?php if ($lots): ?><?= htmlspecialchars($lots[0]['category_name']) ?? ''; ?><?php endif; ?></span>»</h2>
        <ul class="lots__list">
            <?php foreach ($lots as $lot): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= $lot['img']; ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= htmlspecialchars($lot['category_name']); ?></span>
                        <h3 class="lot__title"><a class="text-link"
                                                  href="lot.php?id=<?= $lot['id']; ?>"><?= htmlspecialchars($lot['lot_name']); ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Цена</span>
                                <span class="lot__cost"><?php if(!empty($lot['current_price'])): ?>
                                        <?= format_as_price_in_rub($lot['current_price']); ?>
                                    <?php else: ?>
                                        <?= format_as_price_in_rub($lot['initial_price']); ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <?php $timer = timer($lot['dt_end']); ?>
                            <div class="lot__timer timer <?php if ($timer[0] < 1): ?>timer--finishing<?php endif; ?>">
                                <?= $timer[0] ?> : <?= $timer[1]; ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <ul class="pagination-list">
        <?php if ($cur_page != 1): ?>
            <li class="pagination-item pagination-item-prev"><a
                    href="/all-lots.php?page=<?= $cur_page - 1; ?>&id=<?= $category_id; ?>">Назад</a></li>
        <?php endif; ?>
        <?php foreach ($pages as $page): ?>
            <li class="pagination-item <?php if ($cur_page == $page): ?>pagination-item-active<?php endif; ?>"><a
                    href="/all-lots.php?page=<?= $page; ?>&id=<?= $category_id; ?>"><?= $page; ?></a></li>
        <?php endforeach; ?>
        <?php if ($cur_page != count($pages)): ?>
            <li class="pagination-item pagination-item-next"><a
                    href="/all-lots.php?page=<?= $cur_page + 1; ?>&id=<?= $category_id; ?>">Вперед</a></li>
        <?php endif; ?>
    </ul>
</div>

