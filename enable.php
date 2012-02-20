<?php

/*
 *			immanager plugin for WolfCMS.
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

/*
 * The table should look like this:
 * id : primary id
 * imagePath : is the path to the folder where the image is saved
 * imageFilename : is the the imahe filename
 * imageTitle : The title given by the user to the image
 * imageDescription : The description given by the user to the image.
 * 
 * In the immanager extent record class there shoud be a method to find all
 * images with a given path, and a method to find a single image with a given
 * path AND the image filename.
 * 
 */
$sql = "CREATE TABLE IF NOT EXISTS " . TABLE_PREFIX . "immanager(
	id INT NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY(id),
	imagePath varchar(255),
	imageFilename varchar(255),
	imageTitle varchar(255),
	imageDescription varchar(1020))";

$PDO = Record::getConnection();
$PDO->exec($sql);

//Set default setting.
$settings= array (
	'ImageFolder' => '/public/images',
	'enableAjax' => '0',
	'thumbnailFolder' => '/thumbnails',
	'resizeMethod' => '3',
	'thumbnailWidth' => '100',
	'thumbnailHeight' => '100',
	'backgroundColor' => 'FFFFFF'
);
Plugin::setAllSettings($settings, 'immanager');

exit();