<?php
/**
 * Created by PhpStorm.
 * User: WOLF
 * Date: 2/24/2019
 * Time: 2:20 AM
 */
?>
<?php
$contact_us_content = strip_tags(get_sub_field('contact_us_content'));
?>
<section class="contact-us-section" id="contact-us">
    <div class="contact-content-wrapper">
        <h2 class="h2-gray"><?php the_sub_field('contact_us_headline'); ?></h2>
        <img src="<?php the_field('dots', 'option'); ?>"/>
        <p class="p-gray"><?php echo $contact_us_content; ?></p>
    </div>
    <div class="contact-form-wrapper">
        <?php echo do_shortcode("[contact-form-7 id='18' title='Contact form 1']"); ?>
    </div>
</section>


