<?php

/*
 *			Image Comenter plugin for WolfCMS.
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


?>
<h1><?php echo __('Image Commenter Documentation'); ?></h1>
<p>
<?php echo __('
	This plugin makes it posible to give titles and descriptions to
	images in the backend of a WolfCMS powered website. </br></br>

	Once you have set a title and description for an image you can retreive that 
	data by calling the "imageCommenter" in a page. 
	For example :
	<strong><pre>&lt? php echo imageCommenter("/public/images/my_image.png"); ?&gt</pre></strong>
	Is to retreive the title, and</br>
	<strong><pre>&lt? php echo imageCommenter("/public/images/my_image.png", "description"); ?&gt</pre></strong>
	is to retreive the description.
'); ?>
</p>
