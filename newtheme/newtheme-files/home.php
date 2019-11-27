<?php /* Template Name: Home Template */ ?>

<?php if (is_front_page() || is_home()) { ?>

    <?php get_header(); ?>

<!--    <h1>--><?php //the_title(); ?><!--</h1>-->
<!---->
<!--    --><?php //if (have_posts()) : while (have_posts()) : the_post(); ?>
<!---->
<!--        --><?php //the_content(); ?>
<!---->
<!--    --><?php //endwhile; endif; ?>

    <!--  check if the flexible content field has rows of data-->
    <?php if (have_rows('home_content')):
//         loop through the rows of data
        while (have_rows('home_content')) : the_row();

            if (get_row_layout() == 'hero_section'):

                get_template_part('template-parts/hero', 'section');

            elseif (get_row_layout() == 'about_section'):

                get_template_part('template-parts/about', 'section');

            elseif (get_row_layout() == 'contact_us_section'):

                get_template_part('template-parts/contact', 'section');

            endif;

        endwhile;

    else :

        // no layouts found

    endif; ?>

    </div>

    <?php get_footer(); ?>

<?php } ?>

