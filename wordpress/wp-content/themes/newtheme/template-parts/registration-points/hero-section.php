<?php
/**
 * Created by PhpStorm.
 * User: WOLF
 * Date: 11/17/2019
 * Time: 9:12 PM
 */
?>

<?php $hero = get_field('hero'); ?>
<?php if ($hero): ?>
    <section class="registration-hero-section">
        <div class="outer-wrapper">
            <div class="inner-wrapper">
                <div class="content-wrapper">
                    <h1 class="h1-white"><?php echo $hero['headline']; ?></h1>
                </div>
                <div class="image-wrapper">
                    <img src="<?php echo esc_url($hero['image']); ?>"/>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
