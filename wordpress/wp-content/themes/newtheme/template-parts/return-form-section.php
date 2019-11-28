<?php
/**
 * Created by PhpStorm.
 * User: WOLF
 * Date: 11/24/2019
 * Time: 12:53 AM
 */
?>
<section class="return-form">
    <div class="headline">Complete your return in 4 easy steps:</div>
    <div id="result"></div>
    <form id="return-form">
        <div class="guide-wrapper">
            <?php if (have_rows('guide')): ?>
                <?php while (have_rows('guide')): the_row();

                    $image = get_sub_field('image');
                    $number = get_sub_field('number');
                    $content = get_sub_field('content');
                    ?>
                    <div class="item">
                        <img src="<?php echo $image; ?>"/>
                        <div class="number"> <?php echo $number; ?>.</div>
                        <div class="content"><?php echo $content; ?></div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
        <div class="form-wrapper">
            <div class="input-wrapper">
                <input type="text" name="name" id="name" placeholder="Your Name"/>
            </div>
            <div class="input-wrapper">
                <input type="text" name="email" id="email" placeholder="Email (the one you provided to place your order)"/>
            </div>
            <div class="input-wrapper">
                <input type="text" name="order" id="order" placeholder="Order Number"/>
            </div>
            <div class="input-wrapper action">
                <select class="custom-select-action" name="action" id="action" placeholder="Please select an action">
                    <?php foreach (getActions() as $action): ?>
                        <option value="<?php echo $action['abbrev'] ?>"><?php echo $action['action'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-wrapper replacement" style="display: none;">
                <textarea type="text" name="replacement" id="replacement" placeholder="Enter product name you wish to exchange for"></textarea>
            </div>

            <div class="input-wrapper return" style="display: none;">
                <select class="custom-select-return" name="return" id="return" placeholder="Please select return reason">
                    <?php foreach (getReturnReasons() as $return_reason): ?>
                        <option value="<?php echo $return_reason['abbrev'] ?>"><?php echo $return_reason['reason'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button id="submit-return" type="submit" class="btn-large">SUBMIT</button>
        </div>
    </form>
</section>
