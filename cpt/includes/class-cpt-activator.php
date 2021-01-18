<?php
/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Cpt
 * @subpackage Cpt/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cpt
 * @subpackage Cpt/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Cpt_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function cpt_activate() {
		$page_title = 'Form Page';
		$page_check = get_page_by_title( $page_title );
		$new_page   = array(
			'post_title'  => $page_title,
			'post_status' => 'publish',
			'post_type'   => 'page',
		);
		if ( ! isset( $page_check->ID ) ) {
			$page_id = wp_insert_post( $new_page );

		}

		$page_title = 'People List';
		$page_check = get_page_by_title( $page_title );
		$new_page   = array(
			'post_title'  => $page_title,
			'post_status' => 'publish',
			'post_type'   => 'page',
		);
		if ( ! isset( $page_check->ID ) ) {
			$page_id = wp_insert_post( $new_page );

		}

	}

}
