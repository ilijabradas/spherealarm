<?php
/**
 * Created by PhpStorm.
 * User: WOLF
 * Date: 2/24/2019
 * Time: 12:25 AM
 */
?>
<?php get_header();?>
<?php if (is_page(3) || is_page(2)): ?>
<img src="<?php echo get_template_directory_uri() . '/images/spherealarm_pages_logo.svg'; ?>"/>
<?php endif; ?>

<?php if (is_tree(3)) { ?>
    <?php $privacy = strip_tags(get_field('privacy_content'),'<h3><p><a><strong>');
          echo $privacy;
    ?>
<?php } ?>
<?php if (is_tree(2)) { ?>
    <?php $terms = strip_tags(get_field('terms_content'),'<h3><p><a><strong>');
    echo $terms;
    ?>

<?php } ?>
</div>
<?php get_footer();?>

