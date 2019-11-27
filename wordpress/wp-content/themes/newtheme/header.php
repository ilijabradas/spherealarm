<?php
/**
 * Created by PhpStorm.
 * User: WOLF
 * Date: 2/24/2019
 * Time: 12:24 AM
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?php bloginfo('name'); ?> » <?php bloginfo('description'); ?></title>

    <meta property="description" value="<?php the_field('meta_description', 'option'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="wrapper">
    <header>
        <div class="header-inner-wrapper">
            <a class="logo" href="<?php bloginfo('url'); ?>">
                <?php if(is_page(136)): ?>
                <img src="<?php echo get_template_directory_uri() . '/images/spherealarm_logo.png'; ?>"/>
                <!-- replace with silver logo version -->
                <?php else: ?>
                    <img src="<?php echo get_template_directory_uri() . '/images/spherealarm_logo.png'; ?>"/>
                <?php endif; ?>
            </a>
            <button class="btn btn-menu fa fa-bars"></button>
            <nav>
                <?php wp_nav_menu(
                    array(

                        'theme_location' => 'header-menu',
                        'menu_class' => 'primary',
                        'container' => ''
                    )
                ); ?>
            </nav>
        </div>
    </header>

