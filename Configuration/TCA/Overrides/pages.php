<?php
defined('TYPO3_MODE') or die();

use \TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Regis TEDONE <regis.tedone@gmail.com>
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

    [$langFile . 'folderb',             'folderb',              'apps-pagetree-filetree-folder-black'],
    [$langFile . 'folderblt',           'folderblt',            'apps-pagetree-filetree-folder-blue-light'],
    [$langFile . 'folderbl',            'folderbl',             'apps-pagetree-filetree-folder-blue'],
    [$langFile . 'foldergb',            'foldergb',             'apps-pagetree-filetree-folder-gray-brighter'],
    [$langFile . 'foldergd',            'foldergd',             'apps-pagetree-filetree-folder-gray-dark'],
    [$langFile . 'foldergl',            'foldergl',             'apps-pagetree-filetree-folder-gray-light'],
    [$langFile . 'folderg',             'folderg',              'apps-pagetree-filetree-folder-gray'],
    [$langFile . 'foldergrl',           'foldergrl',            'apps-pagetree-filetree-folder-green-light'],
    [$langFile . 'foldergr',            'foldergr',             'apps-pagetree-filetree-folder-green'],
    [$langFile . 'foldero',             'foldero',              'apps-pagetree-filetree-folder-orange'],
    [$langFile . 'folderp',             'folderp',              'apps-pagetree-filetree-folder-purple'],
    [$langFile . 'folderrl',            'folderrl',             'apps-pagetree-filetree-folder-red-light'],
    [$langFile . 'folderr',             'folderr',              'apps-pagetree-filetree-folder-red'],
    [$langFile . 'folderw',             'folderw',              'apps-pagetree-filetree-folder-white'],
    [$langFile . 'folderyl',            'folderyl',             'apps-pagetree-filetree-folder-yellow-light'],
    [$langFile . 'foldery',             'foldery',              'apps-pagetree-filetree-folder-yellow'],

    [$langFile . 'rfolderb',            'rfolderb',             'apps-pagetree-rounded-folder-black'],
    [$langFile . 'rfolderblt',          'rfolderblt',           'apps-pagetree-rounded-folder-blue-light'],
    [$langFile . 'rfolderbl',           'rfolderbl',            'apps-pagetree-rounded-folder-blue'],
    [$langFile . 'rfoldergb',           'rfoldergb',            'apps-pagetree-rounded-folder-gray-brighter'],
    [$langFile . 'rfoldergd',           'rfoldergd',            'apps-pagetree-rounded-folder-gray-dark'],
    [$langFile . 'rfoldergl',           'rfoldergl',            'apps-pagetree-rounded-folder-gray-light'],
    [$langFile . 'rfolderg',            'rfolderg',             'apps-pagetree-rounded-folder-gray'],
    [$langFile . 'rfoldergrl',          'rfoldergrl',           'apps-pagetree-rounded-folder-green-light'],
    [$langFile . 'rfoldergr',           'rfoldergr',            'apps-pagetree-rounded-folder-green'],
    [$langFile . 'rfoldero',            'rfoldero',             'apps-pagetree-rounded-folder-orange'],
    [$langFile . 'rfolderp',            'rfolderp',             'apps-pagetree-rounded-folder-purple'],
    [$langFile . 'rfolderrl',           'rfolderrl',            'apps-pagetree-rounded-folder-red-light'],
    [$langFile . 'rfolderr',            'rfolderr',             'apps-pagetree-rounded-folder-red'],
    [$langFile . 'rfolderw',            'rfolderw',             'apps-pagetree-rounded-folder-white'],
    [$langFile . 'rfolderyl',           'rfolderyl',            'apps-pagetree-rounded-folder-yellow-light'],
    [$langFile . 'rfoldery',            'rfoldery',             'apps-pagetree-rounded-folder-yellow'],

    [$langFile . 'pageb',               'pageb',                'apps-pagetree-page-black'],
    [$langFile . 'pageblt',             'pageblt',              'apps-pagetree-page-blue-light'],
    [$langFile . 'pagebl',              'pagebl',               'apps-pagetree-page-blue'],
    [$langFile . 'pagegb',              'pagegb',               'apps-pagetree-page-gray-brighter'],
    [$langFile . 'pagegd',              'pagegd',               'apps-pagetree-page-gray-dark'],
    [$langFile . 'pagegl',              'pagegl',               'apps-pagetree-page-gray-light'],
    [$langFile . 'pageg',               'pageg',                'apps-pagetree-page-gray'],
    [$langFile . 'pagegrl',             'pagegrl',              'apps-pagetree-page-green-light'],
    [$langFile . 'pagegr',              'pagegr',               'apps-pagetree-page-green'],
    [$langFile . 'pageo',               'pageo',                'apps-pagetree-page-orange'],
    [$langFile . 'pagep',               'pagep',                'apps-pagetree-page-purple'],
    [$langFile . 'pagerl',              'pagerl',               'apps-pagetree-page-red-light'],
    [$langFile . 'pager',               'pager',                'apps-pagetree-page-red'],
    [$langFile . 'pagew',               'pagew',                'apps-pagetree-page-white'],
    [$langFile . 'pageyl',              'pageyl',               'apps-pagetree-page-yellow-light'],
    [$langFile . 'pagey',               'pagey',                'apps-pagetree-page-yellow'],

    [$langFile .'apptypo3b',            'apptypo3b',            'apps-pagetree-logo-typo3-black'],
    [$langFile .'apptypo3o',            'apptypo3o',            'apps-pagetree-logo-typo3-orange'],
    [$langFile .'appts',                'appts',                'apps-pagetree-typoscript-orange'],
    [$langFile .'apptemplates',         'apptemplates',         'apps-pagetree-templates'],
    [$langFile .'appbelayouts',         'appbelayouts',         'apps-pagetree-backend-layout'],
    [$langFile .'appgride',             'appgride',             'apps-pagetree-grid-elements'],
    [$langFile .'symbshortcut',         'symbshortcut',         'apps-pagetree-shortcut'],
    [$langFile .'symbform',             'symbform',             'apps-pagetree-form'],
    [$langFile .'symbdesktop',          'symbdesktop',          'apps-pagetree-ux-desktop'],
    [$langFile .'symbtablet',           'symbtablet',           'apps-pagetree-ux-tablet'],
    [$langFile .'symbmobile',           'symbmobile',           'apps-pagetree-ux-mobile'],
    [$langFile .'symbhome',             'symbhome',             'apps-pagetree-home'],
    [$langFile .'symbvideo',            'symbvideo',            'apps-pagetree-video'],
    [$langFile .'symbaudio',            'symbaudio',            'apps-pagetree-audio'],
    [$langFile .'symbcomments',         'symbcomments',         'apps-pagetree-comments'],
    [$langFile .'symbmagnifier',        'symbmagnifier',        'apps-pagetree-magnifier'],
    [$langFile .'symbmail',             'symbmail',             'apps-pagetree-mail'],
    [$langFile .'symbbooks',            'symbbooks',            'apps-pagetree-books'],
    [$langFile .'symbjobs',             'symbjobs',             'apps-pagetree-jobs'],
    [$langFile .'symblegalnotice',      'symblegalnotice',      'apps-pagetree-legal-notice'],
    [$langFile .'symbsitemap',          'symbsitemap',          'apps-pagetree-sitemap'],
    [$langFile .'symbphone',            'symbphone',            'apps-pagetree-phone'],
    [$langFile .'symblocation',         'symblocation',         'apps-pagetree-location'],
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

    ['Page Icon Changer',                'symbcocotier',         'actions-pagetree-change-page-icon']

];
$GLOBALS['TCA']['pages']['columns']['module']['config']['showIconTable'] = true;
foreach($pageIcons as $iconsParams) {
    $GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = $iconsParams;
    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-'.$iconsParams[1]] = $iconsParams[2];
}