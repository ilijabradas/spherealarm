<?php
/**
 * Created by PhpStorm.
 * User: WOLF
 * Date: 2/24/2019
 * Time: 12:25 PM
 */
?>
<?php $point_content = strip_tags(get_sub_field('point_content')); ?>

<div class="point-wrapper <?php the_sub_field('point_class'); ?>">
    <div class="image-wrapper">
        <img src="<?php the_sub_field('point_image'); ?>"/>
    </div>
    <div class="content-wrapper">
        <h2 class="h2-gray"><?php the_sub_field('point_headline'); ?></h2>
        <img src="<?php the_field('dots', 'option'); ?>"/>
        <p class="p-gray"><?php echo $point_content; ?></p>
    </div>
</div>
