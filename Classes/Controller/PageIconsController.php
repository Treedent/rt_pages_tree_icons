<?php
namespace CMSPACA\RtPagesTreeIcons\Controller;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;

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

/**
 * PageIconsController
 */
class PageIconsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * action list
     *
     * @return void display
     */
    public function listAction() {

        $urlvars = $_GET;
        $pageId = isset($urlvars['pageId']) ? $urlvars['pageId'] : $urlvars['id'];
        $page0 = false;
        if($pageId==0 || $pageId==null) {
            $page0 = true;
        }

	    $pageIconClass = '';

        //Get page Icon
        $pageIconName = $this->getPageIcon($pageId);

        $pageType = $this->getPageType($pageId);
        switch($pageType) {
            case '1':
                $defaultPageIconClass = !$this->isNavHide($pageId) ? 'apps-pagetree-page' : 'apps-pagetree-page-not-in-menu';
                if($this->isSiteRoot($pageId)) {
                    $defaultPageIconClass = 'apps-pagetree-folder-root';
                }
                break;
            case '3':
                $defaultPageIconClass = !$this->isNavHide($pageId) ? 'apps-pagetree-page-shortcut-external' : 'apps-pagetree-page-shortcut-external-hideinmenu';
                if($this->isSiteRoot($pageId)) {
                    $defaultPageIconClass = 'apps-pagetree-page-shortcut-external-root';
                }
                break;
            case '4':
                $defaultPageIconClass = !$this->isNavHide($pageId) ? 'apps-pagetree-page-shortcut' : 'apps-pagetree-page-shortcut-hideinmenu';
                if($this->isSiteRoot($pageId)) {
                    $defaultPageIconClass = 'apps-pagetree-page-shortcut-root';
                }
                break;
            case '6':
                $defaultPageIconClass = !$this->isNavHide($pageId) ? 'apps-pagetree-page-backend-users' : 'apps-pagetree-page-backend-users-hideinmenu';
                if($this->isSiteRoot($pageId)) {
                    $defaultPageIconClass = 'apps-pagetree-page-backend-users-root';
                }
                break;
            case '7':
                $defaultPageIconClass = !$this->isNavHide($pageId) ? 'apps-pagetree-page-mountpoint' : 'apps-pagetree-page-mountpoint-hideinmenu';
                if($this->isSiteRoot($pageId)) {
                    $defaultPageIconClass = 'apps-pagetree-page-mountpoint-root';
                }
                break;
            case '254':
                $defaultPageIconClass = !$this->isNavHide($pageId) ? 'apps-pagetree-folder-default' : 'apps-pagetree-folder-hideinmenu';
                if($this->isSiteRoot($pageId)) {
                    $defaultPageIconClass = 'apps-pagetree-folder-root';
                }
                break;
            case '199':
                $defaultPageIconClass = !$this->isNavHide($pageId) ? 'apps-pagetree-spacer' : 'apps-pagetree-spacer-hideinmenu';
                if($this->isSiteRoot($pageId)) {
                    $defaultPageIconClass = 'apps-pagetree-spacer-root';
                }
                break;
            case '255':
                $defaultPageIconClass = !$this->isNavHide($pageId) ? 'apps-pagetree-page-recycler' : 'apps-pagetree-page-recycler-hideinmenu';
                break;
        }

        //Set default icon
        $default_label = LocalizationUtility::translate('LLL:EXT:rt_pages_tree_icons/Resources/Private/Language/locallang_rtpim.xlf:defaultPageType', 'rt_pages_tree_icons');
        $icons[0] = [ $default_label, '', $defaultPageIconClass, 'svg'];

        $selectedIcon = '';

        foreach($GLOBALS['TCA']['pages']['columns']['module']['config']['items'] as $declared_icons) {

            // declared_icons
            // 0 > label
            // 1 > id
            // 2 > class
            // 3 > type

            //Get Page icon class
            if(!empty($pageIconName)) {

                if($declared_icons[1]==$pageIconName) {
                    $pageIconClass = $declared_icons[2];
	                if(substr($pageIconName,-2)=='-s') {
		                $selectedIcon = substr($pageIconName,0,-2);
	                } else {
                        $selectedIcon = $pageIconName;
	                }
                }
            } else {
                $pageIconClass = $defaultPageIconClass;
            }
            //Remove empty icons or Shortcut Icons
            if(empty($declared_icons[0]) || substr($declared_icons[1],-2)=='-s') {
                continue;
            }
            //Remove gifs/png from your TYPO3 extensions, switch to SVG, please!
            if(substr($declared_icons[2], -4) =='.png') {
                $declared_icons[3] = 'png';
            }
            if(substr($declared_icons[2], -4) =='.gif') {
                $declared_icons[3] = 'gif';
            } else {
                $declared_icons[3] = 'svg';
            }
            if(substr($declared_icons[0], 0, 3)=='LLL') {
                $declared_icons[0] = LocalizationUtility::translate($declared_icons[0], 'rt_pages_tree_icons');
            }
            $icons[] = $declared_icons;
        }

        //DebuggerUtility::var_dump($icons[0]);

        $this->view->assignMultiple([
            'icons'         => $icons,
            'pageId'        => $pageId,
            'pageIcon'      => $pageIconClass,
            'selectedIcon'  => $selectedIcon,
            'page0'         => $page0,
            'pageTitle'     => $this->getPageTitle($pageId)
        ]);
    }

    /**
     * action changePageIcon
     * @return void
     */
    public function changepageiconAction() {

	    if(version_compare(TYPO3_version, '8.0', '<')) {
    	    global $TYPO3_DB;
	    } elseif(version_compare(TYPO3_version, '8.0', '>=')) {
		    $pagesQueryBuilder =  GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getQueryBuilderForTable('pages');
	    }

        //Retrieve vars
        $postVars = GeneralUtility::_POST('tx_rtpagestreeicons_web_rtpagestreeiconsmod1');
        $newIcon = $postVars['newIcon'];

	    //\TYPO3\CMS\Core\Utility\DebugUtility::debug($newIcon);

        $getVars = GeneralUtility::_GET('tx_rtpagestreeicons_web_rtpagestreeiconsmod1');
        $pageId = intval($getVars['pageId']);

	    $pageType = $this->getPageType($pageId);
	    if($pageType == '4' && substr($newIcon,0,4)=='page' || $pageType == '4' && substr($newIcon,0,9)=='symbearth') {
		    $newIcon.= '-s';
	    }

        //Update page icon in database
        $where_clause_page = "`uid`='" . $pageId . "'";
        $pages_fields_update = [
            'tstamp'=>time(),
            'module' =>$newIcon
        ];

	    if(version_compare(TYPO3_version, '8.0', '<')) {
		    $page_update = $TYPO3_DB->exec_UPDATEquery('pages', $where_clause_page, $pages_fields_update);
	    } elseif(version_compare(TYPO3_version, '8.0', '>=')) {
		    $page_update = $pagesQueryBuilder
			    ->update('pages')
			    ->where($pagesQueryBuilder->expr()->eq('uid', $pagesQueryBuilder->createNamedParameter($pageId, \PDO::PARAM_INT)))
				->set('tstamp',time())
			    ->set('module',$newIcon)
			    ->execute();
	    }

        //Reload the page tree
        if($page_update) {
            BackendUtility::setUpdateSignal('updatePageTree');
        }
        $this->forward('list');
    }

    /**
     * action editPageProperties
     * @return void
     */
     public function editPagePropertiesAction() {

         $pageId = $this->request->getArgument('pageId');

	     /** @var \TYPO3\CMS\Backend\Routing\UriBuilder $uriBuilder */
	     $uriBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Backend\Routing\UriBuilder::class);
	     $sReturnUrl = (string)$uriBuilder->buildUriFromRoute('web_RtPagesTreeIconsMod1', [ 'id' => $pageId ]);
	     $urlEditPage = (string)$uriBuilder->buildUriFromRoute('record_edit', [
		     'edit[pages][' . $pageId . ']' => 'edit',
		     'pageId' => $pageId,
		     'returnUrl' => $sReturnUrl
	     ]);
         $this->response->setStatus(303);
         $this->response->setHeader('Location', $urlEditPage);
     }

    /**
     * utils get Page Icon
     * @param $pageId
     * @return string $pageIcon
     */

    protected function getPageIcon($pageId) {
        $tce = GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\DataHandler::class);
        $pageIcon = $tce->pageInfo($pageId,'module');
        return $pageIcon;
    }

    /**
     * utils get Page Icon
     * @param $pageId
     * @return string $pageIcon
     */

    protected function getPageType($pageId) {
        $tce = GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\DataHandler::class);
        $pageType = $tce->pageInfo($pageId,'doktype');
        return $pageType;
    }

    /**
     * utils get Is site root
     * @param $pageId
     * @return boolean $isSiteRoot
     */

    protected function isSiteRoot($pageId) {
        $tce = GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\DataHandler::class);
        $isSiteRoot = $tce->pageInfo($pageId,'is_siteroot');
        return $isSiteRoot;
    }

    /**
     * utils get Is navigation hidden
     * @param $pageId
     * @return boolean $isNavHide
     */

    protected function isNavHide($pageId) {
        $tce = GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\DataHandler::class);
        $isNavHide = $tce->pageInfo($pageId,'nav_hide');
        return $isNavHide;
    }

    /**
     * utils get Page title
     * @param $pageId
     * @return string $pageTitle
     */

    protected function getPageTitle($pageId) {
        $tce = GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\DataHandler::class);
        $pageTitle = $tce->pageInfo($pageId,'title');
        return $pageTitle;
    }
}