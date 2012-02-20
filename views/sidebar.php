<?php

// php debuging
//ini_set('display_errors', 0); 
//ini_set('log_errors', 1); 
//ini_set('error_log', '/var/www/www.tiltit.org/php_errors.txt'); 
//error_reporting(E_USER_NOTICE);
//error_reporting(E_ERROR | E_USER_NOTICE);
//error_reporting(E_ALL);  

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

/* Security measure */
if (!defined('IN_CMS')) { exit(); }


function hasSubDirectory ($directory){
	$scanedDirectory = array_diff(scandir($directory), array('..', '.'));
	foreach($scanedDirectory as $key => $val) {
		if (is_dir($directory . $val))
			return true;
	}
	return false;
}

function printSubDirectory ($directory,$level,$url,$ignoreFolder){
	$scanedDirectory = array_diff(scandir(CMS_ROOT . $directory), array('..', '.'));
	// List indent
	$margin = $level*16;
	$level++;
	trigger_error($ignoreFolder);
	foreach($scanedDirectory as $key => $val) {
		if ((is_dir(CMS_ROOT . $directory . $val)) && ( ('/' . $val) != $ignoreFolder)) {
			echo '<li style="margin-left:' . $margin . 'px;">';
			echo '<a style="line-height:18px; text-decoration: none;" class="imageFolder" href="' 
			. $url . $directory . $val
			. '">' 
			. '<img src="' . ICONS_URI . 'file-folder-16.png"/>' 
			. $val . '</a>';
			if (hasSubDirectory(CMS_ROOT . $directory . $val . '/')) 
				printSubDirectory ($directory . $val . '/',$level, $url, $ignoreFolder);
			echo '</lil>';
		}
	}
}

?>
<p class="button"><a href="<?php echo get_url('plugin/immanager/documentation/'); ?>">
	<img src="<?php echo ICONS_URI; ?>page-32.png" align="middle" alt="page icon" />
	<?php echo __('Documentation'); ?>
</a></p>
<p class="button"><a href="<?php echo get_url('plugin/immanager/settings'); ?>"> 
	<img src="<?php echo ICONS_URI; ?>settings-32.png" align="middle" alt="Settings icon" />
	<?php echo __('Settings'); ?>
</a></p>
<p class="button"><a href="<?php echo get_url('plugin/immanager'); ?>"> 
	<img src="<?php echo ICONS_URI; ?>plugin-32.png" align="middle" alt="plugin index" />
	<?php echo __('Describe images'); ?>
</a></p>
<p class="button"><a href="<?php echo get_url('plugin/immanager/viewThumbnails'); ?>"> 
	<img src="<?php echo ICONS_URI; ?>file-image-32.png" align="middle" alt="file image icon" />
	<?php echo __('Create Thumbnails'); ?>
</a></p>


<?php
// If we are in the index view show the image folders.
if ($view == ('viewTumbnails' || 'browse')) {
	echo '<div class="box">';
	echo '<h2>' . __('Image folders') . '</h2>';
	$settings = Plugin::getAllSettings('immanager');
	$currentDirectory = $settings['ImageFolder'];
	
	echo '<ul>';
		echo '<li>';
			if ($view == 'browse') {
        $url = get_url('plugin/immanager/browse');
				echo '<a style="line-height:18px; text-decoration: none;" class="imageFolder" href="'
					. $url . '" /><img src="' 
          . ICONS_URI . 'file-folder-16.png"/>'
					. end(explode( '/', $currentDirectory)) . '</a>';
				printSubDirectory($currentDirectory . '/',1, $url, $settings['thumbnailFolder']);
			} elseif ($view == 'viewThumbnails') {
        $url = get_url('plugin/immanager/viewThumbnails');
				echo '<a style="line-height:18px; text-decoration: none;" class="imageFolder" href="'
					. $url . '" /><img src="' 
          . ICONS_URI . 'file-folder-16.png"/>'
					. end(explode( '/', $currentDirectory)) . '</a>';
          printSubDirectory($currentDirectory . '/', 1, $url, $settings['thumbnailFolder']);
			}
		echo '</li>';
	echo '</ul>';
	echo '</div>';
}
?>

