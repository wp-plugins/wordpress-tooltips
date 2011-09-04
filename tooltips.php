<?php
/*
Plugin Name: Tooltips
Plugin URI:  http://tomas.zhu.bz/wordpress-plugin-tooltips.html
Description: Wordpress Tooltips
Version: 1.0.2
Author: Tomas Zhu
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
	
	$m_result = get_option('tooltipsarray');
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
	$m_result = get_option('tooltipsarray');
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
	jQuery("img").load(function(){if (jQuery(this).parent("a").attr('title') != '' ) {toolTips(jQuery(this).parent("a"),jQuery(this).parent("a").attr('title'))};});
</script>
<?php
}
add_action('the_content','tooltipsInContent');
add_action('admin_menu', 'tooltipsMenu');
add_action('wp_head', 'tooltipsHead');
add_action('wp_footer','showTooltips');
add_action('wp_footer','nextgenTooltips');
?>