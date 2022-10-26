<?php
/*
Template Name: Страница организации
*/
?>

<?php get_header(); ?>

<main>
    <section class="listing-slide">
        <div class="slider listing-slider">
            <?php
            $images = get_field('slider');
            if ($images) : ?>
                <?php foreach ($images as $image) : ?>
                    <div class="listing-slider__item">
                        <a href="<?php echo esc_url($image['url']); ?>" data-lightbox="roadtrip">
                            <img src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                        </a>
                        <p><?php echo esc_html($image['caption']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
    <?php echo breadcrumb(' / '); ?>
    <section class="listing">
        <div class="container">
            <div class="listing__top">
                <div class="listing__title">
                    <h4><?php the_title(); ?></h4>
                </div>
                <div class="listing__meta">
                    <div class="listing__category">
                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                        <?php
                        $category = get_the_category();
                        echo $category[0]->cat_name;
                        ?>
                        <i class="fa fa-comment-o" aria-hidden="true"></i><span class="comment__number"><a href="<?php the_permalink() ?>#comments"><?php comments_number('0', '1', '%'); ?></a></span>
                        <i class="fa fa-eye" aria-hidden="true"></i><span class="view__number"><?php echo get_post_views(get_the_ID()); ?></span>
                    </div>
                </div>
            </div>
            <div class="listing__body">
                <div class="listing__desc">
                    <div class="listing__desc-title">Описание</div>
                    <div class="listing__desc-text"><?php the_content(); ?></div>
                </div>
                <div class="listing__info">
                    <div class="listing__info-title">Контактная информация</div>
                    <div class="listing__info-phone"><a href="tel:<?php the_field('phone'); ?>"><i class="fa fa-phone" aria-hidden="true"></i><?php the_field('phone'); ?></a></div>
                    <div class="listing__info-web"><a href="<?php the_field('site'); ?>"><i class=" fa fa-internet-explorer" aria-hidden="true"></i><?php the_field('site'); ?></a>
                    </div>
                    <div class="listing__info-location"><i class="fa fa-map-marker" aria-hidden="true"></i><?php the_field('adress'); ?></div>
                    <a class="btn listing__info-btn" href="tel:<?php the_field('phone'); ?>">Связаться</a>
                </div>
            </div>
            <div class="listing__bottom">
                <div class="listings__bottom-body" id="map">
                    <?php the_yandex_map('map') ?>
                </div>
            </div>
        </div>
        <div class="listing__comments">
            <div class="container">
                <div class="listing__comments-body">
                    <?php comments_template('comments.php'); ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>