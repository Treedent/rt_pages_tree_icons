<?php

namespace CMSPACA\RtPagesTreeIcons\Hooks;

use TYPO3\CMS\Backend\Tree\Pagetree\Commands;
use \TYPO3\CMS\Backend\Utility\BackendUtility;
//use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
//use TYPO3\CMS\Backend\Tree\Pagetree\PagetreeNode;

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

class ClickMenuAction extends Commands {

  /**
   * Redirect to Page icon changer module
   *
   * @param \stdClass $nodeData
   * @return string Error message for the BE user
   */
  public function loadsPageIconChanger( $nodeData ) {

      try {
        $returnValue = array(
            'success'   =>  TRUE,
            'pageId'    =>  $nodeData->id,
            'message'   =>  'Launching Page Icon changer module'
        );

    } catch ( \Exception $e ) {
      $returnValue = array(
        'success' => FALSE,
        'message' => $e->getMessage()
      );
    }

    return $returnValue;
  }

  /**
    * Add Page icon changer entry to TYPO3 page menu
    */
  public static function addContextMenuItems() {
    // Add items of the context menu to the default userTS configuration
    $GLOBALS[ 'TYPO3_CONF_VARS' ][ 'BE' ][ 'defaultUserTSconfig' ] .= '
        options.contextMenu.table.pages.items {
            580 = DIVIDER
            590 = ITEM
            590 {
                name = loadsPageIconChanger
                label = LLL:EXT:rt_pages_tree_icons/Resources/Private/Language/locallang_rtpim.xlf:changePageIcon
                iconName = actions-pagetree-change-page-icon
                callbackAction = loadsPageIconChanger
                #displayCondition = canShowHistory != 0
            }
            600 = DIVIDER            
        }
    ';
  }
}