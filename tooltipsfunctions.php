<?php
function editTooltips()
{
		
		global $wpdb;
		$m_tooltipsArray = get_option('tooltipsarray');
		$m_toolstipskeyword= '';
		$m_toolstipscontent= '';
		if (empty($m_tooltipsArray))
		{
			$m_tooltipsArray = array();
		}
		
		if (isset($_POST['toolstipskeywordsubmitnew']))
		{
			if (isset($_POST['toolstipskeyword']))
			{
				$m_toolstipskeyword = $wpdb->escape($_POST['toolstipskeyword']);
			}

			if (isset($_POST['toolstipscontent']))
			{
				$m_toolstipscontent = $wpdb->escape($_POST['toolstipscontent']);
			}
			
			if ((!(empty($m_toolstipscontent))) && (!(empty($m_toolstipskeyword))))
			{
				$m_added = false;
				if ((is_array($m_tooltipsArray)) && (count($m_tooltipsArray) > 0))
				{
					$i = 0;
					foreach ($m_tooltipsArray as $m_tooltipsSingle)
					{
						if ($m_tooltipsSingle['keyword'] == $m_toolstipskeyword)
						{
							$m_tooltipsSingle['content'] = $m_toolstipscontent;
							$m_tooltipsArray[$i]['content'] = $m_toolstipscontent;
							$m_added = true;
							break;
						}
						$i++;
					}
				}

				if ($m_added  == false)
				{
					$m_tooltipsTempArray = array();
					$m_tooltipsTempArray['keyword'] = $m_toolstipskeyword;
					$m_tooltipsTempArray['content'] = $m_toolstipscontent;
					$m_tooltipsArray[] = $m_tooltipsTempArray;					
				}
				
				update_option('tooltipsarray',$m_tooltipsArray);
			}
			tooltipsMessage("Tooltips saved.");
		}
		


		if (isset($_POST['toolstipskeywordsubmitedit']))
		{
			if (isset($_POST['toolstipskeyword']))
			{
				$m_toolstipskeyword = $wpdb->escape($_POST['toolstipskeyword']);
			}

			if (isset($_POST['toolstipscontent']))
			{
				$m_toolstipscontent = $wpdb->escape($_POST['toolstipscontent']);
			}
			
			if ((!(empty($m_toolstipscontent))) && (!(empty($m_toolstipskeyword))))
			{
				$m_added = false;
				$m_toolstipskeywordsubmithideen = $wpdb->escape($_POST['toolstipskeywordsubmithideen']);
				$m_tooltipsArray[$m_toolstipskeywordsubmithideen]['keyword'] = $m_toolstipskeyword;
				$m_tooltipsArray[$m_toolstipskeywordsubmithideen]['content'] = $m_toolstipscontent;  
				update_option('tooltipsarray',$m_tooltipsArray);
			}
			tooltipsMessage("Changes saved.");
		}
		
		echo "<br />";
		?>

<div style='margin:10px 5px;'>
<div style='float:left;margin-right:10px;'>
<img src='<?php echo get_option('siteurl');  ?>/wp-content/plugins/wordpress-tooltips/images/new.png' style='width:30px;height:30px;'>
</div> 
<div style='padding-top:5px; font-size:22px;'> <i></>Add/Edit Tooltips</i></div>
</div>
<div style='clear:both'></div>		
		<div class="wrap">
			<div id="dashboard-widgets-wrap">
			    <div id="dashboard-widgets" class="metabox-holder">
					<div id="post-body">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:90%;">
								<div class="postbox">
									<h3 class='hndle'><span>
										Add New Tooltips 
									</span>
									</h3>
								
									<div class="inside" style='padding-left:5px;'>
										<br />
										<form id="toolstipsform" name="toolstipsform" action="" method="POST">
										<table id="toolstipstable" width="100%">

										<tr>
										<td width="10%">
										Keyword:
										</td>
										<td width="20%">
										<input type="text" id="toolstipskeyword" name="toolstipskeyword" value="">
										</td>
										<td width="10%">
										Content:
										</td>
										<td width="40%">
										<textarea rows="2" cols="40" name='toolstipscontent'></textarea>
										
										</td>
										</tr>

										</table>
										<br />
										<input type="submit" id="toolstipskeywordsubmitnew" name="toolstipskeywordsubmitnew" value="Add Now">
										</form>
										
										<br />
									</div>
								</div>
							</div>
						</div>
					</div>
		    	</div>
			</div>
		</div>
		<div style="clear:both"></div>
		<br />
		
<!--  edit  -->
<?php 

$m_tooltipsArray = get_option('tooltipsarray');

	if ((is_array($m_tooltipsArray)) && (count($m_tooltipsArray)>0))
	{		
?>
<div style='margin:20px 5px;'>

<div style='clear:both'></div>		
		<div class="wrap">
			<div id="dashboard-widgets-wrap">
			    <div id="dashboard-widgets" class="metabox-holder">
					<div id="post-body">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:90%;">
								<div class="postbox">
									<h3 class='hndle'><span>
										Edit Existed Tooltips 
									</span>
									</h3>
								
									<div class="inside" style='padding-left:5px;'>
										<br />
										
										<table id="toolstipstable" width="100%">
										<?php
										$i = 0; 
										foreach ($m_tooltipsArray as $m_tooltipsNow)
										{

										?>
										<form id="toolstipsform" name="toolstipsform" action="" method="POST">
										<tr>
										<td width="10%">
										Keyword:
										</td>
										<td width="20%">
										<input type="text" id="toolstipskeyword" name="toolstipskeyword" value="<?php echo stripslashes(stripslashes($m_tooltipsNow['keyword'])); ?>">
										</td>
										<td width="10%">
										Content:
										</td>
										<td width="35%">
										<textarea rows="2" cols="35" name='toolstipscontent'><?php echo stripslashes(stripslashes($m_tooltipsNow['content'])); ?></textarea>
										</td>
										
										<td width="15%" style='align:right;text-align:right;padding-right:20px;'>
											<input type="hidden" id="toolstipskeywordsubmithideen" name="toolstipskeywordsubmithideen" value="<?php echo $i; ?>">
											<input type="submit" id="toolstipskeywordsubmitedit"<?php echo $i; ?> name="toolstipskeywordsubmitedit"<?php echo $i; ?> value="Edit Now">										
										</td>
										</tr>
										</form>
										<?php
										$i++;
										}

										?>
										</table>
										<br />
										
										
										<br />
									</div>
								</div>
							</div>
						</div>
					</div>
		    	</div>
			</div>
		</div>
		<div style="clear:both"></div>
		<br />		

		<?php
		}				
}
	
function tooltipsMessage($p_message)
{

	echo "<div id='message' class='updated fade'>";

	echo $p_message;

	echo "</div>";

}
	

?>