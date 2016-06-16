<?

function get_category_slug($id)
{
	global $wpdb,$wp_affiliate_prefix;
	
	if(!$id)
		return;

	$table_name 	= $wpdb->prefix . $wp_affiliate_prefix."_categories";
	
	$row = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE id=".$id, OBJECT);
	
	return get_category_slug($row->parent)."/".sanitize_title($row->category);
}

function get_link_li($id)
{
	global $wpdb,$wp_affiliate_prefix;

	$table_name = $wpdb->prefix . $wp_affiliate_prefix."_links";	
	
	$result = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE id=".$id, OBJECT);
	$clean_cat = get_category_slug($result->category);
	$clean_link = get_bloginfo('wpurl')."".$clean_cat."/".$result->slug;	
	$send_to_editor = "send_to_editor(\"<a href=".$clean_link." target=_blank>".$result->anchor_text."</a>\");return false;";
	
	return "<li id=\"linkli".$result->id."\"><b>Real Link:</b> ".$result->link." <br /><b>Link:</b> ".get_bloginfo('wpurl')."".$clean_cat."/".$result->slug." <br /> <b>Anchor Text:</b> ".$result->anchor_text." <br /> <a href=\"#\" onclick='".$send_to_editor."'>Send Link To Editor</a> <a href=\"#\" onclick='copyToClipboard	(\"".$clean_link."\");return false;'>Copy Link To Clipboard</a> (<a href=\"#\" onclick=\"wp_affiliate_ajax_delete_link(".$result->id.");return false;\">Delete Link</a>) </li>\n";
}

function get_link_list($id,$catname)
{

global $wpdb,$wp_affiliate_prefix;

$table_name = $wpdb->prefix . $wp_affiliate_prefix."_links";

$results = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE category=".$id);

$link_list = "<ul>\n<li></li>\n";
foreach($results as $result)
{
	$clean_cat = get_category_slug($result->category);
	$clean_link = get_bloginfo('wpurl')."".$clean_cat."/".$result->slug;
	$send_to_editor = "send_to_editor(\"<a href=".$clean_link." target=_blank>".$result->anchor_text."</a>\");return false;";
	
	$link_list .= "<li id=\"linkli".$result->id."\"><b>Real Link:</b> ".$result->link." <br /><b>Link:</b> ".get_bloginfo('wpurl')."".$clean_cat."/".$result->slug." <br /> <b>Anchor Text:</b> ".$result->anchor_text." <br /> <a href=\"#\" onclick='".$send_to_editor."'>Send Link To Editor</a> <a href=\"#\" onclick='copyToClipboard	(\"".$clean_link."\");return false;'>Copy Link To Clipboard</a> (<a href=\"#\" onclick=\"wp_affiliate_ajax_delete_link(".$result->id.");return false;\">Delete Link</a>) </li>\n";
}
$link_list .= "</ul>\n";

return $link_list;
}

function get_category_li($id)
{
	global $wpdb,$wp_affiliate_prefix;

	$table_name = $wpdb->prefix . $wp_affiliate_prefix."_categories";	
	
	$result = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE id=".$id, OBJECT);
	$js_category = str_replace("-","_",sanitize_title($result->category));
	
	return "<li class=\"expandable\" id=\"catli".$result->id."\" ><div class=\"hitarea expandable-hitarea\" onclick=\"temptoggle('tcatli".$result->id."')\"></div><div id=\"tcatli".$result->id."\"></div>".$result->category." <a href=\"#\" onclick=\"wp_affiliate_show_add_link_box(".$result->id.",".$result->parent.", '".$js_category."');return false;\">Add A Link</a> <a href=\"#\" onclick=\"wp_affiliate_show_add_sub_category_box(".$result->id.",".$result->parent.", '".$js_category."');return false;\">Add Sub Category</a> (<a href=\"#\" onclick=\"wp_affiliate_ajax_delete_category(".$result->id."); return false;\">Delete Category</a>)<div id=\"add-link-".$result->parent."-".$js_category."\" style=\"display:none;\"></div><div id=\"add-sub-category-".$result->parent."-".$js_category."\" style=\"display:none;\"></div>\n<ul style=\"display:none;\"><li></li></ul>";
}

