<?php
/*
Plugin Name: Tooltips
Plugin URI:  http://tomas.zhu.bz/wordpress-plugin-tooltips.html
Description: Wordpress Tooltips,You can add text,image,link,video,radio in tooltips, add tooltips in gallery. More amazing features? Do you want to customize a beautiful style for your tooltips? Get <a href='http://tooltips.org' target='blank'>Wordpress Tooltips Pro</a> now.
Version: 3.0.0
Author: Tomas Zhu: <a href='http://tooltips.org' target='_blank'>Tooltips Pro</a>
Author URI: http://tomas.zhu.bz
*/

require_once("tooltipsfunctions.php");
function tooltipsHead()
{
	$m_pluginURL = get_option('siteurl').'/wp-content/plugins';

?>
 	<script type="text/javascript">	
	if(typeof jQuery=='undefined')
	{
		document.write('<'+'script src="<?php echo $m_pluginURL; ?>/<?php echo  '/wordpress-tooltips'; ?>/js/qtip/jquery-1.3.2.min.js" type="text/javascript"></'+'script>');
	}
	</script>
	
	<script type="text/javascript" src="<?php echo $m_pluginURL; ?>/<?php echo  "/wordpress-tooltips" ?>/js/qtip/jquery.qtip-1.0.0-rc3.min.js"></script>
	<script type="text/javascript">

	function toolTips(whichID,theTipContent)
	{
			jQuery(whichID).qtip
			(
				{
					content:theTipContent,
   					style:
   					{
      					width: 400,
      					padding: 5,
      					background: '#fcfcec',
      					color: 'black',
      					textAlign: 'left',
      					border:
      					{
         					width: 1,
         					radius: 8,
         					color: '#eee'
      					}
    				},
    				position:
    				{
      					corner:
      					{
         					target: 'rightMiddle',
         					tooltip: 'leftBottom'
      					}
    				},
					show:'mouseover',
					hide:'mouseout'
				}
			)
	}
</script>
	
<?php
}

function tooltipsMenu()
{

	add_menu_page(__('Tooltips','Tooltips'), __('Tooltips','Tooltips'), 10, 'tooltipsfunctions.php','editTooltips');
	add_submenu_page('tooltipsfunctions.php',__('Edit Tooltips','Tooltips'), __('Edit Tooltips','Tooltips'),10, 'tooltipsfunctions.php','editTooltips');
}

function showTooltips()
{
	global $table_prefix,$wpdb;
	
	//!!! $m_result = get_option('tooltipsarray');
	$m_result = tooltips_get_option('tooltipsarray');
	$m_keyword_result = '';
	if (!(empty($m_result)))
	{
		$m_keyword_id = 0;
		foreach ($m_result as $m_single)
		{
			$m_keyword_result .= '<script type="text/javascript">';
			$m_content = $m_single['content'];
			$m_content = str_ireplace('\\','',$m_content);
			$m_content = str_ireplace("'","\'",$m_content);
			$m_content = preg_replace('|\r\n|', '<br/>', $m_content);
			if (!(empty($m_content)))
			{
				$m_keyword_result .= " toolTips('.classtoolTips$m_keyword_id','$m_content'); ";
			}
			$m_keyword_id++;
			$m_keyword_result .= '</script>';
		}


	}
	echo 	$m_keyword_result;
}

function tooltipsInContent($content)
{
	//!!!$m_result = get_option('tooltipsarray');
	$m_result = tooltips_get_option('tooltipsarray');
	if (!(empty($m_result)))
	{
		$m_keyword_id = 0;
		foreach ($m_result as $m_single)
		{
		
			$m_keyword = $m_single['keyword'];
			$m_content = $m_single['content'];
			$m_replace = "<span class='classtoolTips$m_keyword_id' style='border-bottom:2px dotted #888;'>$m_keyword</span>";
	
			if (stripos($content,$m_keyword) === false)
			{
				
			}
			else
			{
				$content = preg_replace("/(\W)(".$m_keyword.")(?![^<|^\[]*[>|\]])(\W)/is","\\1"."<span class='classtoolTips$m_keyword_id' style='border-bottom:2px dotted #888;'>"."\\2"."</span>"."\\3",$content);
	
			}
			$m_keyword_id++;
		}
	}
	return $content;
}

