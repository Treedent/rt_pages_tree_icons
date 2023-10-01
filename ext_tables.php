<?php

declare(strict_types=1);

defined('TYPO3') || die();

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2023 Regis TEDONE <syradev@proton.me>, Syradev
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


use Syradev\RtPagesTreeIcons\Controller\PageIconsController;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;


(static function () {
    ExtensionUtility::registerModule(
        'RtPagesTreeIcons',
        'web',
        'rtptim1',
        'after:info',
        [
            PageIconsController::class => 'list,changePageIcon,changeSubpagesIcons,iconsHelper'
        ],
        [
            'access' => 'user,group',
            'iconIdentifier' => 'module-pagetreeicons',
            'labels' => 'LLL:EXT:rt_pages_tree_icons/Resources/Private/Language/locallang.xlf',
        ]
    );

})();

// Get extension configuration
$extConf = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('rt_pages_tree_icons');

// CSS generation url paramters
$params = [];

// Backend login form background opacity
$opacity = !empty($extConf['backLoginFormOpacity']) ? $extConf['backLoginFormOpacity'] : '0.5';
// Backend login form opacity style
if ($extConf['backLoginFormTransparent'] === '1') {
    $params['opacity'] = $opacity;
}

// Backend login form border
if (isset($extConf['backLoginFormBorder']) && $extConf['backLoginFormBorder'] === '0') {
    $params['border'] = '0';
}

// Backend login form border radius
$radius = !empty($extConf['backLoginBorderRadius']) ? $extConf['backLoginBorderRadius'] : '3';
// Backend login form border radius style
if ($radius !== '3') {
    $params['radius'] = $radius;
}

// Backend login form background color
$backcolor = !empty($extConf['backLoginBackColor']) ? $extConf['backLoginBackColor'] : '#ffffff';
if ($backcolor !== '#ffffff') {
    $params['backcolor'] = $backcolor;
}

// Backend login random background image
if ($extConf['backLoginRandomImage'] === '1') {
    $params['random'] = '1';
}

// Generates new Login Backend CSS Style
$style1 = $style2 = $style3 = $style4 = $style5 = '';
$opacity = 1;

if (isset($params['random']) && $params['random'] === '1') {
    $randomImageUrl = empty($extConf['randomImageUrl']) ? 'https://source.unsplash.com/random' : $extConf['randomImageUrl'];
    $style1 = <<<STYLE1
.typo3-login {
    background-image: url("{$randomImageUrl}") !important;
}
STYLE1;
}

if (isset($params['opacity']) && (float)$params['opacity'] != 1) {
    $style2 = <<<STYLE2
.card.card-login {
    background-color: rgba(255, 255, 255, {$params['opacity']}) !important;
    padding:15px;
}
STYLE2;
}

if (isset($params['border']) && $params['border'] === '0') {
    $style3 = <<<STYLE3
.card.card-login {
    border: none !important;
}
STYLE3;
}

if (isset($params['radius'])) {
    $style4 = <<<STYLE4
.card.card-login {
    border-radius: {$params['radius']}px !important;
}
STYLE4;

}
if (isset($params['backcolor'])) {
    list($r, $g, $b) = sscanf($params['backcolor'], '#%02x%02x%02x');
    $style5 = <<<STYLE5
.card.card-login {
    background-color: rgba({$r},{$g},{$b},{$params['opacity']}) !important;
}
STYLE5;
}

$content = $style1 . "\n" . $style2 . "\n" . $style3 . "\n" . $style4 . "\n" . $style5;

$BeCssFile = 'EXT:rt_pages_tree_icons/Resources/Public/Css/BeStyle.css';

GeneralUtility::writeFile(GeneralUtility::getFileAbsFileName($BeCssFile), $content);

$majorVersion = GeneralUtility::makeInstance(Typo3Version::class)->getMajorVersion();

if ($extConf['backLoginFormTransparent'] === '1' || $extConf['backLoginRandomImage'] === '1') {
    if($majorVersion === 11) {
        $GLOBALS['TBE_STYLES']['stylesheet'] = $BeCssFile;
    } else {
        $GLOBALS['TYPO3_CONF_VARS']['BE']['stylesheets']['rt_pages_tree_icons'] = $BeCssFile;
    }
}