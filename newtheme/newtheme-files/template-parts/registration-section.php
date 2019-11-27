<?php
/**
 * Created by PhpStorm.
 * User: WOLF
 * Date: 11/17/2019
 * Time: 9:08 PM
 */
?>
<?php $hero = get_field('hero'); ?>
<?php get_template_part('template-parts/registration-points/hero', 'section'); ?>
<?php if (is_page(146)): ?>
    <section class="registration-user-details">
        <form id="step-one">
            <div class="input-wrapper">
                <input type="text" name="name" id="name" placeholder="Your Name"/>
            </div>
            <div class="input-wrapper">
                <input type="text" name="street" id="street" placeholder="Street Address"/>
            </div>
            <div class="float-wrapper">
                <div class="input-wrapper city">
                    <input type="text" name="city" id="city" placeholder="City"/>
                </div>

                <select class="custom-select-state" name="state" id="state" placeholder="State">
                    <?php foreach (getStates() as $state): ?>
                        <option value="<?php echo $state['abbrev'] ?>"><?php echo $state['name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <div class="input-wrapper zip">
                    <input type="text" name="zip" id="zip" placeholder="Zip"/>
                </div>
            </div>
            <div class="input-wrapper">
                <input type="text" name="phone" id="phone" placeholder="Phone Number"/>
            </div>
            <div class="input-wrapper">
                <input type="text" name="id_number" id="id_number"
                       placeholder="ID Number"/>
                <img id="help" class="help" src="<?php echo esc_url($hero['help']); ?>" data-toggle="tooltip"/>
            </div>
            <button id="submit-step-one" type="submit" class="btn-large">REGISTER</button>
        </form>
        <div class="p-gray-small"><?php echo $hero['disclaimer']; ?></div>
    </section>
<?php endif; ?>
<?php if (is_page(162)): ?>
    <section class="registration-additional-details">
        <div class="headline">Just a few more questions...</div>
        <div id="result"></div>
        <form id="step-two">
            <div class="input-wrapper reason">
                <div class="info">Where did you hear about us?</div>
                <select class="custom-select-reason" name="reason" id="reason" placeholder="Select">
                    <?php foreach (getHearReasons() as $reason): ?>
                        <option value="<?php echo $reason['abbrev'] ?>"><?php echo $reason['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-wrapper other" style="display: none;">
                <input type="text" name="other" id="other" placeholder="Please Specify"/>
            </div>
            <div class="float-wrapper">
                <div class="info">What are you using Sphere for?</div>
                <div class="input-wrapper usage">
                    <div class="holder">
                        <input id="usage-apartment" name="usage" class="checkbox-input" type="checkbox" value="Apartement" tabindex="1"/>
                        <label class="checkbox-label" for="usage-apartment"><span>Apartement</span></label>
                    </div>
                    <div class="holder">
                        <input id="usage-house" name="usage" class="checkbox-input" type="checkbox" value="House" tabindex="1"/>
                        <label class="checkbox-label" for="usage-house"><span>House</span></label>
                    </div>
                    <div class="holder">
                        <input id="usage-office" name="usage" class="checkbox-input" type="checkbox" value="Office" tabindex="1"/>
                        <label class="checkbox-label" for="usage-office"><span>Office</span></label>
                    </div>
                    <div class="holder">
                        <input id="usage-other" name="usage" class="checkbox-input" type="checkbox" value="Other" tabindex="1"/>
                        <label class="checkbox-label" for="usage-other"><span>Other</span></label>
                    </div>
                </div>

                <div class="info">How many entry points are you securing?</div>
                <div class="input-wrapper entries">
                    <div class="holder">
                        <input id="entries-one" name="entries" class="checkbox-input" type="checkbox" value="One" tabindex="1"/>
                        <label class="checkbox-label" for="entries-one"><span>1</span></label>
                    </div>
                    <div class="holder">
                        <input id="entries-two" name="entries" class="checkbox-input" type="checkbox" value="Two" tabindex="1"/>
                        <label class="checkbox-label" for="entries-two"><span>2</span></label>
                    </div>
                    <div class="holder">
                        <input id="entries-three" name="entries" class="checkbox-input" type="checkbox" value="Three" tabindex="1"/>
                        <label class="checkbox-label" for="entries-three"><span>3</span></label>
                    </div>
                    <div class="holder">
                        <input id="entries-four-plus" name="entries" class="checkbox-input" type="checkbox" value="Four-Plus" tabindex="1"/>
                        <label class="checkbox-label" for="entries-four-plus"><span>4+</span></label>
                    </div>
                </div>

                <div class="info">How many people will be using your system?</div>
                <div class="input-wrapper people">
                    <div class="holder">
                        <input id="people-one" name="people" class="checkbox-input" type="checkbox" value="One" tabindex="1"/>
                        <label class="checkbox-label" for="people-one"><span>1</span></label>
                    </div>
                    <div class="holder">
                        <input id="people-two" name="people" class="checkbox-input" type="checkbox" value="Two" tabindex="1"/>
                        <label class="checkbox-label" for="people-two"><span>2</span></label>
                    </div>
                    <div class="holder">
                        <input id="people-three" name="people" class="checkbox-input" type="checkbox" value="Three" tabindex="1"/>
                        <label class="checkbox-label" for="people-three"><span>3</span></label>
                    </div>
                    <div class="holder">
                        <input id="people-four-plus" name="people" class="checkbox-input" type="checkbox" value="Four-Plus" tabindex="1"/>
                        <label class="checkbox-label" for="people-four-plus"><span>4+</span></label>
                    </div>
                </div>
            </div>
            <button id="submit-step-two" type="submit" class="btn-large">SUBMIT</button>
        </form>
        <div class="p-gray-small"><?php echo $hero['disclaimer']; ?></div>
    </section>
<?php endif; ?>
<?php if (is_page(177)): ?>
<section class="registration-success-details">
    <div class="headline">Thanks for registering!</div>
    <div class="p-gray">
        <?php echo $hero['success']; ?>
    </div>
</section>
<?php endif; ?>
