<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
* HybridAuth 
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
Instagram: Yuichi1292
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

$config =
	array(
		'base_url' => 'session/login_endpoint',
		"providers" => array (
			"Twitter" => array (
				"enabled" => true,
				"keys"    => array ( "key" => "Mm28zn1lBLZM4LEi0WWX2649Q", "secret" => "4dBjuMmpLKkbgw6RGQmHZ0sYqPgGcO0L8LuB1pIDcsjCwrV0qO" )
			),
			"Facebook" => array (
		          "enabled" => true,
		          "keys"    => array ( "id" => "1842583669294010", "secret" => "b63eb9e4e5ab4777f658c060c6e782e4" ),
		          "scope"   => "email, public_profile",
		          "display" => "popup"
		    ),
		    "Google" => array (
		          "enabled" => true,
		          "keys"    => array ( "id" => "892926831483-q3vd9k3dq2kuodfogeeu49f0gj5edsop.apps.googleusercontent.com", "secret" => "FmVDotWHvAjj-tjQrCxwQkwl" ),
		    ),
		    "LinkedIn" => array (
	            "enabled" => true,
	            "keys"    => array ( "key" => "77xxjdow9t1nx1", "secret" => "dg2i2dugkurmLYAd"),
	            "scope" => 'r_basicprofile, r_emailaddress'
	        ),
	        "Instagram" => array (
	            "enabled" => true,
	            "keys"    => array ( "id" => "fff0bd6e9ae74a039c9f076256789118", "secret" => "69611ac2793845afbf1a432bf767b650")
	        )
		),
		"debug_mode" => false,
		"debug_file" => APPPATH.'/logs/hybridauth.log',
	);
