<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       rachidox2k.wordpress.com/
 * @since      1.0.0
 *
 * @package    Herbo_Club_Fidelite
 * @subpackage Herbo_Club_Fidelite/public/partials
 */

if (!is_user_logged_in()) {
    auth_redirect();
}


get_header();
$user_id = get_current_user_id();
$points = Herbo_Club_Fidelite_Public::get_points();
$reward = $points['reward'];
$reward = sanitize_reward($reward);
$points['reward'] = $reward;
update_user_meta($user_id, 'herbo-club-points', $points);

for ($i = 1; $i <= 4; $i++) :
?>
    <div class="reward">
        <h2>Level <?= $i ?></h2>
        <code><?= $reward['lvl' . $i]['coupon'] . ' x ' . $reward['lvl' . $i]['amount'] ?></code>
    </div>
<?php
endfor;
get_footer();

function generate_code($length)
{
    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $chars_count = strlen($chars) - 1;
    $res = "";
    for ($i = 0; $i < $length; $i++) {
        $res .= $chars[mt_rand(0, $chars_count)];
    }
    return $res;
}

function generate_coupon($product_id)
{
    /**
     * Create a coupon programatically
     */
    $coupon_code = generate_code(8); // Code
    $amount = '10'; // Amount
    $discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product

    $coupon = array(
        'post_title' => $coupon_code,
        'post_content' => '',
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => 'shop_coupon'
    );

    $new_coupon_id = wp_insert_post($coupon);

    // Add meta
    update_post_meta($new_coupon_id, 'discount_type', $discount_type);
    update_post_meta($new_coupon_id, 'coupon_amount', $amount);
    update_post_meta($new_coupon_id, 'individual_use', 'no');
    update_post_meta($new_coupon_id, 'product_ids', '' . $product_id);
    // update_post_meta($new_coupon_id, 'exclude_product_ids', '');
    update_post_meta($new_coupon_id, 'usage_limit', '1');
    // update_post_meta($new_coupon_id, 'expiry_date', '');
    update_post_meta($new_coupon_id, 'apply_before_tax', 'yes');
    update_post_meta($new_coupon_id, 'free_shipping', 'no');

    return $coupon_code;
}

function sanitize_reward($reward)
{
    for ($i = 2; $i < 4; $i++) {
        $lvl = $reward['lvl' . $i];
        if ($lvl['amount'] > 0) {
            $coupon = new WC_Coupon($lvl['coupon']);
            $used = intval($coupon->usage_count);
            if ($used == 1) {
                $lvl['coupon'] = '';
                $lvl['amount']--;
                echo 'valid';
            }
        }

        if ($lvl['amount'] > 0 && $lvl['coupon'] == '') {
            $lvl['coupon'] = generate_coupon(42);
        }
        $reward['lvl' . $i] = $lvl;
    }
    return $reward;
}
