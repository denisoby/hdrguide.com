<?

/**
 * wp_affiliate_install() - run upon activation
 * 
 * Creates/Updates database and options.
 *
 */
function wp_affiliate_install()
{
global $wpdb;

$wp_affiliate_prefix = "wp_affiliate";

$table_name = $wpdb->prefix . $wp_affiliate_prefix."_links";
$table_name2 = $wpdb->prefix . $wp_affiliate_prefix."_categories";
$table_name3 = $wpdb->prefix . $wp_affiliate_prefix."_link_hits";


$sql = "CREATE TABLE `".$table_name."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`anchor_text` VARCHAR( 255 ) NOT NULL ,
`link` TEXT NOT NULL ,
`slug` VARCHAR( 255 ) NOT NULL ,
`category` INT( 11 ) NOT NULL ,
INDEX ( `anchor_text` )
);";

$sql2 = "CREATE TABLE `".$table_name2."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`category` VARCHAR( 255 ) NOT NULL ,
`parent` INT( 11 ) NOT NULL ,
INDEX ( `parent` )
);";

$sql3 = "CREATE TABLE `".$table_name3."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`link_id` INT( 11 ) NOT NULL ,
`referer` TEXT NOT NULL ,
`agent` TEXT NOT NULL ,
`ip` VARCHAR(14) NOT NULL ,
`thestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
INDEX ( `link_id` , `thestamp` )
);";


require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);
dbDelta($sql2);
dbDelta($sql3);


update_option('rewrite_rules',"");	

update_option("useStatistics",0);

}


?>
