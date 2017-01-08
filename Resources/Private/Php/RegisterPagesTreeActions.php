<?php

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

use \TYPO3\CMS\Core\Utility\GeneralUtility;

if (is_object($TYPO3backend)) {

    // Instanciates the API generator
    $pageRenderer = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Page\\PageRenderer');
    $pageRenderer->addExtDirectCode();

    // calling of Page Tree Icons clickmenu method on the client-side
    $pageRenderer->addExtOnReadyCode("
        Ext.apply(TYPO3.Components.PageTree.Actions, {
            loadsPageIconChanger: function(node, tree) {
                TYPO3.RtPagesTreeIcons.ClickmenuAction.loadsPageIconChanger(
                    node.attributes.nodeData,
                    function(response) {
                        if (response) {
                            //Select the page icon changer module
                            top.TYPO3.ModuleMenu.App.showModule('web_RtPagesTreeIconsMod1');
                            //Select the page tree
                            if (top && top.TYPO3.Backend.NavigationContainer.PageTree) {
                                top.TYPO3.Backend.NavigationContainer.PageTree.select(response.pageId);
                            }
                        }
                    },
                    this
                );
            }
        });
    ");
}