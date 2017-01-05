<?php

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Regis TEDONE <regis.tedone@gmail.com>, CMS-PACA
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Pages Tree Icons',
	'description' => 'You can now change the TYPO3 Page TreeView with SVG icons.',
	'category' => 'be',
	'author' => 'Regis TEDONE',
	'author_email' => 'regis.tedone@gmail.com',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '1.1.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '7.6.0-7.6.99',
		),
		'conflicts' => array(
            'tsconf' => ''
        ),
		'suggests' => array(
		),
	),
);