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

Plugin::setInfos(array(
    'id'          => 'immanager',
    'title'       => __('immanager Image Manager'),
    'description' => __('Provides a way to give a title and description and create thumbnails.'),
    'version'     => '0.0.1',
   	'license'     => 'GPL',
		'author'      => 'Oliver Dille',
    'website'     => 'http://tiltit.org/',
    //'update_url'  => 'http://www.wolfcms.org/plugin-versions.xml',
    'require_wolf_version' => '0.7.5'
));

// Add the extend record class to the plugin.
AutoLoader::addFile('Comment', CORE_ROOT.'/plugins/immanager/immanager.php');

// Add the controller for the plugin.
Plugin::addController('immanager', __('immanager'), 'administrator', true);
/*
function imageCommenter($imagePath, $titleOrDescription = 'title'){
			$pdo = Record::getConnection();
			$query = "select * from image_commenter where imagePath='$imagePath'";
			$queryResult = $pdo->query($query);
			$row = $queryResult->fetch(PDO::FETCH_ASSOC);
			$imageTitle = $row['imageTitle'];
			$imageDescription = $row['imageDescription'];
			$pdo=null;
			if ($titleOrDescription == 'description') {
				return $imageDescription;
			} else {
				return $imageTitle;
			}
		}
*/
		
		