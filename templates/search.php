
<div class="container">
    <section class="lots">
        <h2>Результаты поиска по запросу «<span><?= htmlspecialchars($_GET['search']); ?></span>»</h2>
        <ul class="lots__list">
            <?php foreach ($lots as $lot => $key): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= $lots[$lot]['img']; ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= htmlspecialchars($lots[$lot]['category_name']); ?></span>
                        <h3 class="lot__title"><a class="text-link"
                                                  href="lot.php?id=<?= $lots[$lot]['id']; ?>"><?= htmlspecialchars($lots[$lot]['lot_name']); ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">праптмтмтм</span>
                                <span class="lot__cost"><?php if(!empty($lots[$lot]['current_price'])): ?>
                                        <?= format_as_price_in_rub($lots[$lot]['current_price']); ?>
                                    <?php else: ?>
                                        <?= format_as_price_in_rub($lots[$lot]['initial_price']); ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <?php $timer = timer($lots[$lot]['dt_end']); ?>
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
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <li class="pagination-item pagination-item-active"><a>1</a></li>
        <li class="pagination-item"><a href="#">2</a></li>
        <li class="pagination-item"><a href="#">3</a></li>
        <li class="pagination-item"><a href="#">4</a></li>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
    </ul>
</div>
