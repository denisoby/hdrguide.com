<?
require_once("wp-affiliate-start.php");

add_action('admin_menu', 'wp_affiliate_add_pages');


function wp_affiliate_add_pages() {

    add_menu_page('WP-Affiliate', 'WP-Affiliate', 8, __FILE__, 'wp_affiliate_toplevel_page');

    add_submenu_page(__FILE__, 'Statistics', 'Statistics', 8, 'wpa-stats', 'wp_affiliate_statistics_page');

    add_submenu_page(__FILE__, 'Commision Junction', 'Commision Junction', 8, 'wpa-cj', 'wp_affiliate_cj_page');

    // Add a second submenu to the custom top-level menu:
    add_submenu_page(__FILE__, 'Options', 'Options', 8, 'wpa-opts', 'wp_affiliate_options_page');
}



function wp_affiliate_cj_page() {
	echo '<div class="wrap">';
    echo "<h2>Commision Junction</h2>";
    
    require_once("wp-affiliate-cj.php");
    
    
  echo '</div>';
}
function wp_affiliate_toplevel_page() {
	echo '<div class="wrap">';
    echo "<h2>WP-Affiliate</h2>";
    
    echo "<p>Welcome!</p>";
  echo '</div>';
}

function wp_affiliate_statistics_page() {
	global $wpdb,$wp_affiliate_prefix;
	
	echo '<div class="wrap">';
    echo "<h2>Statistics</h2>";
    
    $useStatistics = get_option( "useStatistics" );
    
    if($useStatistics)
    {
    	
    	$table_name3 = $wpdb->prefix . $wp_affiliate_prefix."_link_hits";
			$table_name = $wpdb->prefix . $wp_affiliate_prefix."_links";
			$table_name2 = $wpdb->prefix . $wp_affiliate_prefix."_categories";
			
			// NEEDS TO BE OPTION
    	$rows_per_page = 5;
    	
    	$pageno = 1;
			if(isset($_GET['pageno']) && is_numeric($_GET['pageno']))
			{
				$pageno = $_GET['pageno'];
			}    	
			
			$cur_url = get_bloginfo('wpurl').$_SERVER['REQUEST_URI'];
			
			$sql 			= "SELECT COUNT(*) FROM ".$table_name3;
			$num_rows	= $wpdb->get_var($sql);
			$lastpage = ceil($num_rows/$rows_per_page);
		
			
if ($pageno == 1) {
   echo " FIRST PREV ";
} else {
   echo " <a href='{$cur_url}&pageno=1'>FIRST</a> ";
   $prevpage = $pageno-1;
   echo " <a href='{$cur_url}&pageno=$prevpage'>PREV</a> ";
}

echo " ( Page $pageno of $lastpage ) ";

if ($pageno == $lastpage) {
   echo " NEXT LAST ";
} else {
   $nextpage = $pageno+1;
   echo " <a href='{$cur_url}&pageno=$nextpage'>NEXT</a> ";
   echo " <a href='{$cur_url}&pageno=$lastpage'>LAST</a> ";
}						
    	

    	
    	$sql 			= "SELECT link_id,referer,agent,ip,thestamp FROM ".$table_name3." ORDER BY id DESC LIMIT ".($pageno-1)*$rows_per_page.",".$rows_per_page;
    	$results	= $wpdb->get_results($sql);
    	
    	if($results)
    	{
?>
<h3>Clicks <? echo $rows_per_page; ?> At A Time</h3>
<table class="form-table">
	<th>Link Info</th><th>Referer</th><th>User Agent</th><th>IP</th><th>Timestamp</th>
<?

    		foreach($results as $result)
    		{
    			echo "<tr>";
    			
    			foreach($result as $key => $value)
    			{
    				if($key == "link_id")
    				{
    					$sql = "SELECT * FROM ".$table_name." WHERE id=".$value;
    					$link_result = $wpdb->get_row($sql,OBJECT);
    					
    					echo "<td>";
    					
    					foreach($link_result as $lkey => $lvalue)
    					{
    						echo "<b>".$lkey.":</b> <input type=\"text\" value=\"";
    						
    						if($lkey == "category")
		    				{
		    					$sql = "SELECT category FROM ".$table_name2." WHERE id=".$lvalue;		    			
		    					echo $wpdb->get_var($sql);
		    				}
		    				else
    							echo $lvalue;
    						
    						echo "\"><br />";
    					}
    					
    					echo "</td>";
    				}
    				else
    				{
	    				echo "<td>";
	    				
	    				if($key == "referer")
	    				{
	    					echo "<input type=\"text\" value=\"";
	    				}
	    				

	    					echo $value;
	    				
	    				if($key == "referer")
	    				{
	    					echo "\">";
	    				}	    				
	    				
	    				echo "</td>";
	    			}
    			}
    			
    			echo "</tr>";
    		}
?>
</table>
<br />
<?


if ($pageno == 1) {
   echo " FIRST PREV ";
} else {
   echo " <a href='{$cur_url}&pageno=1'>FIRST</a> ";
   $prevpage = $pageno-1;
   echo " <a href='{$cur_url}&pageno=$prevpage'>PREV</a> ";
}

echo " ( Page $pageno of $lastpage ) ";

if ($pageno == $lastpage) {
   echo " NEXT LAST ";
} else {
   $nextpage = $pageno+1;
   echo " <a href='{$cur_url}&pageno=$nextpage'>NEXT</a> ";
   echo " <a href='{$cur_url}&pageno=$lastpage'>LAST</a> ";
}		
 

    	}
    	else
    	{
    		echo "<p>No clicks have been recorded yet.</p>";
    	}
    	
    }
    else
    {
    	echo "<p>You must enable statistics in the options panel to record and analyze affiliate link clicks.</p>";
    }
    
    echo '</div>';
}


