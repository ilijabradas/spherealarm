<?php

if (function_exists('acf_add_options_page')) {


     acf_add_options_page(array(
      'page_title' => 'Theme Settings',
      'menu_title' => 'Theme Settings',
      'menu_slug' => 'theme-settings',
      'capability' => 'edit_posts',
      'parent_slug' => '',
      'position' => false,
      'icon_url' => false,
      'redirect' => false,
      ));
     acf_add_options_sub_page(array(
      'page_title' => 'General',
      'menu_title' => 'General',
      'menu_slug' => 'theme-settings-general',
      'capability' => 'edit_posts',
      'parent_slug' => 'theme-settings',
      'position' => false,
      'icon_url' => false,
      ));
     acf_add_options_sub_page(array(
      'page_title' => 'Footer',
      'menu_title' => 'Footer',
      'menu_slug' => 'theme-settings-footer',
      'capability' => 'edit_posts',
      'parent_slug' => 'theme-settings',
      'position' => false,
      'icon_url' => false,
      ));
}

define('THEME_VERSION', '0.0.1');
if (!function_exists('theme_setup')) {
    function theme_setup()
    {

        // add_theme_support('title-tag');
    }
    add_action('after_setup_theme', 'theme_setup');
}
function theme_styles()
{
    wp_register_style('theme_style', get_template_directory_uri() . '/css/app.css', false, THEME_VERSION, 'all');
    wp_enqueue_style('theme_style');
}
add_action('wp_enqueue_scripts', 'theme_styles');

function theme_js()
{
    global $wp_scripts;
    $hero = get_field('hero');
//    wp_deregister_script('jquery');
    wp_register_script('html5_shiv', 'https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js', false, THEME_VERSION, false);
    wp_register_script('respond_js', 'https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js', false, THEME_VERSION, false);

    wp_register_script('theme_vendor', get_template_directory_uri() . '/js/vendor.js', false, THEME_VERSION, true);
    wp_enqueue_script('theme_js', get_template_directory_uri() . '/js/app.js', array('theme_vendor'), THEME_VERSION, true);
    wp_localize_script('theme_js', 'WPURLS', array(
        'siteurl' => get_option('siteurl'),
        'tooltip' => $hero['tooltip'],
        'api_nonce' => wp_create_nonce('wp_rest'),
        'api_url'   => site_url('/wp-json/rest/v1/')
    ));


    $wp_scripts->add_data('html5_shiv', 'conditional', 'lt IE 9');
    $wp_scripts->add_data('respond_js', 'conditional', 'lt IE 9');

}
add_action('wp_enqueue_scripts', 'theme_js', 20);

add_theme_support('menus');
add_theme_support('post-thumbnails');

register_nav_menus(array(
        'header-menu'   => __('Header Menu', 'theme'),
        'footer-menu' => __('Footer Menu', 'theme'),
    ));



function svg_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'svg_mime_types');

//
//add_filter('wp_head', 'my_wpcf7_ajax_loader');
//
//add_action('wp_head', 'my_custom_styles', 100);
//
//function my_custom_styles()
//{
//    echo "<style type='text/css'>
//        .wpcf7 .ajax-loader{
//          display:none !important;
//        }
//        span.wpcf7-list-item {
//        margin:0 0 20px 0 !important;
//      }
//      @media (max-width:767px) {
//      span.wpcf7-list-item {
//               display: block;
//              position: relative;
//             left: 25%;
//           }
//      }
//      </style>";
//}
function is_tree($pid)
{
    global $post;

    $ancestors = get_post_ancestors($post->$pid);
    $root      = count($ancestors) - 1;
    $parent    = $ancestors[$root];

    if (is_page() && (is_page($pid) || $post->post_parent == $pid || in_array($pid, $ancestors))) {
        return true;
    } else {
        return false;
    }
}

