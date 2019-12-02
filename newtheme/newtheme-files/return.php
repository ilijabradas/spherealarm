<?php /* Template Name: Return Template */ ?>

<?php if (is_page(136)): ?>
    <div class="loader"><img src="<?php echo get_template_directory_uri() . '/images/loader.gif'; ?>"/></div>
    <?php get_header(); ?>

    <?php $return_policy = strip_tags(get_field('return_policy_content'),'<h3><p><a><strong>');
//    echo $return_policy;
    get_template_part('template-parts/return-form', 'section');
    ?>


    <?php get_footer(); ?>

<?php endif; ?>
