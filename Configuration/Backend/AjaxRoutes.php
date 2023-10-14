<?php

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

use Syradev\RtPagesTreeIcons\Controller\AjaxIconsController;

return [

    // Get All icons HTML
    'get_allIcons' => [
        'path' => '/allicons',
        'target' => AjaxIconsController::class . '::getAllIconsAction'
    ],
    // Set new icons HTML
    'set_newIcon' => [
        'path' => '/newicon',
        'target' => AjaxIconsController::class . '::setNewIconAction'
    ],
    // Search for Icons
    'search_icons' => [
        'path' => '/searchicons',
        'target' => AjaxIconsController::class . '::searchIconsAction'
    ]
];
