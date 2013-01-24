<?php
/*
Plugin Name: AS Instabuilder Countdown Helper
Plugin URI: http://www.amazingsystem.com
Description: Wraps Instabuilder's countdown shortcode so a date can be "injected" from $_GET or $POST
Version: 0.1
Author: Scott Lesovic
Author Email: scott@guilefulmagic.com
License:

  Copyright 2013 Scott Lesovic (scott@guilefulmagic.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
* Primary Plugin Class
*/
class AS_InstaBuilder_Countdown_Helper {
    /**
    * Holds the single-running plugin object
    */
    private static $instance = false;

    /**
    * Static bootstrapping init method
    *
    * @since 0.1
    */
    public static function &init() {
        if ( ! self::$instance ) {
            self::$instance = new self();
            self::$instance->constants();
            self::$instance->setup_globals();
            self::$instance->includes();
            self::$instance->setup_actions();
            self::$instance->load_components();
        }

        return self::$instance;
    }

    /**
    * Private constructor. Intentionally left empty.
    *
    * Instantiate this class by using {@link asibch()} or {@link AS_InstaBuilder_Countdown_Helper::init()}.
    *
    * @since 0.1
    */
    private function __construct() {}


}

/**
* The main function responsible for returning the Commons In A Box instance
* to functions everywhere.
*
* Use this function like you would a global variable, except without needing
* to declare the global.
*
* Example: <?php $asibch = asibch(); ?>
*
* @return AS_InstaBuilder_Countdown_Helper
*/
function asibch() {
    return AS_InstaBuilder_Countdown_Helper::init();
}

// Vroom!
asibch();