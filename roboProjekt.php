<?php
/**
 * roboProjekt is a plugin that allows you to easily create Projectpages specified to your
 * needs
 * 
 * Copyright (C) 2012  Marcel Neidinger(github.com/sQu4rks)
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

 //Avoid illegal web entrance
if(!defined('MEDIAWIKI')){
	echo "This isn't a standalone software. It is part of the awesome Mediawiki";
	die(-1);
}

 //Declare the Extension
 $wgExtensionCredits['specialpage'][] = array(
 		'path' => __FILE__,
 		'name' => 'roboProjekt',
 		'author' => 'Marcel Neidinger',
 		'version' => '0.1',
 		'url' => 'http://www.phaenovum.eu',
 		'descriptionmsg' => 'This Plugin makes the process of creation simpler '
 );

 $dir = dirname(__FILE__) . '/';
 //Load Pages
 $wgAutoloadClasses['SpecialroboProjekt'] = $dir.'SpecialroboProjekt.php';
 $wgExtensionMessagesFiles['roboProjekt'] = $dir.'roboProjekt.i18n.php';
 $wgExtensionMessagesFiles['roboProjektAlias'] = $dir.'roboProjekt.alias.php';
 $wgSpecialPages['roboProjekt'] = 'SpecialroboProjekt';
 $wgSpecialPageGroups['roboProjekt'] = 'other';
