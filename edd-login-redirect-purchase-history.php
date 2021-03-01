<?php
defined( 'ABSPATH' ) or exit;

/**
 * Plugin Name: Easy Digital Downloads - Redirect Non-Admins to Purchase History
 * Description: Redirects non-administrator users to the Purchase History page after login
 * Author: Corey Salzano
 * License: GPLv2 or later
 */

function breakfast_redirect_to_purchase_history( $redirect_to, $requested_redirect_to, $user )
{
	if( ! function_exists( 'edd_get_option' ) )
	{
		//Easy Digital Downloads is not running
		return $redirect_to;
	}
	if( is_wp_error( $user ) || ( is_a( $user, 'WP_User' ) && $user->has_cap( 'administrator' ) ) )
	{
		return $redirect_to;
	}

	//The user is not an admin
	$purchase_history = edd_get_option( 'purchase_history_page', 0 );
	if ( ! empty( $purchase_history ) )
	{
		return get_permalink( $purchase_history );
	}

	return $redirect_to;
}
add_action( 'login_redirect', 'breakfast_redirect_to_purchase_history', 10, 3 );
