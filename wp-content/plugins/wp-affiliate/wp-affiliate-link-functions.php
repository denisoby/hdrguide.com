<?


add_action('wp_ajax_wp_affiliate_delete_link', 'wp_affiliate_delete_link' );

function wp_affiliate_delete_link()
{
	global $wpdb,$wp_affiliate_prefix;
	$table_name = $wpdb->prefix . $wp_affiliate_prefix."_links";
	
	$id = $_POST['link'];
	
	
	if($id == "")
		die("");
	
	if(is_numeric($id))
	{
	
			$sql = "DELETE FROM ".$table_name." WHERE id=".$id;
			$wpdb->query($sql);
			
			echo "document.getElementById('linkli".$id."').style.display=\"none\";";
	}
}

add_action('wp_ajax_wp_affiliate_add_link', 'wp_affiliate_add_link' );

function wp_affiliate_add_link()
{
global $wpdb,$wp_affiliate_prefix;
$table_name = $wpdb->prefix . $wp_affiliate_prefix."_links";


$link = $_POST['link'];
$text = $_POST['text'];
$category = $_POST['category'];

if($link == "" || $text == "")
die("document.getElementById('wp_affiliate_add_link_results').innerHTML = \"Link or text is missing from your affiliate link.\";");

$sql = "SELECT * FROM ".$table_name." WHERE link='".$wpdb->escape($link)."'";
$row = $wpdb->get_row($sql, OBJECT);



$sql = "INSERT INTO ".$table_name." (anchor_text,link,slug,category) VALUES('".$wpdb->escape($text)."','".$wpdb->escape($link)."','".$wpdb->escape(sanitize_title($text))."',".$wpdb->escape($category).")";
$wpdb->query($sql);


update_option('rewrite_rules',"");


$result_link = sanitize_title($text);

$new_link_li = str_replace("\r","",str_replace("\n","",str_replace("'","\'",get_link_li($wpdb->insert_id))));

echo "var navfil = '".$new_link_li."';";

echo "jQuery('#catli".$category.">ul').prepend(navfil);";

}
add_action('admin_print_scripts', 'wp_affiliate_js_admin_header' );

function wp_affiliate_js_admin_header() // this is a PHP function
{
  // use JavaScript SACK library for Ajax
  wp_print_scripts( array( 'sack' ));

  // Define custom JavaScript function
?>
<script type="text/javascript">
//<![CDATA[
function wp_affiliate_ajax_add_link( link, text, category )
{
   var mysack = new sack( 
       "<?php bloginfo( 'wpurl' ); ?>/wp-admin/admin-ajax.php" );    

  mysack.execute = 1;
  mysack.method = 'POST';
  mysack.setVar( "action", "wp_affiliate_add_link" );
  mysack.setVar( "link", link.value );
  mysack.setVar( "text", text.value );
  mysack.setVar( "category", category );
  mysack.encVar( "cookie", document.cookie, false );
  mysack.onError = function() { alert('Ajax error in adding affiliate link' )};
  mysack.runAJAX();

  return true;

} // end of JavaScript function
//]]>
</script>
<?php
} // end of PHP function myplugin_js_admin_header