function wp_affiliate_options_page() {
	echo '<div class="wrap">';
    echo "<h2>Options</h2>";
 
$useStatistics = get_option( "useStatistics" );

 

if(isset($_POST['updateoption']))
{
	
	if(isset($_POST['useStatistics']))
		$useStatistics = 1;
	else
		$useStatistics = 0;
	
	update_option("useStatistics",$useStatistics);
}    


$wpa_cj_developer_key = get_option("wpa_cj_developer_key");
    
if(isset($_POST['updatecjoption']))
{
	if(isset($wpa_cj_developer_key))
	{
		$wpa_cj_developer_key = $_POST['wpa_cj_developer_key'];
		update_option("wpa_cj_developer_key",$wpa_cj_developer_key);
	}
}  

$wpa_cj_website_id = get_option("wpa_cj_website_id");
    
if(isset($_POST['updatecjoption']))
{
	if(isset($wpa_cj_website_id))
	{
		$wpa_cj_website_id = $_POST['wpa_cj_website_id'];
		update_option("wpa_cj_website_id",$wpa_cj_website_id);
	}
}        
   
?>
<form method="post">
<table class="form-table">
					<tr valign="top">
						<th align="left">Activate Statistics</th>
						<td><input type="checkbox" name="useStatistics" <? if($useStatistics==0) { ?> value="0" <? } else { ?>  value="1"  checked="checked" <? } ?> /><br />
						When you activate this option, affiliate link clicks will be tracked.</td>
					</tr>
				</table>
<div class="submit"><input type="submit" name="updateoption" value="Update &raquo;"/></div>
</form>

<form method="post">
<table class="form-table">
					<tr valign="top">
						<th align="left">CJ Website ID</th>
						<td><input type="text" name="wpa_cj_website_id" value="<? echo $wpa_cj_website_id; ?>" /><br />
						Don't have a CJ account? Get one here: <a href="https://signup.cj.com/member/publisherSignUp.do" target="cja">https://signup.cj.com/member/publisherSignUp.do</a>.</td>
					</tr>	
					<tr valign="top">
						<th align="left">CJ Developer Key</th>
						<td><input type="text" name="wpa_cj_developer_key" value="<? echo $wpa_cj_developer_key; ?>" /><br />
						Don't have a CJ developer key? Get one here: <a href="https://api.cj.com/signUp.do" target="cjd">https://api.cj.com/signUp.do</a>.</td>
					</tr>
				</table>
<div class="submit"><input type="submit" name="updatecjoption" value="Update &raquo;"/></div>
</form>							

<?
    
    
   echo '</div>';
}

