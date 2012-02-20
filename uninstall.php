<?php

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

if (Plugin::deleteAllSettings('immanager') === false) {
    Flash::set('error', __('Unable to delete plugin settings.'));
    redirect(get_url('setting'));
}
try {
	$pdo = Record::getConnection();
	$pdo->query('DROP TABLE IF EXISTS ' . TABLE_PREFIX . 'immanager');
}
catch(PDOException $e) {
	Flash::set('error :' . $e->getMessage, __('Unable to drop table :tablename', array(':tablename' => TABLE_PREFIX.'immanager')));
	redirect(get_url('setting'));
}
