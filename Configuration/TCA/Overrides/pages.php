<?php
defined('TYPO3_MODE') or die();

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Regis TEDONE <regis.tedone@gmail.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/*******************************************/
/******** Override Page Tree Icons ********/
/*****************************************/

$langFile = 'LLL:EXT:rt_pages_tree_icons/Resources/Private/Language/locallang_rtpim.xlf:';

$pageIcons = [

    [$langFile . 'pageb',               'pageb',                'apps-pagetree-page-black'],
	['',                                'pageb-s',              'apps-pagetree-page-black-s'],
    [$langFile . 'pageblt',             'pageblt',              'apps-pagetree-page-blue-light'],
	['',                                'pageblt-s',            'apps-pagetree-page-blue-light-s'],
    [$langFile . 'pagebl',              'pagebl',               'apps-pagetree-page-blue'],
	['',                                'pagebl-s',             'apps-pagetree-page-blue-s'],
	[$langFile . 'pageblf',             'pageblf',              'apps-pagetree-page-blue-fluo'],
	['',                                'pageblf-s',            'apps-pagetree-page-blue-fluo-s'],
    [$langFile . 'pagegb',              'pagegb',               'apps-pagetree-page-gray-brighter'],
	['',                                'pagegb-s',             'apps-pagetree-page-gray-brighter-s'],
    [$langFile . 'pagegd',              'pagegd',               'apps-pagetree-page-gray-dark'],
	['',                                'pagegd-s',             'apps-pagetree-page-gray-dark-s'],
	[$langFile . 'pagegl',              'pagegl',               'apps-pagetree-page-gray-light'],
	['',                                'pagegl-s',             'apps-pagetree-page-gray-light-s'],
    [$langFile . 'pageg',               'pageg',                'apps-pagetree-page-gray'],
	['',                                'pageg-s',              'apps-pagetree-page-gray-s'],
    [$langFile . 'pagegrl',             'pagegrl',              'apps-pagetree-page-green-light'],
	['',                                'pagegrl-s',            'apps-pagetree-page-green-light-s'],
    [$langFile . 'pagegr',              'pagegr',               'apps-pagetree-page-green'],
	['',                                'pagegr-s',             'apps-pagetree-page-green-s'],
	[$langFile . 'pagegrf',             'pagegrf',              'apps-pagetree-page-green-fluo'],
	['',                                'pagegrf-s',            'apps-pagetree-page-green-fluo-s'],
    [$langFile . 'pageo',               'pageo',                'apps-pagetree-page-orange'],
	['',                                'pageo-s',              'apps-pagetree-page-orange-s'],
	[$langFile . 'pageof',              'pageof',               'apps-pagetree-page-orange-fluo'],
	['',                                'pageof-s',             'apps-pagetree-page-orange-fluo-s'],
    [$langFile . 'pagep',               'pagep',                'apps-pagetree-page-purple'],
	['',                                'pagep-s',              'apps-pagetree-page-purple-s'],
	[$langFile . 'pagerl',              'pagerl',               'apps-pagetree-page-red-light'],
	['',                                'pagerl-s',             'apps-pagetree-page-red-light-s'],
    [$langFile . 'pager',               'pager',                'apps-pagetree-page-red'],
	['',                                'pager-s',              'apps-pagetree-page-red-s'],
	[$langFile . 'pagerf',              'pagerf',               'apps-pagetree-page-red-fluo'],
	['',                                'pagerf-s',             'apps-pagetree-page-red-fluo-s'],
	[$langFile . 'pagew',               'pagew',                'apps-pagetree-page-white'],
	['',                                'pagew-s',              'apps-pagetree-page-white-s'],
    [$langFile . 'pageyl',              'pageyl',               'apps-pagetree-page-yellow-light'],
	['',                                'pageyl-s',             'apps-pagetree-page-yellow-light-s'],
    [$langFile . 'pagey',               'pagey',                'apps-pagetree-page-yellow'],
	['',                                'pagey-s',              'apps-pagetree-page-yellow-s'],
	[$langFile . 'pageyf',              'pageyf',               'apps-pagetree-page-yellow-fluo'],
	['',                                'pageyf-s',              'apps-pagetree-page-yellow-fluo-s'],

    [$langFile . 'folderb',             'folderb',              'apps-pagetree-filetree-folder-black'],
    [$langFile . 'folderblt',           'folderblt',            'apps-pagetree-filetree-folder-blue-light'],
    [$langFile . 'folderbl',            'folderbl',             'apps-pagetree-filetree-folder-blue'],
	[$langFile . 'folderblf',           'folderblf',            'apps-pagetree-filetree-folder-blue-fluo'],
    [$langFile . 'foldergb',            'foldergb',             'apps-pagetree-filetree-folder-gray-brighter'],
    [$langFile . 'foldergd',            'foldergd',             'apps-pagetree-filetree-folder-gray-dark'],
    [$langFile . 'foldergl',            'foldergl',             'apps-pagetree-filetree-folder-gray-light'],
    [$langFile . 'folderg',             'folderg',              'apps-pagetree-filetree-folder-gray'],
    [$langFile . 'foldergrl',           'foldergrl',            'apps-pagetree-filetree-folder-green-light'],
    [$langFile . 'foldergr',            'foldergr',             'apps-pagetree-filetree-folder-green'],
	[$langFile . 'foldergrf',           'foldergrf',            'apps-pagetree-filetree-folder-green-fluo'],
    [$langFile . 'foldero',             'foldero',              'apps-pagetree-filetree-folder-orange'],
	[$langFile . 'folderof',            'folderof',             'apps-pagetree-filetree-folder-orange-fluo'],
    [$langFile . 'folderp',             'folderp',              'apps-pagetree-filetree-folder-purple'],
    [$langFile . 'folderrl',            'folderrl',             'apps-pagetree-filetree-folder-red-light'],
    [$langFile . 'folderr',             'folderr',              'apps-pagetree-filetree-folder-red'],
	[$langFile . 'folderrf',            'folderrf',             'apps-pagetree-filetree-folder-red-fluo'],
    [$langFile . 'folderw',             'folderw',              'apps-pagetree-filetree-folder-white'],
    [$langFile . 'folderyl',            'folderyl',             'apps-pagetree-filetree-folder-yellow-light'],
    [$langFile . 'foldery',             'foldery',              'apps-pagetree-filetree-folder-yellow'],
	[$langFile . 'folderyf',            'folderyf',             'apps-pagetree-filetree-folder-yellow-fluo'],

    [$langFile . 'rfolderb',            'rfolderb',             'apps-pagetree-rounded-folder-black'],
    [$langFile . 'rfolderblt',          'rfolderblt',           'apps-pagetree-rounded-folder-blue-light'],
    [$langFile . 'rfolderbl',           'rfolderbl',            'apps-pagetree-rounded-folder-blue'],
	[$langFile . 'rfolderblf',          'rfolderblf',           'apps-pagetree-rounded-folder-blue-fluo'],
    [$langFile . 'rfoldergb',           'rfoldergb',            'apps-pagetree-rounded-folder-gray-brighter'],
    [$langFile . 'rfoldergd',           'rfoldergd',            'apps-pagetree-rounded-folder-gray-dark'],
    [$langFile . 'rfoldergl',           'rfoldergl',            'apps-pagetree-rounded-folder-gray-light'],
    [$langFile . 'rfolderg',            'rfolderg',             'apps-pagetree-rounded-folder-gray'],
    [$langFile . 'rfoldergrl',          'rfoldergrl',           'apps-pagetree-rounded-folder-green-light'],
    [$langFile . 'rfoldergr',           'rfoldergr',            'apps-pagetree-rounded-folder-green'],
	[$langFile . 'rfoldergrf',          'rfoldergrf',           'apps-pagetree-rounded-folder-green-fluo'],
    [$langFile . 'rfoldero',            'rfoldero',             'apps-pagetree-rounded-folder-orange'],
	[$langFile . 'rfolderof',           'rfolderof',            'apps-pagetree-rounded-folder-orange-fluo'],
    [$langFile . 'rfolderp',            'rfolderp',             'apps-pagetree-rounded-folder-purple'],
    [$langFile . 'rfolderrl',           'rfolderrl',            'apps-pagetree-rounded-folder-red-light'],
    [$langFile . 'rfolderr',            'rfolderr',             'apps-pagetree-rounded-folder-red'],
	[$langFile . 'rfolderrf',           'rfolderrf',            'apps-pagetree-rounded-folder-red-fluo'],
    [$langFile . 'rfolderw',            'rfolderw',             'apps-pagetree-rounded-folder-white'],
    [$langFile . 'rfolderyl',           'rfolderyl',            'apps-pagetree-rounded-folder-yellow-light'],
    [$langFile . 'rfoldery',            'rfoldery',             'apps-pagetree-rounded-folder-yellow'],
	[$langFile . 'rfolderyf',           'rfolderyf',            'apps-pagetree-rounded-folder-yellow-fluo'],

    [$langFile .'apptypo3b',            'apptypo3b',            'apps-pagetree-logo-typo3-black'],
    [$langFile .'apptypo3o',            'apptypo3o',            'apps-pagetree-logo-typo3-orange'],
    [$langFile .'appts',                'appts',                'apps-pagetree-typoscript-orange'],
    [$langFile .'apptemplates',         'apptemplates',         'apps-pagetree-templates'],
    [$langFile .'appbelayouts',         'appbelayouts',         'apps-pagetree-backend-layout'],
    [$langFile .'appgride',             'appgride',             'apps-pagetree-grid-elements'],
    [$langFile .'symbshortcut',         'symbshortcut',         'apps-pagetree-shortcut'],
    [$langFile .'symblandpage',         'symblandpage',         'apps-pagetree-landing-page'],
    [$langFile .'symbdownload',         'symbdownload',         'apps-pagetree-download'],
    [$langFile .'symbform',             'symbform',             'apps-pagetree-form'],
    [$langFile .'symbdesktop',          'symbdesktop',          'apps-pagetree-ux-desktop'],
    [$langFile .'symbtablet',           'symbtablet',           'apps-pagetree-ux-tablet'],
    [$langFile .'symbmobile',           'symbmobile',           'apps-pagetree-ux-mobile'],
    [$langFile .'symbhome',             'symbhome',             'apps-pagetree-home'],
    [$langFile .'symbvideo',            'symbvideo',            'apps-pagetree-video'],
    [$langFile .'symbaudio',            'symbaudio',            'apps-pagetree-audio'],
    [$langFile .'symbcamera',           'symbcamera',           'apps-pagetree-camera'],
    [$langFile .'symbcomments',         'symbcomments',         'apps-pagetree-comments'],
    [$langFile .'symbmagnifier',        'symbmagnifier',        'apps-pagetree-magnifier'],
    [$langFile .'symbmail',             'symbmail',             'apps-pagetree-mail'],
    [$langFile .'symbbooks',            'symbbooks',            'apps-pagetree-books'],
    [$langFile .'symbjobs',             'symbjobs',             'apps-pagetree-jobs'],
    [$langFile .'symblegalnotice',      'symblegalnotice',      'apps-pagetree-legal-notice'],
    [$langFile .'symbsitemap',          'symbsitemap',          'apps-pagetree-sitemap'],
    [$langFile .'symbagenda',           'symbagenda',           'apps-pagetree-agenda'],
    [$langFile .'symbphone',            'symbphone',            'apps-pagetree-phone'],
    [$langFile .'symblocation',         'symblocation',         'apps-pagetree-location'],
    [$langFile .'symbcloud',            'symbcloud',            'apps-pagetree-cloud'],
    [$langFile .'symbmeteo',            'symbmeteo',            'apps-pagetree-meteo'],
    [$langFile .'symbcredcard',         'symbcredcard',         'apps-pagetree-credit-card'],
    [$langFile .'symbuniversity',       'symbuniversity',       'apps-pagetree-university'],
    [$langFile .'symbfaq',              'symbfaq',              'apps-pagetree-faq'],
    [$langFile .'apprssb',              'apprssb',              'apps-pagetree-rss-black'],
    [$langFile .'apprsso',              'apprsso',              'apps-pagetree-rss-orange'],

    [$langFile .'symbarob',             'symbarob',             'apps-pagetree-arobase-black'],
    [$langFile .'symbaroo',             'symbaroo',             'apps-pagetree-arobase-orange'],
    [$langFile .'symbastb',             'symbastb',             'apps-pagetree-asterisk-black'],
    [$langFile .'symbasto',             'symbasto',             'apps-pagetree-asterisk-orange'],
    [$langFile .'symbhtagb',            'symbhtagb',            'apps-pagetree-hashtag-black'],
    [$langFile .'symbhtago',            'symbhtago',            'apps-pagetree-hashtag-orange'],
    [$langFile .'symbgearb',            'symbgearb',            'apps-pagetree-gear-black'],
    [$langFile .'symbgearo',            'symbgearo',            'apps-pagetree-gear-orange'],
    [$langFile .'symbstarb',            'symbstarb',            'apps-pagetree-star-black'],
    [$langFile .'symbstaro',            'symbstaro',            'apps-pagetree-star-orange'],
    [$langFile .'symbwrenchb',          'symbwrenchb',          'apps-pagetree-wrench-black'],
    [$langFile .'symbwrencho',          'symbwrencho',          'apps-pagetree-wrench-orange'],

    [$langFile .'symbcube',             'symbcube',             'apps-pagetree-cube'],
    [$langFile .'symbdb',               'symbdb',               'apps-pagetree-database'],
    [$langFile .'symblightbulb',        'symblightbulb',        'apps-pagetree-lightbulb'],
    [$langFile .'symblock',             'symblock',             'apps-pagetree-lock'],
    [$langFile .'symbsak',              'symbsak',              'apps-pagetree-swiss-army-knife'],
    [$langFile .'symbusers',            'symbusers',            'apps-pagetree-users'],
    [$langFile .'symbuser',             'symbuser',             'apps-pagetree-user'],
    [$langFile .'symbearth',            'symbearth',            'apps-pagetree-earth'],
    [$langFile .'syslinux',             'syslinux',             'apps-pagetree-linux-black'],
    [$langFile .'sysandroid',           'sysandroid',           'apps-pagetree-android-black'],
    [$langFile .'sysapple ',            'sysapple',             'apps-pagetree-apple-black'],
    [$langFile .'syswindows',           'syswindows',           'apps-pagetree-windows-black'],
    [$langFile .'browserchrome',        'browserchrome',        'apps-pagetree-browser-chrome'],
    [$langFile .'browserfirefox',       'browserfirefox',       'apps-pagetree-browser-firefox'],
    [$langFile .'browseropera',         'browseropera',         'apps-pagetree-browser-opera'],
    [$langFile .'browsersafari',        'browsersafari',        'apps-pagetree-browser-safari'],
    [$langFile .'browseredge',          'browseredge',          'apps-pagetree-browser-ie'],

    ['HTML5',                           'apphtml5',             'apps-pagetree-html5'],
    ['CSS3',                            'appcss3',              'apps-pagetree-css3'],
    ['jQuery',                          'appjquery',            'apps-pagetree-jquery'],
    ['Bootstrap',                       'appbootstrap',         'apps-pagetree-bootstrap'],
    ['Git branch',                      'appgitbranch',         'apps-pagetree-git-branch'],
    ['Git merge',                       'appgitmerge',          'apps-pagetree-git-merge'],
    ['PHP',                             'appphp',               'apps-pagetree-php'],
	['Blogger',                         'appblogger',           'apps-pagetree-blogger'],
    ['Facebook',                        'socialfb',             'apps-pagetree-social-facebook'],
    ['Twitter',                         'apptw',                'apps-pagetree-social-twitter'],
    ['Google +',                        'appgp',                'apps-pagetree-social-google-plus'],
    ['LinkedIn',                        'appli',                'apps-pagetree-social-linkedin'],
    ['Viadeo',                          'appvi',                'apps-pagetree-social-viadeo'],

    [$langFile . 'alphabeta',           'alphabeta',            'apps-pagetree-alphanum-a'],
    [$langFile . 'alphabetb',           'alphabetb',            'apps-pagetree-alphanum-b'],
    [$langFile . 'alphabetc',           'alphabetc',            'apps-pagetree-alphanum-c'],
    [$langFile . 'alphabetd',           'alphabetd',            'apps-pagetree-alphanum-d'],
    [$langFile . 'alphabete',           'alphabete',            'apps-pagetree-alphanum-e'],
    [$langFile . 'alphabetf',           'alphabetf',            'apps-pagetree-alphanum-f'],
    [$langFile . 'alphabetg',           'alphabetg',            'apps-pagetree-alphanum-g'],
    [$langFile . 'alphabeth',           'alphabeth',            'apps-pagetree-alphanum-h'],
    [$langFile . 'alphabeti',           'alphabeti',            'apps-pagetree-alphanum-i'],
    [$langFile . 'alphabetj',           'alphabetj',            'apps-pagetree-alphanum-j'],
    [$langFile . 'alphabetk',           'alphabetk',            'apps-pagetree-alphanum-k'],
    [$langFile . 'alphabetl',           'alphabetl',            'apps-pagetree-alphanum-l'],
    [$langFile . 'alphabetm',           'alphabetm',            'apps-pagetree-alphanum-m'],
    [$langFile . 'alphabetn',           'alphabetn',            'apps-pagetree-alphanum-n'],
    [$langFile . 'alphabeto',           'alphabeto',            'apps-pagetree-alphanum-o'],
    [$langFile . 'alphabetp',           'alphabetp',            'apps-pagetree-alphanum-p'],
    [$langFile . 'alphabetq',           'alphabetq',            'apps-pagetree-alphanum-q'],
    [$langFile . 'alphabetr',           'alphabetr',            'apps-pagetree-alphanum-r'],
    [$langFile . 'alphabets',           'alphabets',            'apps-pagetree-alphanum-s'],
    [$langFile . 'alphabett',           'alphabett',            'apps-pagetree-alphanum-t'],
    [$langFile . 'alphabetu',           'alphabetu',            'apps-pagetree-alphanum-u'],
    [$langFile . 'alphabetv',           'alphabetv',            'apps-pagetree-alphanum-v'],
    [$langFile . 'alphabetw',           'alphabetw',            'apps-pagetree-alphanum-w'],
    [$langFile . 'alphabetx',           'alphabetx',            'apps-pagetree-alphanum-x'],
    [$langFile . 'alphabety',           'alphabety',            'apps-pagetree-alphanum-y'],
    [$langFile . 'alphabetz',           'alphabetz',            'apps-pagetree-alphanum-z'],
    [$langFile . 'number0',             'number0',              'apps-pagetree-alphanum-0'],
    [$langFile . 'number1',             'number1',              'apps-pagetree-alphanum-1'],
    [$langFile . 'number2',             'number2',              'apps-pagetree-alphanum-2'],
    [$langFile . 'number3',             'number3',              'apps-pagetree-alphanum-3'],
    [$langFile . 'number4',             'number4',              'apps-pagetree-alphanum-4'],
    [$langFile . 'number5',             'number5',              'apps-pagetree-alphanum-5'],
    [$langFile . 'number6',             'number6',              'apps-pagetree-alphanum-6'],
    [$langFile . 'number7',             'number7',              'apps-pagetree-alphanum-7'],
    [$langFile . 'number8',             'number8',              'apps-pagetree-alphanum-8'],
    [$langFile . 'number9',             'number9',              'apps-pagetree-alphanum-9'],

    ['Page Icon Changer',               'symbcocotier',         'actions-pagetree-change-page-icon']

];

$diplayIconsInBehaviourTab = 0;
$extConf = '';
if(version_compare(TYPO3_version, '9.0', '<')) {
	$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['rt_pages_tree_icons']);
} elseif(version_compare(TYPO3_version, '8.0', '>')) {
	$extConf = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance( \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class )->get( 'rt_pages_tree_icons' );
}
$diplayIconsInBehaviourTab = $extConf['diplayIconsInBehaviourTab'];
//\TYPO3\CMS\Core\Utility\DebugUtility::debug($diplayIconsInBehaviourTab);
$GLOBALS['TCA']['pages']['columns']['module']['config']['fieldWizard']['selectIcons']['disabled'] = !$diplayIconsInBehaviourTab;

foreach($pageIcons as $iconsParams) {
    $GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = $iconsParams;
    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-'.$iconsParams[1]] = $iconsParams[2];
}