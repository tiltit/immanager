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

?>
<h1><?php echo __('Immager Settings'); ?></h1>
<form action="<?php echo get_url('plugin/immanager/saveSettings'); ?>" method="post">
	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Settings for immager plugin.'); ?></legend>
			<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="label"><label for="settings[imageFolder]"><?php echo __('Set the image folder'); ?>: </label></td>
					<td class="field">			
						<input type="text" class="textinput" value="<?php echo $ImageFolder; ?>" name="settings[ImageFolder]" />
					</td>
					<td class="help"><?php echo __('Choose the folder in which you store your images.'); ?></td>
				</tr>
				
				<tr>
					<td class="label"><label for="settings[enableAjax]"><?php echo __('Enable Ajax'); ?>: </label></td>
					<td class="field">
						<select name="settings[enableAjax]">
						<option value="0" <?php if($enableAjax == "0") echo 'selected ="";' ?>><?php echo __('No'); ?></option>
						<option value="1" <?php if($enableAjax == "1") echo 'selected ="";' ?>><?php echo __('Yes'); ?></option>
						</select>	
					</td>
					<td class="help"><?php echo __('If enabled the page will not reload when saving titles and descriptions.'); ?></td>
				</tr>
			</table>
			
	</fieldset>
	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Default settings for Thumbnails.'); ?></legend>
			<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="label"><label for="settings[thumbnailFolder]"><?php echo __('Thumbnail folder'); ?>: </label></td>
					<td class="field">			
						<input type="text" class="textinput" value="<?php echo $thumbnailFolder; ?>" name="settings[thumbnailFolder]" />
					</td>
					<td class="help"><?php echo __('Choose the folder relative to tour image folder in which you want to store your thumbnails.'); ?></td>
				</tr>
				<tr>
					<td class="label"><label for="settings[resizeMethod]"><?php echo __('Set choose the resize method.'); ?>: </label></td>	
					<td class="field">
						<select name="settings[resizeMethod]">
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
					<td class="label"><label for="settings[thumbnailWidth]"><?php echo __('Choose the thumbnail width.');?></label></td>
					<td class="field"><input type="text" class="textinput" value="<?php echo $thumbnailWidth;?>" name="settings[thumbnailWidth]" /></td>
					<td class="help"><?php echo __('Width in pixels of the thumbnails.')?></td>
				</tr>
				<tr>
					<td class="label"> <label for="settings[thumbnailHeight]"><?php echo __('Thumbnail height')?></label></td>
					<td class="field"><input type="text" class="textinput" value="<?php echo $thumbnailHeight; ?>" name="settings[thumbnailHeight]" /></td>
					<td class="help"><?php echo __('Height in pixels of the thumbnails.')?></td>
				</tr>
				<tr>
					<td class="label"> <label for="settings[backgroungColor]"><?php echo __('Backgroung color')?></label></td>
					<td class="field"><input type="text" class="textinput" value="<?php echo $backgroundColor; ?>" name="settings[backgroundColor]" /></td>
					<td class="help"><?php echo __('Choose the background color for the frame resize metho. Must be in hexadecimal notation.')?></td>
				</tr>
				
				
			</table>
	</fieldset>
	<p class="buttons" style="clear: both">
		<input class="button" name="commit" type="submit" accesskey="s" value="<?php echo __('Save'); ?>" />
	</p>
</form>
			

						
<script type="text/javascript">
// <![CDATA[
    function setConfirmUnload(on, msg) {
        window.onbeforeunload = (on) ? unloadMessage : null;
        return true;
    }

    function unloadMessage() {
        return '<?php echo __('You have modified this page.  If you navigate away from this page without first saving your data, the changes will be lost.'); ?>';
    }

    $(document).ready(function() {
        // Prevent accidentally navigating away
        $(':input').bind('change', function() { setConfirmUnload(true); });
        $('form').submit(function() { setConfirmUnload(false); return true; });
    });
// ]]>
</script>