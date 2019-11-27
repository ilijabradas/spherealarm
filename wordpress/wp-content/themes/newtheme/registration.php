<?php /* Template Name: Registration Template */ ?>


<?php if (is_page(146) || is_page(162) || is_page(177)): ?>

    <?php get_header(); ?>

    <?php get_template_part('template-parts/registration', 'section'); ?>

    <?php get_footer(); ?>

<?php endif; ?>
