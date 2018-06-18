<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2018 Regis TEDONE <regis.tedone@gmail.com>, CMS-PACA
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
call_user_func(
    function($extKey) {

        if (TYPO3_MODE === 'BE') {

            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'CMSPACA.' . $extKey,
                'web',
                'mod1',
                '',
                [
                    'PageIcons' => 'list,changepageicon,editPageProperties'
                ],
                [
                    'access' => 'user,group',
                    'icon'   => 'EXT:' . $extKey . '/Resources/Public/Icons/palm-tree-BE.svg',
                    'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_rtpim.xlf',
                ]
            );

        }
        // Load Extension Typoscipt Configuration
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'rt_pages_tree_icons');

		// Login style
	    $extConf = '';
	    if(version_compare(TYPO3_version, '9.0', '<')) {
		    $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['rt_pages_tree_icons']);
	    } elseif(version_compare(TYPO3_version, '9.0', '>=')) {
		    $extConf = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance( \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class )->get( 'rt_pages_tree_icons' );
	    }

        if($extConf['backLoginFormTransparent']==1) {
        	$transparency = !empty($extConf['backLoginFormTransparency']) ? $extConf['backLoginFormTransparency'] : '0.4';
	        $GLOBALS['TBE_STYLES']['inDocStyles_TBEstyle'] = '
	            body .panel, body .panel-footer { background-color: rgba(255, 255, 255, '.$transparency.'); padding:15px; }
	        ';
        }
    },
    $_EXTKEY
);