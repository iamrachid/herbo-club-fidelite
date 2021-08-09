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


get_header();
$level = 3;
$dashoffset = 55;

?>
<div class="container">
    <?php
    $lvl = 0;
    while ($lvl++ < 4) : ?>
        <div class="row">
            <div class="col">
                <div class="lv<?= $lvl ?>">
                    <div class="progress">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="-1 -1 34 34" class="progress-svg">
                            <circle cx="16" cy="16" r="15.9155" class="progress-bar" />
                            <circle cx="16" cy="16" r="15.9155" class="progress-load" style="stroke-dashoffset: <?= $dashoffset ?>;" />
                        </svg>
                        <svg class="progress-icon">
                            <use xlink:href="<?= plugins_url('img/sprite.svg#lv-' .  $lvl, dirname(__FILE__)) ?> "></use>
                        </svg>
                        <div class="progress-lvl">
                            <div class="progress-lvl__box">
                                <span class="progress-lvl__txt"><?= $lvl ?></span>
                                <svg class="progress-lvl__icon">
                                    <use xlink:href="<?= plugins_url('img/sprite.svg#crown', dirname(__FILE__)) ?>"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile ?>
</div>
<?php


get_footer();

function level_progress($level, $progress)
{
    $dashoffset = 100 - $progress;
}
