<?php
/*
Template Name: Страница вывода категорий
*/
?>

<?php get_header(); ?>

<main>
    <section class="listings">
        <div class="listings__map">
        </div>
        <div class="container">
            <div class="section-title">
                <h2><?php single_cat_title('Категория: '); ?></h2>
            </div>
        </div>
        <div class="container">
            <div class="category__body">
                <?php
                # получаем дочерние рубрики
                $parent_id = get_query_var('cat');
                $sub_cats = get_categories(array(
                    'child_of' => $parent_id,
                    'hide_empty' => 0
                ));
                if ($sub_cats) {
                    foreach ($sub_cats as $cat) { ?>
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
                <?php }
                ?>
            </div>
            <div class="listings__sort">
                <div class="listings__sort-title">
                    <p>Отображать:</p>
                </div>
                <div class="listings__sort-list color-purple" title="Список">
                    <span><i class="fa fa-list" aria-hidden="true"></i></span>
                </div>
                <div class="listings__sort-grid" title="Колонки">
                    <span><i class="fa fa-th" aria-hidden="true"></i></span>
                </div>
            </div>
            <div class="listings__items list">
                <?php
                $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
                $cat = get_category(get_query_var('cat'));
                $cat_slug = $cat->slug;

                $query = new WP_Query(array(
                    'category_name' => $cat_slug,
                    'posts_per_page' => 10,
                    'paged' => $paged,
                    'meta_key' => 'wpds_post_views',
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC'
                ));

                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post(); ?>
                        <div class="listings__item">
                            <div class="listings__item-img">
                                <figure>
                                    <a href="<?php echo get_permalink(); ?>"><img src="<?php the_field('photo'); ?>" alt="<?php the_title(); ?>"></a>
                                </figure>
                            </div>
                            <div class="listings__item-body">
                                <div class="listings__item-title">
                                    <h4><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h4>
                                </div>
                                <div class="listings__item-desc"><?php the_content(); ?></div>
                                <div class="listings__item-phone"><a href="tel:<?php the_field('phone'); ?>"><i class="fa fa-phone" aria-hidden="true"></i><?php the_field('phone'); ?></a></div>
                                <div class="listings__item-web"><a href="<?php the_field('site'); ?>"><i class=" fa fa-internet-explorer" aria-hidden="true"></i><?php the_field('site'); ?></a>
                                </div>
                                <div class="listings__item-location"><i class="fa fa-map-marker" aria-hidden="true"></i><?php the_field('adress'); ?></div>
                                <div class="listings__item-category">
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i><?php single_cat_title(); ?>
                                    <i class="fa fa-comment-o" aria-hidden="true"></i><span class="comment__number"><a href="<?php the_permalink() ?>#comments"><?php comments_number('0', '1', '%'); ?></a></span>
                                    <i class="fa fa-eye" aria-hidden="true"></i><span class="view__number"><?php echo get_post_views(get_the_ID()); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php }
                    ?>
                    <div class="pagination">
                        <?php
                        $max_page = $query->max_num_pages;
                        echo paginate_links(array(
                            'base'    => str_replace($max_page, '%#%', esc_url(get_pagenum_link($max_page))),
                            'format'  => '?paged=%#%',
                            'current' => max(1, get_query_var('paged')),
                            'total'   => $max_page,
                            'type'    => 'list',
                            'prev_text'    => __('« Назад'),
                            'next_text'    => __('Далее »'),
                        ));

                        ?>
                    </div>
                    <?php wp_reset_postdata(); ?>

                <?php } else {
                    echo "<div class='listings__error'>В данной категории организаций пока нет :(</div>";
                } ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>