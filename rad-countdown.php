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



add_action('admin_menu', function(){
	add_menu_page("The list of countdowns", "Countdowns", 'manage_options', 'countdowns', 'countdowns_work', 'dashicons-clock', 16);
	add_submenu_page("countdowns", "Create new countdown", "New Countdown", "manage_options", "countdown_new", 'countdown_new_work', 1);
});


//Show the list of exists countdown
function countdowns_work(){

}

//Create new countdown
function countdown_new_work(){
	global $wpdb, $rad_countdown_table;

	if($_POST['action'] == 'create-rad-countdown'){
		//Save data for new countdown

		$full_date_end = $_POST['date-end'].' '.$_POST['time-end'].':00';

		$wpdb->insert($rad_countdown_table,array(
			"end" => $full_date_end,
			"data" => "test"
		),
		array('%s', '%s'));
	}
	require dirname( __FILE__ ) . '/templates/constructor.php';
}



add_shortcode('rad-countdown', function($arg){
	global $wpdb, $rad_countdown_table;
	$id = intval($arg['id']);

	$countdown_params = $wpdb->get_row("SELECT end,data FROM {$rad_countdown_table} WHERE id={$id}", ARRAY_A);

	echo $countdown_params['end'];
});



/* Регистрация в меню */

/*
	Фактически будет 2 страницы 
		1. Список таймеров (Дата, ссылка view)
		2. Отдельная страница



*/












;?>








