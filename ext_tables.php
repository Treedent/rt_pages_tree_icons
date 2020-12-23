<?php

defined('TYPO3_MODE') or die();
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Regis TEDONE <regis.tedone@gmail.com>, SYRADEV
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

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use SYRADEV\RtPagesTreeIcons\Utility\RtBackendUtility;

ExtensionUtility::registerModule(
    'SYRADEV.rt_pages_tree_icons',
    'web',
    'mod1',
    'Page Tree Icons',
    [
        'PageIcons' => 'list,changepageicon,editPageProperties'
    ],
    [
        'access' => 'user,group',
        'icon'   => 'EXT:rt_pages_tree_icons/Resources/Public/Icons/palm-tree-BE.svg',
        'labels' => 'LLL:EXT:rt_pages_tree_icons/Resources/Private/Language/locallang.xlf',
    ]
);

// Get extension configuration
$extConf = RtBackendUtility::getExtensionConfiguration('rt_pages_tree_icons');

// CSS generation url paramters
$params=[];

// Backend login form background opacity
$opacity = !empty($extConf['backLoginFormOpacity']) ? $extConf['backLoginFormOpacity'] : '0.5';
// Backend login form opacity style
if($extConf['backLoginFormTransparent']==='1') {
	$params['opacity'] =  $opacity;
}

// Backend login form border
if($extConf['backLoginFormBorder']==='0') {
	$params['border'] = '0';
}

// Backend login form border radius
$radius = !empty($extConf['backLoginBorderRadius']) ? $extConf['backLoginBorderRadius'] : '3';
// Backend login form border radius style
if($radius!=='3') {
	$params['radius'] =  $radius;
}

// Backend login form background color
$backcolor = !empty($extConf['backLoginBackColor']) ? $extConf['backLoginBackColor'] : '#ffffff';
if($backcolor!=='#ffffff') {
	$params['backcolor'] = $backcolor;
}

// Backend login random background image
if($extConf['backLoginRandomImage']==='1') {
	$params['random'] = '1';
}

// Generates new Login Backend CSS Style
$style1=$style2=$style3=$style4=$style5='';
$opacity=1;

if( isset($params['random']) && $params['random'] === '1' ) {
    $style1 = <<<STYLE1
.typo3-login {
    background-image: url("https://source.unsplash.com/random") !important;
}
STYLE1;
}

if( isset($params['opacity']) && (float)$params['opacity'] !== 1 ) {
    $style2 = <<<STYLE2
.panel, .panel-footer {
    background-color: rgba(255, 255, 255, {$params['opacity']}) !important;
    padding:15px;
}
STYLE2;
}

if( isset($params['border']) && $params['border'] === '0' ) {
    $style3 = <<<STYLE3
.panel-login {
    border: none !important;
}
STYLE3;
}

if( isset($params['radius']) ) {
    $style4 = <<<STYLE4
.panel-login {
    border-radius: {$params['radius']}px !important;
}
STYLE4;

}
if( isset($params['backcolor']) ) {
    list($r, $g, $b) = sscanf($params['backcolor'], '#%02x%02x%02x' );
    $style5 = <<<STYLE5
.panel-login {
    background-color: rgba({$r},{$g},{$b},{$params['opacity']}) !important;
}
STYLE5;
}

$content =  $style1 ."\n" . $style2 ."\n" . $style3 ."\n" . $style4 ."\n" . $style5;

$BeCssFile = 'EXT:rt_pages_tree_icons/Resources/Public/Css/BeStyle.css';

GeneralUtility::writeFile(GeneralUtility::getFileAbsFileName($BeCssFile), $content);

if( $extConf['backLoginFormTransparent']==='1' || $extConf['backLoginRandomImage']==='1' ) {
    $GLOBALS['TBE_STYLES']['stylesheet'] = $BeCssFile;
}