function get_category_list($parent = 0, $escape=false)
{	
	global $wpdb,$wp_affiliate_prefix;

	$table_name = $wpdb->prefix . $wp_affiliate_prefix."_categories";
	
	$results = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE parent=".$parent." ORDER BY category ASC");
	
	if(!$results)
		return;
	
	$category_list = "<ul";
	
	 if($parent ==0)
	 	$category_list .= " id=\"wpanav\" ";
	 
	 $category_list .= ">\n";
	foreach($results as $result)
	{
		$js_category = str_replace("-","_",sanitize_title($result->category));
		$category_list .= "<li id=\"catli".$result->id."\" >".$result->category." <a href=\"#\" onclick=\"wp_affiliate_show_add_link_box(".$result->id.",".$result->parent.", '".$js_category."');return false;\">Add A Link</a> <a href=\"#\" onclick=\"wp_affiliate_show_add_sub_category_box(".$result->id.",".$result->parent.", '".$js_category."');return false;\">Add Sub Category</a> (<a href=\"#\" onclick=\"wp_affiliate_ajax_delete_category(".$result->id."); return false;\">Delete Category</a>)<div id=\"add-link-".$result->parent."-".$js_category."\" style=\"display:none;\"></div><div id=\"add-sub-category-".$result->parent."-".$js_category."\" style=\"display:none;\"></div>\n";
		

		$category_list .= get_link_list($result->id,$result->category);
		
		
		
		$category_list .= get_category_list($result->id);
		
		$category_list .= "</li>\n";
		
	}
	
	$category_list .= "</ul>\n";

	return $category_list;
}
add_action('wp_ajax_wp_affiliate_delete_category', 'wp_affiliate_delete_category' );

function wp_affiliate_delete_category()
{
global $wpdb,$wp_affiliate_prefix;
$table_name = $wpdb->prefix . $wp_affiliate_prefix."_categories";
$table_name2 = $wpdb->prefix . $wp_affiliate_prefix."_links";


$category = $_POST['category'];


if($category == "")
	die("");

if(is_numeric($category))
{
	if($wpdb->get_var("SELECT COUNT(*) FROM ".$table_name." WHERE parent=".$category)>0)
	{
		die("alert('You must delete a category\'s sub-categories first.');");
	}
	else if($wpdb->get_var("SELECT COUNT(*) FROM ".$table_name2." WHERE category=".$category)>0)
	{
		die("alert('You must delete a category\'s links first.');");
	}
	else
	{
		$sql = "DELETE FROM ".$table_name." WHERE id=".$category;
		$wpdb->query($sql);
		
	
		echo "document.getElementById('catli".$category."').style.display=\"none\";";

	}
}

}

add_action('wp_ajax_wp_affiliate_add_category', 'wp_affiliate_add_category' );

function wp_affiliate_add_category()
{
global $wpdb,$wp_affiliate_prefix;
$table_name = $wpdb->prefix . $wp_affiliate_prefix."_categories";


$category = $_POST['category'];
$parent 	= $_POST['parent'];

if($category == "" || $parent == "")
	die("document.getElementById('wp_affiliate_add_category_results').innerHTML = \"Category name is missing from your category.\";");


if(preg_match ("/[^a-zA-Z0-9 ]+/", $category))
{
	die("document.getElementById('wp_affiliate_add_category_results').innerHTML = \"Category name must be only letters and numbers.\";");
}

$sql = "SELECT * FROM ".$table_name." WHERE category='".$wpdb->escape($category)."' AND parent='".$wpdb->escape($parent)."'";

$row = $wpdb->get_row($sql, OBJECT);

if($row)
	die("document.getElementById('wp_affiliate_add_category_results').innerHTML = \"Category already exists at this depth! Try another.\";");

$sql = "INSERT INTO ".$table_name." (category,parent) VALUES('".$wpdb->escape($category)."','".$wpdb->escape($parent)."')";
$wpdb->query($sql);

$new_cat_li = str_replace("\r","",str_replace("\n","",str_replace("'","\'",get_category_li($wpdb->insert_id))));

echo "var navfil = '".$new_cat_li."';";

if($parent==0)
	echo "jQuery('#wpanav').prepend(navfil);";
else
	echo "jQuery('#catli".$parent.">ul').prepend(navfil);";
	
//echo 'jQuery("#wpanav").prepareBranches(jtree_settings);';


die("document.getElementById('wp_affiliate_add_category_results').innerHTML = \"Category ".$category." successfully added!\";");
}
add_action('admin_head', 'wp_affiliate_category_js_admin_header' );

