<?php
 
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	exit();
register_uninstall_hook( __FILE__, 'manage_categories_uninstall_function' );
function manage_categories_uninstall_function()
{
  // code to run on plugin uninstall

  // delete the registered options
  delete_option('manage_categories');
}	

?>