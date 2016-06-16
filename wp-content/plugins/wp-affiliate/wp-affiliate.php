<?
/*
Plugin Name: WP-Affiliate
Plugin URI: http://www.seoadventures.com/wp-affiliate
Description: Easy affiliate link masking and more. <br /><br /> Now Featuring:<br /> Commission Junction Search Capabilities!<br /> Click Tracking!<br /><br /><a href="http://downloads.wordpress.org/plugin/wp-affiliate.zip">Download It Now!</a>
Version: 0.6
Author: jstroh
Author URI: http://www.seoadventures.com/
*/


/*
Copyright (C) 2008 seoadventures.com (jstroh AT gmail DOT com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/ 
 
 
/** 
 * This file is full of init functionality
 * and globals.
 *
 */
 
require_once("wp-affiliate-start.php");




function wp_affiliate_post_menu()
{
global $wpdb,$wp_affiliate_prefix;

$category_form = "
<h2>Add Base Category</h2>
<div id=\"wp_affiliate_add_category_results\" style=\"color:red;\"></div>
<table>
<tr><td align=\"right\">
<b>Category Name:</b>
</td><td>
<input type=\"text\" name=\"wp_affiliate_add_new_category\">
</td></tr></table>
<input type=\"hidden\" name=\"wp_affiliate_category_parent\" value=\"0\">
<input type=\"button\" value=\"Add Base Category\" onclick=\"wp_affiliate_ajax_add_category(this.form.wp_affiliate_add_new_category,this.form.wp_affiliate_category_parent);\" >
";

echo $category_form;

echo "
<h2>Categorical Listing Of Links</h2>
<div id=\"wp_affiliate_category_list\">
";

$category_list = get_category_list();

if($category_list)
	echo get_category_list();
else
	echo "<ul id=\"wpanav\"><ul>";//"No categories! Add at least one in order to add links!";

echo "
</div>";

}





function wp_affiliate_create_menus()
{
add_meta_box("wp_affiliate_link_div","WP-Affiliate Links", "wp_affiliate_post_menu","post","normal");

}


if (is_admin())
    add_action('admin_menu', 'wp_affiliate_create_menus');


/** 
 * All functionality for adding a category.
 *
 */
require_once("wp-affiliate-category-functions.php");

/** 
 * All functionality for adding a link.
 *
 */
require_once("wp-affiliate-link-functions.php");



function wp_affiliate_rewrite_rules($rules)
{
  global $wp_rewrite,$wpdb,$wp_affiliate_prefix;

	$table_name = $wpdb->prefix . $wp_affiliate_prefix."_links";

	$results	=	$wpdb->get_results("SELECT * FROM ".$table_name,OBJECT);
	
	$new_rules=Array();
	
	if($results)
	{
		
		foreach($results as $result){
						$the_slug = substr(get_category_slug($result->category)."/".$result->slug,1);

		        $new_rules[$the_slug."$"]='index.php?wpaaction=wp_affiliate_redirect&wpaslug='.urlencode($result->slug);
		}
    
    $rules=$new_rules + $rules;
    
    
	}
	
  return $rules;
}

$wp_affiliate_query_vars=Array('wpaaction','wpaslug');
function wp_affiliate_add_query_vars($query_vars)
{
        global $wp_affiliate_query_vars;
        
        return array_merge($query_vars,$wp_affiliate_query_vars);
}

function wp_affiliate_parse_request($req)
{
	global $wp_affiliate_query_vars,$wpdb,$wp_affiliate_prefix, $_SERVER;
	
	$table_name = $wpdb->prefix . $wp_affiliate_prefix."_links";
	$table_name2 = $wpdb->prefix . $wp_affiliate_prefix."_link_hits";
        
  foreach($wp_affiliate_query_vars as $qv){
  	if(isset($req->query_vars[$qv]))
  	{
    	$_GET[$qv]=$req->query_vars[$qv];
    }
  }
  
	
	if($_GET['wpaaction']=='wp_affiliate_redirect'){
		
		$sql	=	"select * from ".$table_name." where slug='".$_GET['wpaslug']."'";
		$row	=	$wpdb->get_row($sql,OBJECT);
		
		if($row)
		{
			if(get_option( "useStatistics" ))
			{

				// give it a hit
				$referer = wp_get_referer();
				$agent = $_SERVER['HTTP_USER_AGENT'];
				$ip = $_SERVER['REMOTE_ADDR'];
	
				$sql = "INSERT INTO ".$table_name2." (link_id,referer,agent,ip,thestamp) VALUES(".$row->id.",'".$wpdb->escape($referer)."','".$wpdb->escape($agent)."','".$wpdb->escape($ip)."',NOW())";

				$wpdb->query($sql);
			}
			
			header("Location:".$row->link);
			exit(0);
		}
	}
}

function wp_affiliate_init()
{

		global $wp_rewrite;
 	 if (isset($wp_rewrite) && $wp_rewrite->using_permalinks()) {

    add_filter('rewrite_rules_array', 'wp_affiliate_rewrite_rules');
		add_filter('query_vars','wp_affiliate_add_query_vars');
		add_action('parse_request','wp_affiliate_parse_request');
		
		
		
	}
}
add_action('init','wp_affiliate_init');


/** 
 * All functionality for admin.
 *
 */
require_once("wp-affiliate-admin-functions.php");


/** 
 * All functionality for installation.
 *
 */
require_once("wp-affiliate-install-functions.php");
register_activation_hook(__FILE__,'wp_affiliate_install');
?>
