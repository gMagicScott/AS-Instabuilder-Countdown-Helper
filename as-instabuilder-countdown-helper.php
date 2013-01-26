<?php
/*
Plugin Name: AS Instabuilder Countdown Helper
Plugin URI: http://www.amazingsystem.com
Description: Wraps Instabuilder's countdown shortcode so a date can be "injected" from $_GET or $POST
Version: 0.2
Author: Scott Lesovic
Author Email: scott@guilefulmagic.com
License: GPLv2

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
            self::$instance->setup_globals();
            self::$instance->setup_actions();
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

    public function setup_actions() {
        add_action( 'init', array( $this, 'merge_request' ), 0 );
        add_action( 'init', array( $this, 'register_shortcode' ), 0 );
    }

    private function setup_globals() {
        $this->get  = ( isset( $_GET ) ) ? $_GET : array();
        $this->post = ( isset( $_POST ) ) ? $_POST : array();
    }

    public function merge_request() {
        $get = $this->get;
        $post = $this->post;

        $use_first = apply_filters( 'asibch_use_first', 'POST' );

        switch ( $use_first ) {
            case 'GET':
                $request = array_merge( $post, $get );
                break;
            case 'POST':
                $request = array_merge( $get, $post );
                break;
            default:
                $request = array();
                break;
        }

        $this->request = $request;
    }

    public function register_shortcode() {
        add_shortcode( 'as_countdown', array( &$this, 'shortcode_cb') );
    }

    public function shortcode_cb( $atts, $content = null, $tag = 'as_countdown' ) {
        $request = $this->request;

        extract( shortcode_atts( array(
            'field' => 'ndate',
            'style' => 'dark',
            'timezone' => '',
            'redirect' => '',
            'date_format' => 'm/d/Y',
            'date_offset' => false,
            'neg_date_offset' => false
            ), $atts ) );

        if ( isset( $request[$field] ) && !empty( $request[$field] ) ) {
            $date = DateTime::createFromFormat( $date_format, $request[$field] );
            if ( !$date ) {
                return ( current_user_can( 'edit_pages' ) ) ? '<strong class="error">Invalid Date Format for Countdown</strong>' : '' ;
            }

            if ( $date_offset ) {
                $offset_object = new DateInterval( $date_offset );
                if ( $neg_date_offset ) {
                    $offset_object->invert = 1;
                }
                $date->add( $offset_object );
            }
        } else {
            $date = new DateTime;
            $date->add(new DateInterval('P1D'));
        }

        $day = $date->format('d');
        $month = $date->format('m');
        $year = $date->format('Y');
        $hour = $date->format('H');
        $minute = $date->format('Y');
        $second = $date->format('Y');

        $ez_countdown = '[ez_countdown ';
        $ez_countdown .= 'day="' . $day . '" ';
        $ez_countdown .= 'month="' . $month . '" ';
        $ez_countdown .= 'year="' . $year . '" ';
        $ez_countdown .= 'hour="' . $hour . '" ';
        $ez_countdown .= 'min="' . $minute . '" ';
        $ez_countdown .= 'sec="' . $second . '" ';
        $ez_countdown .= 'style="' . $style . '" ';
        $ez_countdown .= 'timezone="' . $timezone . '" ';
        $ez_countdown .= 'redirect="' . $redirect . '" /]';

        return do_shortcode( $ez_countdown );
    }


}

/**
* The main function responsible for returning the AS_InstaBuilder_Countdown_Helper instance
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