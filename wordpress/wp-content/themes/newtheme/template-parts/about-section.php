<?php
/**
 * Created by PhpStorm.
 * User: WOLF
 * Date: 2/24/2019
 * Time: 2:19 AM
 */
?>
<?php
$about_content = strip_tags(get_sub_field('about_content'),'<p>');
?>

<section class="about-section" id="about-us">
    <div class="about-content-wrapper">
        <h2 class="h2-gray"><?php the_sub_field('about_headline'); ?></h2>
        <img src="<?php the_field('dots', 'option'); ?>"/>
        <p class="p-gray"><?php echo $about_content; ?></p>
        <img class="about-image" src="<?php the_sub_field('about_image'); ?>"/>
    </div>
    <div class="about-points-wrapper">
        <!--         check if the nested repeater field has rows of data-->
        <?php if (have_rows('about_points')): ?>
            <!--         loop through the rows of data-->
            <?php while (have_rows('about_points')) : the_row(); ?>

                <?php get_template_part('template-parts/about-points/point', 'section'); ?>

            <?php endwhile; endif; ?>
    </div>
</section>
