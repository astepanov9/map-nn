<?php get_header(); ?>

<main>
    <section class="search">
        <div class="container">
            <?php
            $s = get_search_query();
            $args = array(
                's' => $s,
            );
            // The Query
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()) {
                _e("<div class='section-title'><h2>Результат поиска по: " . get_query_var('s') . "</h2></div>");
                while ($the_query->have_posts()) {
                    $the_query->the_post();
            ?>
                    <div class="listings__items list">
                        <div class="listings__item list-item">
                            <div class="listings__item-img">
                                <figure>
                                    <a href="<?php the_field('photo'); ?>" data-lightbox="<?php the_title(); ?>" data-title="<?php the_title(); ?>"><img src="<?php the_field('photo'); ?>" alt="photo"></a>
                                </figure>
                            </div>
                            <div class="listings__item-body">
                                <div class="listings__item-title">
                                    <h4><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h4>
                                </div>
                                <div class="listings__item-desc"><?php the_content(); ?></div>
                                <div class="listings__item-phone"><a href="tel:<?php the_field('phone'); ?>"><i class="fa fa-phone" aria-hidden="true"></i><?php the_field('phone'); ?></a></div>
                                <div class="listings__item-web"><a href="<?php the_field('site'); ?>><i class=" fa fa-internet-explorer" aria-hidden="true"></i><?php the_field('site'); ?></a>
                                </div>
                                <div class="listings__item-location"><i class="fa fa-map-marker" aria-hidden="true"></i><?php the_field('adress'); ?></div>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="section-title">
                    <h2>Ничего не найдено :(</h2>
                </div>
                <div class="listings__error">Извините, но ничто не соответствовало вашим критериям поиска. Пожалуйста, повторите попытку с теми же другими ключевыми словами.</div>
            <?php } ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>