function nextgenTooltips()
{
?>
<script type="text/javascript">
	jQuery("img").load(function()
	{
		if ((jQuery(this).parent("a").attr('title') != '' )  && (jQuery(this).parent("a").attr('title') != undefined ))
		{
			/* alert(jQuery(this).parent("a").attr('title')); 
				fixed the bug of if a img have no description in nextgallery and we still show the popup windows
			*/
			toolTips(jQuery(this).parent("a"),jQuery(this).parent("a").attr('title'));
		}
		else
		{
			/*
			in last version 1.0.5, if we want to add tooltips for a image, we need setting link title in advanced
			setting -- when upload a image, it need 2 steps, from version 1.0.6, we just read image alt as image 
			tooltips, so webmaster just need one step to add tooltips.
			*/
			var tempAlt = jQuery(this).attr('alt');
			tempAlt = tempAlt.replace(' ', '');
			if (tempAlt == '')
			{
				
			}
			else
			{
				toolTips(jQuery(this),jQuery(this).attr('alt'));
			}
		}
	}

	);
</script>
<?php
}
add_action('the_content','tooltipsInContent');
//add_action('admin_menu', 'tooltipsMenu');
add_action('wp_head', 'tooltipsHead');
add_action('wp_footer','showTooltips');
add_action('wp_footer','nextgenTooltips');




function add_tooltips_post_type() {
  $labels = array(
    'name' => __('Tooltips', 'tooltips'),
    'singular_name' => __('Tooltip', 'tooltips'),
    'add_new' => __('Add New', 'tooltips'),
    'add_new_item' => __('Add New Tooltip', 'tooltips'),
    'edit_item' => __('Edit Tooltip', 'tooltips'),
    'new_item' => __('New Tooltip', 'tooltips'),
    'all_items' => __('All Tooltips', 'tooltips'),
    'view_item' => __('View Tooltip', 'tooltips'),
    'search_items' => __('Search Tooltip', 'tooltips'),
    'not_found' =>  __('No Tooltip found', 'tooltips'),
    'not_found_in_trash' => __('No Tooltip found in Trash', 'tooltips'), 
    'menu_name' => __('Tooltips', 'tooltips')
  );
  
  $args = array(
    'labels' => $labels,
    'public' => false,
    'show_ui' => true, 
    'show_in_menu' => true, 
    '_builtin' =>  false,
    'query_var' => "tooltips",
    'rewrite' => false,
    'capability_type' => 'post',
    'has_archive' => false, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array( 'title', 'editor','author','custom-fields','thumbnail' )
  ); 
  register_post_type('tooltips', $args);
}
add_action( 'init', 'add_tooltips_post_type' );

function upgrade_check()
{
	//delete_option('ztooltipversion');
	$currentVersion = get_option('ztooltipversion');
	// old version
	if (empty($currentVersion))
	{
		$m_result = get_option('tooltipsarray');
		if (!(empty($m_result)))
		{
			$m_keyword_id = 0;
			foreach ($m_result as $m_single)
			{
				$m_keyword = $m_single['keyword'];
				$m_content = $m_single['content'];				
				$my_post = array(
  				//'post_title'    => wp_strip_all_tags( $_POST['post_title'] ),
  				'post_title'    => $m_keyword,
  				'post_content'  => $m_content,
  				'post_status'   => 'publish',
  				'post_type'   => 'tooltips',
  				'post_author'   => 1,
				);
				wp_insert_post( $my_post );
			}
		}
	
	}
	update_option('ztooltipversion','3.0.0');
}
add_action( 'init', 'upgrade_check');

function tooltips_get_option($type)
{
	$tooltipsarray = array();
	$m_single = array();
	if ($type == 'tooltipsarray')
	{
		$type = 'tooltips';
		$args=array(
  		'post_type' => $type,
  		'post_status' => 'publish',
  		'posts_per_page' => -1,
  		'caller_get_posts'=> 1
		);
		$my_query = null;
		$my_query = new WP_Query($args);
		if( $my_query->have_posts() ) 
		{
  			while ($my_query->have_posts()) : $my_query->the_post();
  			$m_single = array();
  			$m_single['keyword'] = get_the_title();
			$m_single['content'] = get_the_content();
			$tooltipsarray[] = $m_single;
  			endwhile;
		}
		wp_reset_query();
	}
	return $tooltipsarray;
}
?>