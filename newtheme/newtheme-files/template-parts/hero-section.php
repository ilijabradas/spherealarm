<?php
/**
 * Created by PhpStorm.
 * User: WOLF
 * Date: 2/24/2019
 * Time: 2:18 AM
 */
?>
<!--the_sub_field()	Displays the value of a specific sub field.-->
<!--get_sub_field()	Returns the value of a specific sub field.-->

<?php $hero_background = get_sub_field('hero_background');
      $hero_headline = strip_tags(get_sub_field('hero_headline'));
?>
<section class="hero-section">
    <div class="background-hero-section">
        <div class="outer-wrapper">
            <div class="content-wrapper">
                <h1 class="h1-white"><?php echo $hero_headline; ?></h1>
                <div class="buttons-wrapper">
                    <a class="btn-regular link-white" href="<?php the_sub_field('hero_button_url_ios'); ?>" target="_blank">
                        <i class="fa fa-apple"></i><?php the_sub_field('hero_button_text_ios'); ?>
                    </a>
                    <a class="btn-regular link-white" href="<?php the_sub_field('hero_button_url_android'); ?>" target="_blank">
                        <i class="fa fa-android"></i> <?php the_sub_field('hero_button_text_android'); ?>
                    </a>
                </div>
            </div>
            <div class="image-wrapper">
                <img src="<?php the_sub_field('hero_image'); ?>"/>
            </div>
        </div>
    </div>
</section>
