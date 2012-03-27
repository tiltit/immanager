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

/* Security measure */
if (!defined('IN_CMS')) { exit(); }

echo '<h1>' . $directory . '</h1>';
?>


<form id="thumbnailForm" action="<?php echo get_url('plugin/immanager/thumbnailSave'); ?>" method="post">
  <input type="hidden" name="settings[ImageFolder]" value="<?php echo $directory; ?>" />
	<fieldset style=" clear:right;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Overwrite thumbnail default settings'); ?></legend>
			<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="label"><label for="settings[resizeMethod]"><?php echo __('Choose the resize method:'); ?> </label></td>	
					<td class="field">
						<select id="rm" name="settings[resizeMethod]">
						<option value="0" <?php if($resizeMethod == "0") echo 'selected ="";' ?>><?php echo __('Strech'); ?></option>
						<option value="1" <?php if($resizeMethod == "1") echo 'selected ="";' ?>><?php echo __('Crop'); ?></option>
						<option value="2" <?php if($resizeMethod == "2") echo 'selected ="";' ?>><?php echo __('Frame'); ?></option>
						<option value="3" <?php if($resizeMethod == "3") echo 'selected ="";' ?>><?php echo __('Only width'); ?></option>
						<option value="4" <?php if($resizeMethod == "4") echo 'selected ="";' ?>><?php echo __('Only height'); ?></option>
						<option value="5" <?php if($resizeMethod == "5") echo 'selected ="";' ?>><?php echo __('Longest side'); ?></option>
						<option value="6" <?php if($resizeMethod == "6") echo 'selected ="";' ?>><?php echo __('Shortest side'); ?></option>
						</select>	
					</td>
					<td class="help"><?php echo __('How should the images be resized?'); ?></td>
				</tr>
				
				<tr>
					<td class="label"><label for="settings[thumbnailWidth]"><?php echo __('Thumbnail width:');?></label></td>
					<td class="field"><input type="text" class="textinput" value="<?php echo $thumbnailWidth;?>" name="settings[thumbnailWidth]" /></td>
					<td class="help"><?php echo __('Width in pixels of the thumbnails.')?></td>
				</tr>
				<tr>
					<td class="label"> 
						<label for="settings[thumbnailHeight]"><?php echo __('Thumbnail height:')?></label>
					</td>
					<td class="field">
						<input type="text" class="textinput" value="<?php echo $thumbnailHeight; ?>" name="settings[thumbnailHeight]" />
					</td>
					<td class="help"><?php echo __('Height in pixels of the thumbnails.')?></td>
				</tr>
				<tr>
					<td class="label"> 
						<label for="settings[backgroungColor]"><?php echo __('Backgroung color:')?></label>
					</td>
					<td class="field">
						<input type="text" class="textinput" value="<?php echo $backgroundColor; ?>" name="settings[backgroundColor]" />
					</td>
					<td class="help"><?php echo __('Background color for the frame resize method. Must be in hexadecimal notation.')?></td>
				</tr>
				
				
			</table>
	</fieldset>
	<p class="buttons" style="clear: both">
		<input id="currentButton" class="button" name="current" type="submit" value="<?php echo __('View current thumbnails'); ?>" />
		<input id="previewButton" class="button" name="preview" type="submit" value="<?php echo __('Preview Thumbnails'); ?>" />
		<input id="saveButton" class="button" name="save" type="submit" value="<?php echo __('Create Thumbnails'); ?>" />
	</p> 
</form>

<div id="thumbnailCurrent" class="immanager" style="padding: 1em;background-color: #eee; border: 2px groove threedface;">
	<h3><?php echo __('Current thumbnails for images in this folder');?></h3>
<?php
	$images=immanager::findAllByFolder($directory);
	foreach ($images as $image) {
		if (is_file(CMS_ROOT . $image->thumbnailPath)){
			echo '<img style="padding-right: 0.5em; padding-bottom: 0.5em;" src="' . $image->thumbnailPath . '" title="' . $image->imageFilename . '" />';
			$i++;
		}
	}
	if($i==0)
		echo '<p>' . __('There are no thumbnails for images in this folder.') . '</p>';
	// echo '<p><i>' . __('If you make new thumbnail and do not see a change on this page, clear cache and reload page. (Ctrl + F5 on Firefox)') . '</i></p>';
?>
</div>
	
<div id="thumbnailPreview" style="display:none; padding: 1em;background-color: #eee; border: 2px groove threedface;">
</div>

<script>
// <![CDATA[
	
	/*
	 * The thumbnail preview links are genarated by the folowing script.
	 */
	
	$(document).ready(function(){
		var thumbUrl = "<?php echo get_url('plugin/immanager/thumbnail?path=') . $directory . '/'; ?>";
		// Inaitialize array for image names.
		var imageNames = [];
		<?php
			foreach( $links['name'] as $key => $imagename) {
				echo 'imageNames[' . $key . ']= "' . $imagename .'";';
				print "\n";
			}
		?>
		
		
		$('#previewButton').click(function(e){
			e.preventDefault();
			$('#thumbnailPreview').show();
			$('#thumbnailCurrent').hide();
			var html = '';
			var inputs = [];
			$('#thumbnailForm').find(':text').each(function(index){
				inputs[index]=$(this).val();
			});
			var thumbnailWidth = inputs[0];
			var thumbnailHeight = inputs[1];
			var backgroundColor = inputs[2];
			var resizeMethod = $('#rm').val();
			
			var thumbPathVals = '&rm='+resizeMethod+'&w='+thumbnailWidth+'&h='+thumbnailHeight+'&backgroundColor='+backgroundColor;
			html = html + '<h3><?php echo __('Thumbnail previews');?></h3>';
			var style = 'style="padding-bottom: 0.5em;padding-right:0.5em;"'
			jQuery.each(imageNames, function(i,val){
				html = html+'<img src="' + thumbUrl + val + thumbPathVals + '" title="'+ val +'"'+ style +' />';
			});
			
			$('#thumbnailPreview').html(html);
		});
		$('#currentButton').click(function(e){
			e.preventDefault();
			$('#thumbnailPreview').hide();
			$('#thumbnailCurrent').show();
		});
		
	});

// ]]>
</script>