function wp_affiliate_category_js_admin_header() // this is a PHP function
{
  // use JavaScript SACK library for Ajax
  wp_print_scripts( array( 'sack' ));

  // Define custom JavaScript function
?>

<script src="<? echo get_bloginfo('wpurl'); ?>/wp-content/plugins/wp-affiliate/jquery.treeview.js" type="text/javascript"></script>
<script type="text/javascript">
//<![CDATA[



var jtree_settings;


jQuery(document).ready(function(){
	
	jtree_settings = {animated: "slow",collapsed: true};	
		
	// first example
	jQuery("#wpanav").treeview(jtree_settings);
	

});

function temptoggle(obj)
{
	jQuery('#'+obj)
                                        .parent()
                                        // swap classes for hitarea
                                        .find(">.hitarea")
                                                .swapClass( jQuery.fn.treeview.classes.collapsableHitarea, jQuery.fn.treeview.classes.expandableHitarea )
                                                .swapClass( jQuery.fn.treeview.classes.lastCollapsableHitarea, jQuery.fn.treeview.classes.lastExpandableHitarea )
                                        .end()
                                        // swap classes for parent li
                                        .swapClass( jQuery.fn.treeview.classes.collapsable, jQuery.fn.treeview.classes.expandable )
                                        .swapClass( jQuery.fn.treeview.classes.lastCollapsable, jQuery.fn.treeview.classes.lastExpandable )
                                        // find child lists
                                        .find( ">ul" )
                                        // toggle them
                                        .heightToggle( jtree_settings.animated, jtree_settings.toggle );
}

function wp_affiliate_show_add_sub_category_box(idc, parentid, jscategory)
{
	var display_type = jQuery('#add-link-'+parentid+'-'+jscategory).css("display");
	var display_type2 = jQuery('#add-sub-category-'+parentid+'-'+jscategory).css("display");
	
	if(!jQuery('#add-sub-category-'+parentid+'-'+jscategory).html())
		jQuery('#add-sub-category-'+parentid+'-'+jscategory).html("<h2>Add A Sub Category</h2> <form><input type=\"text\" name=\"c"+jscategory+parentid+"\"><input type=\"button\" value=\"Add Sub Category\" onclick=\"wp_affiliate_ajax_add_category(this.form.c"+jscategory+parentid+","+idc+")\"></form>");
	
	jQuery('#add-sub-category-'+parentid+'-'+jscategory).toggle("slow");
	
	var display_hit = jQuery('#add-sub-category-'+parentid+'-'+jscategory).parent().find(">.hitarea").css("zIndex");

	if((display_type=="none" && display_type2!="none" && display_hit=="99") || (display_type=="none" && display_type2=="none" && display_hit!="99"))
	{
	jQuery('#add-sub-category-'+parentid+'-'+jscategory)
                                        .parent()
                                        // swap classes for hitarea
                                        .find(">.hitarea")
                                                .swapClass( jQuery.fn.treeview.classes.collapsableHitarea, jQuery.fn.treeview.classes.expandableHitarea )
                                                .swapClass( jQuery.fn.treeview.classes.lastCollapsableHitarea, jQuery.fn.treeview.classes.lastExpandableHitarea )
                                        .end()
                                        // swap classes for parent li
                                        .swapClass( jQuery.fn.treeview.classes.collapsable, jQuery.fn.treeview.classes.expandable )
                                        .swapClass( jQuery.fn.treeview.classes.lastCollapsable, jQuery.fn.treeview.classes.lastExpandable )
                                        // find child lists
                                        .find( ">ul" )
                                        // toggle them
                                        .heightToggle( jtree_settings.animated, jtree_settings.toggle );
	}
	
}

function wp_affiliate_show_add_link_box(idc, parentid, jscategory)
{
	var display_type = jQuery('#add-sub-category-'+parentid+'-'+jscategory).css("display");
	var display_type2 = jQuery('#add-link-'+parentid+'-'+jscategory).css("display");

	if(!jQuery('#add-link-'+parentid+'-'+jscategory).html())
	{
		var str = "<h2>Add A Link</h2>";
		str += "<div id=\"wp_affiliate_add_link_results\"></div>";
		str += "<form><table><tr><td align=\"right\">";
		str += "<b>Link:</b> </td><td> <input type=\"text\" name=\"wp_affiliate_add_new_link_link_"+idc+"_"+parentid+"_"+jscategory+"\"> ";
		str += "</td></tr><tr><td align=\"right\">";
		str += "<b>Anchor Text:</b> </td><td> <input type=\"text\" name=\"wp_affiliate_add_new_link_text"+idc+"_"+parentid+"_"+jscategory+"\">";
		str += "</td></tr></table>";
		str += "<input type=\"button\" value=\"Add Affiliate Link\" onclick=\"wp_affiliate_ajax_add_link(this.form.wp_affiliate_add_new_link_link_"+idc+"_"+parentid+"_"+jscategory+",this.form.wp_affiliate_add_new_link_text"+idc+"_"+parentid+"_"+jscategory+", "+idc+");\" />";
		str += "</form>";
		
		jQuery('#add-link-'+parentid+'-'+jscategory).html(str);
	}
	jQuery('#add-link-'+parentid+'-'+jscategory).toggle("slow");
	
	var display_hit = jQuery('#add-link-'+parentid+'-'+jscategory).parent().find(">.hitarea").css("zIndex");
	
	if((display_type=="none" && display_type2!="none" && display_hit=="99") || (display_type=="none" && display_type2=="none" && display_hit!="99"))
	{	
	jQuery('#add-link-'+parentid+'-'+jscategory)
                                        .parent()
                                        // swap classes for hitarea
                                        .find(">.hitarea")
                                                .swapClass( jQuery.fn.treeview.classes.collapsableHitarea, jQuery.fn.treeview.classes.expandableHitarea )
                                                .swapClass( jQuery.fn.treeview.classes.lastCollapsableHitarea, jQuery.fn.treeview.classes.lastExpandableHitarea )
                                        .end()
                                        // swap classes for parent li
                                        .swapClass( jQuery.fn.treeview.classes.collapsable, jQuery.fn.treeview.classes.expandable )
                                        .swapClass( jQuery.fn.treeview.classes.lastCollapsable, jQuery.fn.treeview.classes.lastExpandable )
                                        // find child lists
                                        .find( ">ul" )
                                        // toggle them
                                        .heightToggle( jtree_settings.animated, jtree_settings.toggle );
	}                                        

}
function wp_affiliate_ajax_delete_link(idl)
{
	if(confirm("Are you sure you want to delete this link?"))
	{
	   var mysack = new sack( 
	       "<?php bloginfo( 'wpurl' ); ?>/wp-admin/admin-ajax.php" );    
	
	  mysack.execute = 1;
	  mysack.method = 'POST';
	  mysack.setVar( "action", "wp_affiliate_delete_link" );
	  mysack.setVar( "link", idl );
	  mysack.encVar( "cookie", document.cookie, false );
	  mysack.onError = function() { alert('Ajax error in deleting the link' )};
	  mysack.runAJAX();	  
	}

}

function wp_affiliate_ajax_delete_category(idc)
{
	if(confirm("Are you sure you want to delete this category?"))
	{
	   var mysack = new sack( 
	       "<?php bloginfo( 'wpurl' ); ?>/wp-admin/admin-ajax.php" );    
	
	  mysack.execute = 1;
	  mysack.method = 'POST';
	  mysack.setVar( "action", "wp_affiliate_delete_category" );
	  mysack.setVar( "category", idc );
	  mysack.encVar( "cookie", document.cookie, false );
	  mysack.onError = function() { alert('Ajax error in deleting the category' )};
	  mysack.runAJAX();	  
	}

}

function copyToClipboard(s)
{
 	if (window.clipboardData) 
   {
   
   // the IE-manier
   window.clipboardData.setData("Text", s);
   
   // waarschijnlijk niet de beste manier om Moz/NS te detecteren;
   // het is mij echter onbekend vanaf welke versie dit precies werkt:
   }
   else if (window.netscape) 
   { 
   
   // dit is belangrijk maar staat nergens duidelijk vermeld:
   netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');
   
   // maak een interface naar het clipboard
   var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
   if (!clip) return;
   
   // maak een transferable
   var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
   if (!trans) return;
   
   // specificeer wat voor soort data we op willen halen; text in dit geval
   trans.addDataFlavor('text/unicode');
   
   // om de data uit de transferable te halen hebben we 2 nieuwe objecten nodig   om het in op te slaan
   var str = new Object();
   var len = new Object();
   
   var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
   
   var copytext=s;
   
   str.data=copytext;
   
   trans.setTransferData("text/unicode",str,copytext.length*2);
   
   var clipid=Components.interfaces.nsIClipboard;
   
   if (!clip) return false;
   
   clip.setData(trans,null,clipid.kGlobalClipboard);
   
   }
}

function wp_affiliate_ajax_add_category( category, parentf )
{
   var mysack = new sack( 
       "<?php bloginfo( 'wpurl' ); ?>/wp-admin/admin-ajax.php" );    

  mysack.execute = 1;
  mysack.method = 'POST';
  mysack.setVar( "action", "wp_affiliate_add_category" );
  mysack.setVar( "category", category.value );
  mysack.setVar( "parent", parentf );
  mysack.encVar( "cookie", document.cookie, false );
  mysack.onError = function() { alert('Ajax error in adding the category' )};
  mysack.runAJAX();


} // end of JavaScript function
//]]>
</script>
<link rel="stylesheet" href="<? echo get_bloginfo('wpurl'); ?>/wp-content/plugins/wp-affiliate/jquery.treeview.css" />

<?php
} // end of PHP function myplugin_js_admin_header

