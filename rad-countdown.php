<?php
/**
 * Plugin Name: RAD Countdown 
 * Description: Simple countdown plugin
 * Version: 0.1
 * Author: raccoonandduck
 * Author URI: raccoonandduck.site
 */


$rad_countdown_table = $wpdb->prefix."rad_countdown_list";

/* Plugin work with database */
/*
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
$rad_countdown_table_query = "CREATE TABLE {$rad_countdown_table}(
	id INT NOT NULL AUTO_INCREMENT,
	end DATETIME NOT NULL,
	data TEXT,
	PRIMARY KEY (id)
)";
maybe_create_table($rad_countdown_table, $rad_countdown_table_query);
*/


//Strange problem with WP_List_Table
if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/screen.php' );
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}



add_action('admin_menu', function(){
	add_menu_page("The list of countdowns", "Countdowns", 'manage_options', 'countdowns', 'countdowns_work', 'dashicons-clock', 16);
	add_submenu_page("countdowns", "Create new countdown", "New Countdown", "manage_options", "countdown_new", 'countdown_new_work', 1);
});


//Show the list of exists countdown
function countdowns_work(){
	$rad_countdowns = new Rad_Countdowns_List();
	echo '<h1>The List of Countdowns</h1><br>';
	echo '<form method="GET">';
	$rad_countdowns->prepare_items();
	$rad_countdowns->display();
	echo '</form>';
}

//Create new countdown
function countdown_new_work(){
	global $wpdb, $rad_countdown_table;

	$update_mode = false;
	if(isset($_GET['id'])){
		$update_mode = true;
		$countdown_id = intval($_GET['id']);
	}

	if($_POST['action'] == 'create-rad-countdown'){
		//Save data for new countdown
		$full_date_end = $_POST['date-end'].' '.$_POST['time-end'].':00';


		if($update_mode){
			$wpdb->update($rad_countdown_table,
				array(
					'end' => $full_date_end,
					'data' => "test" 
				),
				array("id" => $countdown_id),
				array('%s', '%s'),
				array('%d')
			);
		}
		else{
			$wpdb->insert($rad_countdown_table,array(
				"end" => $full_date_end,
				"data" => "test"
			),
			array('%s', '%s'));
		}
	}


	if($update_mode){
		//Show existed countdown
		$countdown_data = $wpdb->get_row("SELECT end, data FROM {$rad_countdown_table} WHERE id = {$countdown_id}", ARRAY_A);
	}


	require dirname( __FILE__ ) . '/templates/constructor.php';
}



add_shortcode('rad-countdown', function($arg){
	global $wpdb, $rad_countdown_table;

	$id = intval($arg['id']);
	$countdown_params = $wpdb->get_row("SELECT end,data FROM {$rad_countdown_table} WHERE id={$id}", ARRAY_A);

	require dirname( __FILE__ ) . '/timer-generator.php';
});


//!DSGN потом как-нибудь получше подключать, да и вообще jquery неплохо было бы заменить
add_action( 'wp_enqueue_scripts', function(){
	wp_enqueue_script('jquery', plugins_url('assets/jquery-3.6.0.min.js', __FILE__));
});







class Rad_Countdowns_List extends WP_List_Table{
	function get_columns(){
	  $columns = array(
	  	'id' => "Countdown ID",
	  	'end' => "Finish",
	  	'shortcode' => "Shortcode",
	  	'view' => 'View',
	  	'delete' => 'Delete'
	  );
	  return $columns;
	}

	function prepare_items() {
		global $wpdb, $rad_countdown_table;
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = array();
		$this->_column_headers = array($columns, $hidden, $sortable);

		$countdowns_data = $wpdb->get_results("
			SELECT id, end, data FROM {$rad_countdown_table} ORDER BY id
		", 'ARRAY_A');

		$this->items = $countdowns_data;
	}

	function column_default($item, $column_name ){
		if($column_name == 'shortcode'){
			return "[rad-countdown id={$item['id']}]";
		}

		return $item[$column_name];	
	}


	function column_view($item){
		return "<a href='".admin_url("/admin.php?page=countdown_new&id={$item['id']}")."'>View</a>";
	}

	function column_delete( $item ){
		return "Delete";
	}
	
}





;?>








