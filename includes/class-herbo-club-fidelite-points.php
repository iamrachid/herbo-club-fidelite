<?php

/**
 * The file that defines the logic of the plugin
 *
 *
 * @link       rachidox2k.wordpress.com/
 * @since      1.0.0
 *
 * @package    Herbo_Club_Fidelite_Points
 * @subpackage Herbo_Club_Fidelite/includes
 */

/**
 * The Points class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 *
 * @since      1.0.0
 * @package    Herbo_Club_Fidelite_Points
 * @subpackage Herbo_Club_Fidelite/includes
 * @author     Rachid El Aissaoui <ra.elaissaoui@gmail.com>
 */
class Herbo_Club_Fidelite_Points
{
    /**
     * The points of the user.
     *
     * @since    1.0.0
     * @access   private
     * @var      int    $points    The points of the user.
     */
    private $points;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      int    $points    The points of the user.
     */
    public function __construct($points)
    {
        if (isset($points))
            $this->points = $points;
        else
            $this->points = 0;
    }

    public function get_points()
    {
        return $this->points;
    }

    public function add_points($points)
    {
        $this->points += $points;
    }
}
