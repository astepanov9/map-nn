<?php
/*
Template Name: Главная страница
*/
?>

<?php get_header(); ?>

<main>
    <section class="header-banner" style="background-image: url('<?php the_field('header_image'); ?>'); ">
        <div class="container">
            <div class="header-banner__body">
                <div class="header-banner__top">
                    <div class="header-banner__title"><?php the_field('title'); ?></div>
                    <div class="header-banner__subtitle"><?php the_field('subtitle'); ?></div>
                </div>
                <div class="header-banner__bottom">
                    <?php get_search_form(); ?>
                </div>
            </div>
        </div>
    </section>
    <section class="category">
        <div class="container">
            <div class="section-title">
                <h2>Категории</h2>
            </div>
            <div class="category__body">
                <?php
                $categories = get_categories(array(
                    'taxonomy' => 'category',
                    'hide_empty' => false,
                    'orderby' => 'name',
                    'parent'  => 0,
                    'exclude' => '1'
                ));
                if ($categories) {
                    foreach ($categories as $cat) { ?>
                        <a href="<?php echo get_category_link($cat->term_id); ?>">
                            <div class="category__item">
                                <div class="category__link">
                                    <?php if ($category_image = get_field("category_image", $cat)) { ?><figure><img src="<?php echo $category_image; ?>" /></figure><?php } ?>
                                    <div class="category__info">
                                        <div class="category__name"><i class="fa fa-check-square-o" aria-hidden="true"></i><a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->name; ?></a></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>