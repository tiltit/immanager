<?php

/*
 *			immanager plugin for WolfCMS.
 *
 *			This plugin makes it posible to give titles and descriptions to
 *			images in the backend of a WolfCMS powered website.
 *
 *			Author : Oliver Dille
 *			Licence : GPL3
 *
 */

echo '<h1>' . $directory . '</h1>';
if(is_array($images)){
	foreach ($images as $key => $image) {?>
	<form method="post" action="<?php echo get_url('plugin/immanager/imageCommeterSaveComment'); ?>" 
		name="<?php echo $directory . '/' . $image ;?>" class="immanagerForm">
		<fieldset style="padding: 0.5em;">
			<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;">
				<?php echo $directory . DS . $image ;?>
			</legend>
			<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td  class="label" style="border-top: 0;"><label for="imageTitle">Image title:</label></td>
					<td class="field" style="border-top: 0;">
						<input type="text" class="textinput" 
							value="<?php if(isset($immanagers[$image])) echo $immanagers[$image]->imageTitle;?>"
							name="imageTitle" style="width: 100%;"/>
					</td>
				</tr>
				<tr>
				<td class="label">
					<label for="imageDescription">
						Image Comment:
					</label>
					<img style="padding-top:1em;" 
						src="<?php echo get_url('plugin/immanager/thumbnail?path=') . $directory . DS . $image ?>&rm=2&w=120&h=120&backgroundColor=FFF"/>
				</td>
					<td class="field">
						<textarea name="imageDescription" rows="10" cols="40" style="width: 100%;"><?php if(isset($immanagers[$image])) echo $immanagers[$image]->imageDescription;?></textarea> 
					</td>
				</tr>
				<tr>
					<td class="label">
						<label for="saveDescription">Save Description:</label>
					</td>	
					<td>
						<input style= "float : right;" 
							class="immanagerSaveComment" 
							name="<?php echo $directory . DS . $image ;?>" 
							type="submit" 
							value="<?php echo __('Save image name and description');?>" />
					</td>
				</tr>
			</table>
				<?php 
				// Hiden input to set the image path.
				?> 
				<input type="hidden" name="imagePath" value="<?php echo $directory ;?>" />
				<input type="hidden" name="imageFilename" value="<?php echo $image ;?>" />
		</fieldset>
	</form>		
<?php
		
	}
} else {
	echo '<h3>' . __('There are no supported images in this folder.') . '</h3>';
}
?>
<?php if ($ajaxEnabled) {?>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function(){
	$('.immanagerForm').submit(function(e) {
		e.preventDefault();
		var link = $(this).attr("name");
		var formData = $(this).serializeArray();
		$('body').prepend(window.location.pathname);
		var pageurl = window.location.pathname;
		
		var ajaxurl='<?php echo get_url('plugin/immanager/imageCommeterSaveComment');?>';
		
		$.ajax({
			type : 'POST',
			url : ajaxurl,
			dataType : 'json', 
			data : {
				imageTitle : formData[0]['value'],
				imageDescription : formData[1]['value'],
				imagePath : formData[2]['value'],
				imageFilename : formData[3]['value']
			},
			success : function(data){
				
				flash('success',"<?php echo __('Image title and description updated'); ?>");
				
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				flash('error',"<?php echo __('Sorry there has been an error'); ?>");
			}
			
		});
	});
	
}); 
// ]]>
</script>
<?php }?>
