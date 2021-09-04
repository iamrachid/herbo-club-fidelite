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

$user_id = get_current_user_id();
$userdata = get_userdata($user_id);

$points = Herbo_Club_Fidelite_Public::get_points();
$total_points = $points['total_points'];
get_header();
list($current_level, $progress, $remaining) = get_progress($total_points, $user_id);
?>


<div class="user">

    <img class="avatar" src="<?= get_avatar_url($user_id) ? get_avatar_url($user_id) : plugins_url('img/avatar.png', dirname(__FILE__)) ?>">
    <div class="points-box">
        <div class="points-box-upper">
            <div class="points-message">
                <span>Bonjour <?= $userdata->user_login ?></span>
                <span><?= $remaining ?> points pour terminer le niveau <?= $current_level ?></span>
            </div>
            <div class="points">
                <span class="points-value"><?= $total_points ?></span>
                <svg class="coin">
                    <use href="<?= plugins_url('img/sprite.svg#', dirname(__FILE__)) ?>coin"></use>
                </svg>

            </div>

        </div>
        <div class="progress-bar">
            <progress value="<?= $progress ?>" max="1">
        </div>
    </div>

</div>
<div class="actions-box">
    <div class="action">
        <div class="action-left">

            <svg class="action-icon">
                <use href="<?= plugins_url('img/sprite.svg#', dirname(__FILE__)) ?>networking"></use>
            </svg>
            <span class="action-title">Creer un compte</span>
        </div>
        <div class="action-right">

            <div class="points action-points">
                <span class="points-value"><?= get_option('herbo_club_fidelite_n_account') ?></span>
                <svg class="coin">
                    <use href="<?= plugins_url('img/sprite.svg#', dirname(__FILE__)) ?>coin"></use>
                </svg>
            </div>
            <div class="action-claimed">collecté</div>
        </div>
    </div>
    <div class="action">
        <div class="action-left">

            <svg class="action-icon">
                <use href="<?= plugins_url('img/sprite.svg#', dirname(__FILE__)) ?>facebook"></use>
            </svg>
            <span class="action-title">Aimer notre page Facebook</span>
        </div>
        <div class="action-right">

            <div class="points action-points">
                <span class="points-value"><?= get_option('herbo_club_fidelite_f_like') ?></span>
                <svg class="coin">
                    <use href="<?= plugins_url('img/sprite.svg#', dirname(__FILE__)) ?>coin"></use>
                </svg>
            </div>
            <?php if ($points['f_like']['earned']) : ?>
                <div class="action-claimed">collecté</div>
            <?php else : ?>
                <button class="action-button" data-action="f_like">activer</button>
            <?php endif ?>
        </div>
    </div>
    <div class="action">
        <div class="action-left">

            <svg class="action-icon">
                <use href="<?= plugins_url('img/sprite.svg#', dirname(__FILE__)) ?>comment"></use>
            </svg>
            <span class="action-title">Ecrire un commentaire sur un produit </span>
        </div>
        <div class="action-right">

            <div class="points action-points">
                <span class="points-value">x<?= get_option('herbo_club_fidelite_c_product') ?></span>
                <svg class="coin">
                    <use href="<?= plugins_url('img/sprite.svg#', dirname(__FILE__)) ?>coin"></use>
                </svg>
            </div>
            <a class="action-button" data-action="c_produit" target="_blank" href="<?= get_permalink(woocommerce_get_page_id('shop')) ?>">activer</a>
        </div>
    </div>
    <div class="action">
        <div class="action-left">

            <svg class="action-icon">
                <use href="<?= plugins_url('img/sprite.svg#', dirname(__FILE__)) ?>instagram"></use>
            </svg>
            <span class="action-title">Nous suivre sur Instagram</span>
        </div>
        <div class="action-right">

            <div class="points action-points">
                <span class="points-value"><?= get_option('herbo_club_fidelite_i_follow') ?></span>
                <svg class="coin">
                    <use href="<?= plugins_url('img/sprite.svg#', dirname(__FILE__)) ?>coin"></use>
                </svg>
            </div>
            <?php if ($points['i_follow']['earned']) : ?>
                <div class="action-claimed">collecté</div>
            <?php else : ?>
                <button class="action-button" data-action="i_follow">activer</button>
            <?php endif ?>

        </div>
    </div>

    <div class="action">
        <div class="action-left">

            <svg class="action-icon">
                <use href="<?= plugins_url('img/sprite.svg#', dirname(__FILE__)) ?>connection"></use>
            </svg>
            <span class="action-title">Parrainage</span>
        </div>
        <div class="action-right">

            <div class="points action-points">
                <span class="points-value"><?= get_option('herbo_club_fidelite_referral') ?></span>
                <svg class="coin">
                    <use href="<?= plugins_url('img/sprite.svg#', dirname(__FILE__)) ?>coin"></use>
                </svg>
            </div>
            <input type="hidden" id="ref-copy" value="<?= get_permalink(get_option('woocommerce_myaccount_page_id')) . '?ref=' . $user_id ?>">
            <button class="action-button" data-action="referral">activer</button>
        </div>
    </div>

    <div class="action">
        <div class="action-left">
            <svg class="action-icon">
                <use href="<?= plugins_url('img/sprite.svg#', dirname(__FILE__)) ?>google-plus"></use>
            </svg>
            <span class="action-title">Noter 5 ***** sur notre page Google Review</span>
        </div>
        <div class="action-right">

            <div class="points action-points">
                <span class="points-value"><?= get_option('herbo_club_fidelite_g_review') ?></span>
                <svg class="coin">
                    <use href="<?= plugins_url('img/sprite.svg#', dirname(__FILE__)) ?>coin"></use>
                </svg>
            </div>
            <?php if ($points['g_review']['earned']) : ?>
                <div class="action-claimed">collecté</div>
            <?php else : ?>
                <button class="action-button" data-action="g_review" disabled>activer</button>
            <?php endif ?>
        </div>
    </div>
    <div class="action">
        <div class="action-left">

            <svg class="action-icon">
                <use href="<?= plugins_url('img/sprite.svg#', dirname(__FILE__)) ?>sharing"></use>
            </svg>
            <span class="action-title">Partager notre site Web sur Facebook</span>
        </div>
        <div class="action-right">

            <div class="points action-points">
                <span class="points-value"><?= get_option('herbo_club_fidelite_f_share') ?></span>
                <svg class="coin">
                    <use href="<?= plugins_url('img/sprite.svg#', dirname(__FILE__)) ?>coin"></use>
                </svg>
            </div>
            <?php if ($points['f_share']['earned']) : ?>
                <div class="action-claimed">collecté</div>
            <?php else : ?>
                <button class="action-button" data-action="f_share">activer</button>
            <?php endif ?>
        </div>
    </div>
    <div class="action">
        <div class="action-left">

            <svg class="action-icon">
                <use href="<?= plugins_url('img/sprite.svg#', dirname(__FILE__)) ?>cake"></use>
            </svg>
            <span class="action-title">Anniversaire</span>
        </div>
        <div class="action-right">

            <div class="points action-points">
                <span class="points-value"><?= get_option('herbo_club_fidelite_birthay') ?></span>
                <svg class="coin">
                    <use href="<?= plugins_url('img/sprite.svg#', dirname(__FILE__)) ?>coin"></use>
                </svg>
            </div>
            <?php if ($points['birthay']['earned']) : ?>
                <div class="action-claimed">collecté</div>
            <?php else : ?>
                <button class="action-button" data-action="birthday" disabled>activer</button>
            <?php endif ?>
        </div>
    </div>
</div>

<?php
get_footer();
function levels_max()
{
    $levels_max = array(1000, 5000, 10000, 15000);

    return $levels_max;
}
function levels_msg()
{
    $levels_msg = array(
        'Vous avez gagné une séance gratuite : 15 minutes de conseils de nutritions personnalisés',
        'Vous avez gagné une tisane bio gratuite',
        'Vous avez gagné une réduction de 20% sur votre prochain achat',
        'Vous avez gagné un mélange personnalisé de plantes médicinales'
    );
    return $levels_msg;
}
function get_progress($points, $user_id)
{
    if ($points > 15000)
        update_user_meta($user_id, 'hero-club-points', $points % 1500);

    $levels_max = levels_max();
    $level = 0;
    while ($points > $levels_max[$level++]);
    if ($level > 1) {
        $progress = $points - $levels_max[$level - 2];
        $diff = $levels_max[$level - 1] - $levels_max[$level - 2];
        $progress /= $diff;
    } else
        $progress = $points / $levels_max[0];
    $remaining = $levels_max[$level - 1] - $points;
    return array($level, $progress, $remaining);
}
