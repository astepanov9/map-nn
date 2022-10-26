<?php

/**
 * Theme map functions
 */

// Стили и скрипты
add_action('wp_enqueue_scripts', function () {

    wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.min.css');

    wp_enqueue_script('libs', get_template_directory_uri() . '/assets/js/libs.min.js', array('jquery'), 'null', true);
    wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/main.min.js', array('jquery'), 'null', true);
});

add_theme_support('post-thumbnails');
add_theme_support('title-tag');
add_theme_support('custom-logo');
add_theme_support('menus');

add_filter('upload_mimes', 'svg_upload_allow');

// Добавляет SVG в список разрешенных для загрузки файлов.
function svg_upload_allow($mimes)
{
    $mimes['svg']  = 'image/svg+xml';

    return $mimes;
}

// Удаляем префикс «category» из URL рубрик
add_filter('category_link', 'true_remove_category_from_category', 1, 1);

function true_remove_category_from_category($cat_url)
{
    $cat_url = str_replace('/category', '', $cat_url);
    return $cat_url;
}

// Меняем название 'Записи' на 'Организации'
add_filter('register_post_type_args', 'filter_register_post_type_args', 10, 2);
function filter_register_post_type_args($args, $post_type)
{

    if ('post' == $post_type) {
        $args['labels'] = [
            'name'          => 'Организации',
            'singular_name' => 'Организации',
        ];
    }

    return $args;
}

// Хлебные крошки
function breadcrumb($sep = ' > ')
{
    global $post;
    $out = '';
    $out .= '<div class="breadcrumbs">';
    $out .= '<div class="container">';
    $out .= '<a href="' . home_url('/') . '">Главная</a>';
    $out .= '<span class="breadcrumbs-sep">' . $sep . '</span>';
    if (is_single()) {
        $terms = get_the_terms($post, 'category');
        if (is_array($terms) && $terms !== array()) {
            $out .= '<a href="' . get_term_link($terms[0]) . '">' . $terms[0]->name . '</a>';
            $out .= '<span class="breadcrumbs-sep">' . $sep . '</span>';
        }
    }
    if (is_singular()) {
        $out .= '<span class="breadcrumbs-last">' . get_the_title() . '</span>';
    }
    if (is_search()) {
        $out .= get_search_query();
    }
    $out .= '</div>';
    $out .= '</div><!--breadcrumbs-->';
    return $out;
}

// Счетчик просмотров
add_filter("wp_head", "wpds_increament_post_view");
function get_post_views($post_id = NULL)
{
    global $post;
    if ($post_id == NULL)
        $post_id = $post->ID;
    if (!empty($post_id)) {
        $views_key = 'wpds_post_views';
        $views = get_post_meta($post_id, $views_key, true);
        if (empty($views) || !is_numeric($views)) {
            delete_post_meta($post_id, $views_key);
            add_post_meta($post_id, $views_key, '0');
            return "0";
        } else if ($views == 1)
            return "1";
        return $views;
    }
}
function wpds_increament_post_view()
{
    global $post;

    if (is_singular()) {
        $views_key = 'wpds_post_views';
        $views = get_post_meta($post->ID, $views_key, true);
        if (empty($views) || !is_numeric($views)) {
            delete_post_meta($post->ID, $views_key);
            add_post_meta($post->ID, $views_key, '1');
        } else
            update_post_meta($post->ID, $views_key, ++$views);
    }
}

// Форма поиска
add_filter('register_post_type_args', function ($args, $post_type) {
    if (!is_admin() && $post_type == 'page') {
        $args['exclude_from_search'] = true;
    }
    return $args;
}, 10, 2);

// Комментарии
add_filter('comment_form_default_fields', 'wp_url_remove');

function wpschool_change_submit_label($defaults)
{
    $defaults['title_reply'] = 'Оставить комментарий об организации';
    $defaults['label_submit'] = 'Оставить комментарий';
    return $defaults;
}
add_filter('comment_form_defaults', 'wpschool_change_submit_label');

function wp_url_remove($fields)
{
    if (isset($fields['url']))
        unset($fields['url']);
    return $fields;
}

function mytheme_comment($comment, $args, $depth)
{
    if ('div' === $args['style']) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }

    $classes = ' ' . comment_class(empty($args['has_children']) ? '' : 'parent', null, null, false);
?>

    <?php echo $tag, $classes; ?> id="comment-<?php comment_ID() ?>">
    <?php if ('div' != $args['style']) { ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
                                                                        } ?>

        <div class="comment-author vcard">
            <?php
            if ($args['avatar_size'] != 0) {
                echo get_avatar($comment, $args['avatar_size']);
            }
            printf(
                __('<cite class="fn">%s</cite> <span class="says">says:</span>'),
                get_comment_author_link()
            );
            ?>
        </div>

        <?php if ($comment->comment_approved == '0') { ?>
            <em class="comment-awaiting-moderation">
                <?php _e('Your comment is awaiting moderation.'); ?>
            </em><br />
        <?php } ?>

        <div class="comment-meta commentmetadata">
            <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">
                <?php
                printf(
                    __('%1$s at %2$s'),
                    get_comment_date(),
                    get_comment_time()
                ); ?>
            </a>

            <?php edit_comment_link(__('(Edit)'), '  ', ''); ?>
        </div>

        <?php comment_text(); ?>

        <div class="reply">
            <?php
            comment_reply_link(
                array_merge(
                    $args,
                    array(
                        'add_below' => $add_below,
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth']
                    )
                )
            ); ?>
        </div>

        <?php if ('div' != $args['style']) { ?>
        </div>
<?php }
    }