function getStates() {
    $states = array(
        array('abbrev' => 'AL', 'name' => 'Alabama'),
        array('abbrev' => 'AK', 'name' => 'Alaska'),
        array('abbrev' => 'AS', 'name' => 'American Samoa'),
        array('abbrev' => 'AZ', 'name' => 'Arizona'),
        array('abbrev' => 'AR', 'name' => 'Arkansas'),
        array('abbrev' => 'AF', 'name' => 'Armed Forces Africa'),
        array('abbrev' => 'AA', 'name' => 'Armed Forces Americas'),
        array('abbrev' => 'AC', 'name' => 'Armed Forces Canada'),
        array('abbrev' => 'AE', 'name' => 'Armed Forces Europe'),
        array('abbrev' => 'AM', 'name' => 'Armed Forces Middle East'),
        array('abbrev' => 'AP', 'name' => 'Armed Forces Pacific'),
        array('abbrev' => 'CA', 'name' => 'California'),
        array('abbrev' => 'CO', 'name' => 'Colorado'),
        array('abbrev' => 'CT', 'name' => 'Connecticut'),
        array('abbrev' => 'DE', 'name' => 'Delaware'),
        array('abbrev' => 'DC', 'name' => 'District of Columbia'),
        array('abbrev' => 'FM', 'name' => 'Federated States Of Micronesia'),
        array('abbrev' => 'FL', 'name' => 'Florida'),
        array('abbrev' => 'GA', 'name' => 'Georgia'),
        array('abbrev' => 'GU', 'name' => 'Guam'),
        array('abbrev' => 'HI', 'name' => 'Hawaii'),
        array('abbrev' => 'ID', 'name' => 'Idaho'),
        array('abbrev' => 'IL', 'name' => 'Illinois'),
        array('abbrev' => 'IN', 'name' => 'Indiana'),
        array('abbrev' => 'IA', 'name' => 'Iowa'),
        array('abbrev' => 'KS', 'name' => 'Kansas'),
        array('abbrev' => 'KY', 'name' => 'Kentucky'),
        array('abbrev' => 'LA', 'name' => 'Louisiana'),
        array('abbrev' => 'ME', 'name' => 'Maine'),
        array('abbrev' => 'MH', 'name' => 'Marshall Islands'),
        array('abbrev' => 'MD', 'name' => 'Maryland'),
        array('abbrev' => 'MA', 'name' => 'Massachusetts'),
        array('abbrev' => 'MI', 'name' => 'Michigan'),
        array('abbrev' => 'MN', 'name' => 'Minnesota'),
        array('abbrev' => 'MS', 'name' => 'Mississippi'),
        array('abbrev' => 'MO', 'name' => 'Missouri'),
        array('abbrev' => 'MT', 'name' => 'Montana'),
        array('abbrev' => 'NE', 'name' => 'Nebraska'),
        array('abbrev' => 'NV', 'name' => 'Nevada'),
        array('abbrev' => 'NH', 'name' => 'New Hampshire'),
        array('abbrev' => 'NJ', 'name' => 'New Jersey'),
        array('abbrev' => 'NM', 'name' => 'New Mexico'),
        array('abbrev' => 'NY', 'name' => 'New York'),
        array('abbrev' => 'NC', 'name' => 'North Carolina'),
        array('abbrev' => 'ND', 'name' => 'North Dakota'),
        array('abbrev' => 'MP', 'name' => 'Northern Mariana Islands'),
        array('abbrev' => 'OH', 'name' => 'Ohio'),
        array('abbrev' => 'OK', 'name' => 'Oklahoma'),
        array('abbrev' => 'OR', 'name' => 'Oregon'),
        array('abbrev' => 'PW', 'name' => 'Palau'),
        array('abbrev' => 'PA', 'name' => 'Pennsylvania'),
        array('abbrev' => 'PR', 'name' => 'Puerto Rico'),
        array('abbrev' => 'RI', 'name' => 'Rhode Island'),
        array('abbrev' => 'SC', 'name' => 'South Carolina'),
        array('abbrev' => 'SD', 'name' => 'South Dakota'),
        array('abbrev' => 'TN', 'name' => 'Tennessee'),
        array('abbrev' => 'TX', 'name' => 'Texas'),
        array('abbrev' => 'UT', 'name' => 'Utah'),
        array('abbrev' => 'VT', 'name' => 'Vermont'),
        array('abbrev' => 'VI', 'name' => 'Virgin Islands'),
        array('abbrev' => 'VA', 'name' => 'Virginia'),
        array('abbrev' => 'WA', 'name' => 'Washington'),
        array('abbrev' => 'WV', 'name' => 'West Virginia'),
        array('abbrev' => 'WI', 'name' => 'Wisconsin'),
        array('abbrev' => 'WY', 'name' => 'Wyoming'),
    );
    return $states;
}
function getHearReasons() {
    $reasons = array(
        array('abbrev' => 'SE', 'name' => 'Search engine'),
        array('abbrev' => 'SM', 'name' => 'Social media'),
        array('abbrev' => 'AM', 'name' => 'Amazon'),
        array('abbrev' => 'RG', 'name' => 'Recieved as a gift'),
        array('abbrev' => 'WM', 'name' => 'Word of mouth'),
        array('abbrev' => 'OT', 'name' => 'Other'),
    );
    return $reasons;
}

function getActions() {
    $actions = array(
        array('abbrev' => 'Refund', 'action' => 'Refund'),
        array('abbrev' => 'Exchange', 'action' => 'Exchange'),
        array('abbrev' => 'Other', 'action' => 'Other')
    );
    return $actions;
}
function getReturnReasons() {
    $return_reasons = array(
        array('abbrev' => 'No longer needed', 'reason' => 'No longer needed'),
        array('abbrev' => 'Found Cheaper Elsewhere', 'reason' => 'Found Cheaper Elsewhere'),
        array('abbrev' => 'Incorrect Item Ordered', 'reason' => 'Incorrect Item Ordered'),
        array('abbrev' => 'Item arrived too late', 'reason' => 'Item arrived too late'),
        array('abbrev' => 'Did not approve purchase', 'reason' => 'Didn\'t approve purchase'),
        array('abbrev' => 'Product damaged, but shipping box ok', 'reason' => 'Product damaged, but shipping box ok'),
        array('abbrev' => 'Product and shipping box damaged', 'reason' => 'Product and shipping box damaged'),
        array('abbrev' => 'Not as described', 'reason' => 'Not as described'),
        array('abbrev' => 'Wrong Item Shipped', 'reason' => 'Wrong Item Shipped'),
        array('abbrev' => 'Missing Parts', 'reason' => 'Missing Parts'),
        array('abbrev' => 'Defective', 'reason' => 'Defective'),
        array('abbrev' => 'Other', 'reason' => 'Other'),
    );
    return $return_reasons;
}
