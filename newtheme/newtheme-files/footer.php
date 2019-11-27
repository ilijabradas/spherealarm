<?php
/**
 * Created by PhpStorm.
 * User: WOLF
 * Date: 2/24/2019
 * Time: 12:25 AM
 */
?>
<?php $social_icons = get_sub_field('social_icons', 'option'); ?>

<footer>
    <div class="inner-wrapper">
        <a class="logo" href="<?php bloginfo('url'); ?>">
            <img src="<?php echo get_template_directory_uri() . '/images/spherealarm_footer_logo.png'; ?>"/>
        </a>
        <?php wp_nav_menu(
            array(

                'theme_location' => 'footer-menu',
                'menu_class' => 'secondary',
                'container' => ''
            )
        ); ?>
        <?php if (have_rows('social_icons', 'option')): ?>

            <ul class="social">
           <?php while (have_rows('social_icons', 'option')) : the_row(); ?>

              <li>
                  <a target="_blank" href="<?php the_sub_field('icon_url'); ?>">
                      <i class="<?php the_sub_field('icon_class'); ?>" aria-hidden="true"></i>
                  </a>
              </li>

          <?php endwhile; ?>
            </ul>

       <?php else :

        endif; ?>
        <div class="copyright">
            &copy; <?php echo date('Y'); ?> Sphere App
        </div>
    </div>

</footer>
<?php wp_footer(); ?>
</body>
</html>
