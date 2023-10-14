<?php

/**
 * This file is part of the "rt_pages_tree_icons" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023 Regis TEDONE <syradev@proton.me>, Syradev
 */


/** @var $_EXTKEY */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Pages Tree Icons',
    'description' => 'TYPO3 Pages TreeView SVG icons switcher.',
    'category' => 'be',
    'author' => 'Regis TEDONE',
    'author_email' => 'syradev@proton.me',
    'author_company' => 'Syradev',
    'state' => 'stable',
    'uploadfolder' => 0,
    'clearCacheOnLoad' => 1,
    'version' => '6.1.0',
    'constraints' => [
        'depends' => [
            'php' => '8.0.0-8.2.99',
            'typo3' => '11.5.0-12.4.99'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'Syradev\\RtPagesTreeIcons\\' => 'Classes/'
        ],
    ]
];
