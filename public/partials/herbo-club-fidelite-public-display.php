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

$points = Herbo_Club_Fidelite_Public::get_points();
$total_points = $points['total_points'];
$user_id = get_current_user_id();
get_header();
list($current_level, $progress) = get_progress($total_points, $user_id);
// if($current_level != $points['last_level'])
// if ($current_level != 1) {
//     $level = 1;
// for($level = $points['last_level']; $level < $current_level;$level %4){
// for ($level = 1; $level < $current_level; $level  + 1) {

?>


<!-- <div class="modal open" id="modal-one">
        <div class="modal-bg modal-exit"></div>
        <div class="modal-container">
            <div class="column">
                <div class="gift">
                    <div class="lv-1">
                        <div class="progress">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="-1 -1 34 34" class="progress-svg">


                                <circle cx="16" cy="16" r="15.9155" class="progress-bar" />
                                <circle cx="16" cy="16" r="15.9155" class="progress-load" />
                            </svg>
                            <svg class="progress-icon">
                                <use xlink:href="sprite.svg#lv-1"></use>
                            </svg>
                            <div class="progress-lvl">
                                <div class="progress-lvl__box">
                                    <span class="progress-lvl__txt"><?= $level ?></span>
                                    <svg class="progress-lvl__icon">
                                        <use xlink:href="<?= plugins_url('img/sprite.svg#crown', dirname(__FILE__)) ?>"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dialog">
                    <h3>
                        FÉLICITATIONS ! VOUZ AVEC PASSÉ LE NIVEAU <?= $level ?>
                    </h3>
                    <span><?= levels_msg()[$level - 1] ?></span>
                </div>
                <button class="btn btn-blue modal-exit">
                    RÉCUPÉRER LA RÉCOMPENSE
                </button>
            </div>

            <button class="modal-close modal-exit">X</button>
        </div>
    </div> -->

<?php
// }
// }


?>
<div class="tabs">
    <div id="tab1" class="tab-content">


        <div class="levels">
            <?php
            $lvl = 0;
            $greyscale = '';
            while ($lvl++ < 4) :
                if ($lvl == $current_level)

                    $dashoffset = 100 - 100 * $progress;
                elseif ($lvl < $current_level)
                    $dashoffset = 0;
                else {
                    $dashoffset = 100;
                    $greyscale = 'greyscale';
                }
            ?>
                <div class="row <?= $greyscale ?>">
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
    </div>
</div>
<div style="width:100%;margin-top:3rem">
    <a href="./earn-points"><button>Gagner plus de points</button></a>
    <a href="./rewards">
        <button>Mes recompenses</button>
    </a>
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
    return array($level, $progress);
}
