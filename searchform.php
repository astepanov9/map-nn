<form role="search" method="get" id="searchform" action="<?php echo home_url('/') ?>" class="header-banner__form">
    <input type="text" value="<?php echo get_search_query() ?>" name="s" id="s" placeholder="Что ищем?">
    <button type="submit" class="btn">Найти</button>
</form>