<?php
/**
 * @wordpress-plugin
 * Plugin Name:     Manage Categories
 * Plugin URI:        
 * Description:     This is a Manage Categories plugin for wordpress.
 * Version:         1.0.0
 * Author:          M.Asif
 * Author URI:      
 * License:         
 * License URI:      
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


register_activation_hook( __FILE__,"manage_categoriesTable");
function manage_categoriesTable() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . "categories";
	$sql = "CREATE TABLE `$table_name` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`name` varchar(220) DEFAULT NULL,
	`url` varchar(220) DEFAULT NULL,
	PRIMARY KEY(id)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;
	";
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		require_once(ABSPATH . "wp-admin/includes/upgrade.php");
		dbDelta($sql);
	}
}


add_action('admin_menu','addAdminPageContent');


function addAdminPageContent() {
	add_menu_page('Categories','Categories','manage_options',__FILE__,'manage_categoriesAdminPage','dashicons-wordpress');
}

function manage_categoriesAdminPage() {
	global $wpdb;
	$table_name = $wpdb->prefix . "categories";
	if(isset($_POST["newsubmit"])) {
		$user_id = get_current_user_id();
		$name = $_POST["newname"];
		$url = $_POST["newurl"];
		$wpdb->query("INSERT INTO $table_name(user_id,name,url) VALUES('$user_id','$name','$url')");
		echo "<script>location.replace('admin.php?page=manage_categories%2Findex.php');</script>";
	}
	if(isset($_POST["uptsubmit"])) {
		$id = $_POST["uptid"];
		$name = $_POST["uptname"];
		$url = $_POST["upturl"];
		
		$wpdb->query("UPDATE $table_name SET name='$name', url='$url' WHERE id='$id'");
		echo "<script>location.replace('admin.php?page=manage_categories%2Findex.php');</script>";
	}
	if(isset($_GET["del"])) {
		$del_id = $_GET["del"];
		$wpdb->query("DELETE FROM $table_name WHERE  id='$del_id'");
		echo "<script>location.replace('admin.php?page=manage_categories%2Findex.php');</script>";
	}
	?>
	<div class="wrap">
					
	
		
		
<?php ?>
		<h2>Manage Categories</h2>
		<table class="wp-list-table widefat striped">
			<thead>
				<tr>
					<th width="25%">ID</th>
					<th width="25%">Category Name</th>
					<th width="25%">Url</th>
					<th width="25%">Actions</th>
				</tr>
			</thead>
			<tbody>
				<form action="" method="post">
					<tr>
						<td><input type="text" value="AUTO_GENERATED" disabled></td>
						<td><input type="text" id="name" name="newname"></td>
						<td><input type="text" id="url" name="newurl"></td>
						<td><button class="btn btn-primary" id="newsubmit" name="newsubmit" type="submit">INSERT</button></td>
					</tr>
				</form>

				<?php
					$result = $wpdb->get_results("SELECT * FROM $table_name order by id desc");
					foreach ($result as $print) {
						echo "
							<tr>
								<td width='25%'>$print->id</td>
								<td width='25%'>$print->name</td>
								<td width='25%'>$print->url</td>
								<td width='25%'><a href='admin.php?page=manage_categories%2Findex.php&upt=$print->id'><button type='button'>UPDATE</button></a>
								<a href='admin.php?page=manage_categories%2Findex.php&del=$print->id'><button type='button'>DELETE</button></a></td>
							</tr>
						";
					}
					
					
					
					
					
					
				?>
			</tbody>	
		</table><br><br>
		<?php
			if(isset($_GET["upt"])) {
				$upt_id = $_GET["upt"];
				$result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$upt_id'");
				foreach($result as $print) {
					$name = $print->name;
				}
				echo "
				<table class='wp-list-table widefat striped'>
					<thead>
						<tr>
							<th width='25%'>ID</th>
							<th width='25%'>Category Name</th>
							<th width='25%'>Actions</th>
						</tr>
					</thead>
					<tbody>
						<form action='' method='post'>
							<tr>
								<td width='25%'>
								$print->id 
								<input type='hidden' id='uptid' name='uptid' value='$print->id'>
								</td>
								<td width='25%'>
								<input type='text' id='uptname' name='uptname' value='$print->name'>
								</td>
								<td width='25%'>
								<input type='text' id='upturl' name='upturl' value='$print->url'>
								</td>
								<td width='25%'>
								<button id='uptsubmit' name='uptsubmit' type='submit'>UPDATE</button> 
								<a href='admin.php?page=manage_categories%2Findex.php'>
								<button type='button'>CANCEL</button>
								</a>
								</td>
							</tr>
						</form>
					</tbody>
				</table>";
			}
		?>
	</div>
	
	<?php
	
	}

?>



	


	
	
	
