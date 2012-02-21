<?php
/*
 *			Image Commenter plugin for WolfCMS.
 *
 *			This plugin makes it posible to give titles and descriptions to
 *			images in the backend of a WolfCMS powered website.
 *
 *			Copyright 2012 Oliver Dille
 *
 */
			
 /*
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation version 3 of the License.
 *      
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */

echo '<h1>' . $directory . '</h1>';
if(is_array($images)){
	foreach ($images as $key => $image) {
?>
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
						<input type="text" class="textinput" value="<?php echo $imageTitles[$key];?>"name="imageTitle" style="width: 100%;"/>
					</td>
				</tr>
				<tr>
				<td class="label">
					<label for="imageDescription :">
						Image Comment:
					</label>
					<img style="padding-top:1em;" 
						src="<?php echo get_url('plugin/immanager/thumbnail?path=') . $directory . DS . $image ?>&rm=6&w=120&h=120&backgroundColor=FFF"/>
				</td>
					<td class="field">
						<textarea name="imageDescription" rows="10" cols="40" style="width: 100%;"><?php echo $imageDescriptions[$key];?></textarea> 
					</td>
				</tr>
				<tr>
					<td class="label">
						<label for="saveDescription :">Save Description:</label>
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
				<input type="hidden" name="imagePath" value="<?php echo $directory;?>" />
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
		var pageurl = window.location.pathname;
		var ajaxurl= pageurl + '/imageCommeterSaveComment';
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
