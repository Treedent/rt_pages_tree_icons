<?php
namespace SYRADEV\RtPagesTreeIcons\Controller;

use TYPO3\CMS\Core\Package\Exception;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\DataHandling\DataHandler;

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


/**
 * PageIconsController
 */
class PageIconsController extends ActionController {

	/**
	 * action list
	 *
	 * @return void display
	 * @throws Exception
	 */
	public function listAction() {

		$urlvars = $_GET;
		$pageId = isset($urlvars['pageId']) ? $urlvars['pageId'] : $urlvars['id'];
		$page0 = false;
		if($pageId===0 || $pageId===null) {
			$page0 = true;
		}

		$langFile = 'LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf';
		if(version_compare(TYPO3_version, '8.0', '<')) {
			$langFile = 'LLL:EXT:lang/locallang_tca.xlf';
		}
		if(version_compare(TYPO3_version, '8.0', '>=')) {
			  $langFile = 'LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf';
		}
		if(version_compare(TYPO3_version, '9.0', '>=')) {
			$langFile = 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf';
		}

		$pageIconClass = '';

		//Get Page Icon
		$pageIconName = $this->getPageIcon($pageId);

		// Get Page Type
		$pageType = (string) $this->getPageType( $pageId );

		// Get Page Menu State
		$pageMenuState = $this->getPageMenuState($pageId);

		// Get Page Hidden State
		$pageIsHidden = $this->isHidden($pageId);

		// Get Page Is Limited In Time
		$pageIsLimitedInTime = $this->isLimitedInTime($pageId);

		// Get Page Access Group
		$pageGroupAccess = $this->getPageGroupAccess($pageId);

		// Default page type label
		$pageTypeLabel = $langFile . ':doktype.I.0';

		switch($pageType) {
			/* DOKTYPE_DEFAULT */
			case '1':
				$pageTypeLabel = $langFile . ':doktype.I.0';
				break;

			/* DOKTYPE_LINK */
			case '3':
				$pageTypeLabel = 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.doktype.I.8';
				break;

			/* DOKTYPE_SHORTCUT */
			case '4':
				$pageTypeLabel = 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.doktype.I.2';
				break;

			/* DOKTYPE_BE_USER_SECTION */
			case '6':
				$pageTypeLabel = 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.doktype.I.4';
				break;

			/* DOKTYPE_MOUNTPOINT */
			case '7':
				$pageTypeLabel = 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.doktype.I.5';
				break;

			/* DOKTYPE_SPACER */
			case '199':
				$pageTypeLabel = 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.doktype.I.7';
				break;

			/* DOKTYPE_SYSFOLDER */
			case '254':
				$pageTypeLabel = $langFile . ':doktype.I.1';
				break;

			/* DOKTYPE_RECYCLER */
			case '255':
				$pageTypeLabel = $langFile . ':doktype.I.2';
				break;
		}

		$defaultPageIconClass = $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$pageType];
		if($this->isNavHide($pageId)) {
			$defaultPageIconClass = $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$pageType . '-hideinmenu'];
		}
		if($this->isSiteRoot($pageId)) {
			$defaultPageIconClass = $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$pageType . '-root'];
		}
		
		// Set default icon
		$default_label = LocalizationUtility::translate('defaultPageType', 'rt_pages_tree_icons');
		$icons[0] = [ $default_label, '', $defaultPageIconClass, 'svg', 'default'];

		$selectedIcon = '';
		$tabs = [];

		foreach($GLOBALS['TCA']['pages']['columns']['module']['config']['items'] as $declared_icons) {

			// declared_icons
			// 0 > label
			// 1 > icon id
			// 2 > class
			// 3 > type
			// 4 > category

			if(empty($declared_icons[4])) {
				$declared_icons[4] = 'default';
			}

			if(empty($declared_icons[0])) {
				continue;
			}

			//Get Page icon class
			if(!empty($pageIconName)) {
				if($declared_icons[1]===$pageIconName || strpos( $pageIconName, $declared_icons[1] ) === 0 ) {
					$pageIconClass = $declared_icons[2];
					$selectedIcon = $pageIconName;
					$pIN = substr($pageIconName,-2);
					if($pIN === '-s' || $pIN === '-h') {
						$selectedIcon = substr($pageIconName,0,-2);
					}

					// Set tab
					$tabs[$declared_icons[4]]['isactive'] = 'in active';
				}
			} else {
				$pageIconClass = $defaultPageIconClass;
				$tabs['default']['isactive'] = 'in active';
			}
			//Remove empty icons or Shortcut Icons
			$dis = substr($declared_icons[1],-2);
			if(empty($declared_icons[0]) || $dis === '-s' || $dis === '-h') {
				continue;
			}
			//Remove gifs/png from your TYPO3 extensions, switch to SVG, please!
			if(substr($declared_icons[2], -4) ==='.png') {
				$declared_icons[3] = 'png';
			}
			if(substr($declared_icons[2], -4) ==='.gif') {
				$declared_icons[3] = 'gif';
			} else {
				$declared_icons[3] = 'svg';
			}
			if( strpos( $declared_icons[0], 'LLL' ) === 0 ) {
				$declared_icons[0] = LocalizationUtility::translate($declared_icons[0], 'rt_pages_tree_icons');
			}
			$icons[] = $declared_icons;
		}

		$this->view->assignMultiple([
			'version'               => ExtensionManagementUtility::getExtensionVersion('rt_pages_tree_icons'),
			'pageTypeLabel'         => $pageTypeLabel,
			'icons'                 => $icons,
			'pageId'                => $pageId,
			'pageIcon'              => $pageIconClass,
			'selectedIcon'          => $selectedIcon,
			'page0'                 => $page0,
			'pageTitle'             => $this->getPageTitle($pageId),
			'tabs'                  => $tabs,
			'pageMenuState'         => $pageMenuState,
			'pageIsHidden'          => $pageIsHidden,
			'pageIsLimitedInTime'   => $pageIsLimitedInTime,
			'pageGroupAccess'       => $pageGroupAccess
		]);
	}

	/**
	 * action changePageIcon
	 * @return void
	 * @throws StopActionException
	 */
	public function changepageiconAction() {

		//Retrieve vars
		$postVars = GeneralUtility::_POST('tx_rtpagestreeicons_web_rtpagestreeiconsmod1');
		$newIcon = $postVars['newIcon'];

		$getVars = GeneralUtility::_GET('tx_rtpagestreeicons_web_rtpagestreeiconsmod1');
		$pageId = (int) $getVars['pageId'];

		$pageType = $this->getPageType($pageId);
		// Force Shortcut Icon
		if( ( $pageType === '4' && strpos( $newIcon, 'page' ) === 0 ) || ( $pageType === '4' && strpos( $newIcon, 'symbearth' ) === 0 ) ) {
			$newIcon.= '-s';
		}

		// Force Hidden in menu Icon
		$pageMenuState = $this->getPageMenuState($pageId);
		if($pageMenuState === '1') {
			$newIcon.= '-h';
		}

		//Update page icon in database
		$page_update = false;
		if(version_compare(TYPO3_version, '8.0', '<')) {
			global $TYPO3_DB;
			$where_clause_page = "`uid`='" . $pageId . "'";
			$pages_fields_update = [
				'tstamp'=>time(),
				'module' =>$newIcon
			];
			$page_update = $TYPO3_DB->exec_UPDATEquery('pages', $where_clause_page, $pages_fields_update);
		} elseif(version_compare(TYPO3_version, '8.0', '>=')) {
			$pagesQueryBuilder =  GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getQueryBuilderForTable('pages');
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
	 * @throws NoSuchArgumentException
	 */
	public function editPagePropertiesAction() {
		$pageId = $this->request->getArgument('pageId');
		$urlEditPage = '';
		if(version_compare(TYPO3_version, '9.0', '<')) {
			$sReturnUrl = BackendUtility::getModuleUrl( 'web_RtPagesTreeIconsMod1', [
				'id' => $pageId
			]);
			$urlEditPage = BackendUtility::getModuleUrl('record_edit', [
				'edit[pages][' . $pageId . ']' => 'edit',
				'pageId' => $pageId,
				'returnUrl' => $sReturnUrl
			]);
		} elseif(version_compare(TYPO3_version, '9.0', '>=')) {
			$uriBuilder = GeneralUtility::makeInstance( UriBuilder::class );
			$sReturnUrl = (string)$uriBuilder->buildUriFromRoute('web_RtPagesTreeIconsMod1', [ 'id' => $pageId ]);
			$urlEditPage = (string)$uriBuilder->buildUriFromRoute('record_edit', [
				'edit[pages][' . $pageId . ']' => 'edit',
				'pageId' => $pageId,
				'returnUrl' => $sReturnUrl
			]);
		}
		$this->response->setStatus(303);
		$this->response->setHeader('Location', $urlEditPage);
	}

	/**
	 * utils get Page Menu State
	 * @param $pageId
	 * @return boolean
	 */
	protected function getPageMenuState($pageId) {
		$tce = GeneralUtility::makeInstance( DataHandler::class );
		return $tce->pageInfo($pageId,'nav_hide');
	}

	/**
	 * utils get Page Icon
	 * @param $pageId
	 * @return string
	 */
	protected function getPageIcon($pageId) {
		$tce = GeneralUtility::makeInstance( DataHandler::class );
		return $tce->pageInfo($pageId,'module');
	}

	/**
	 * utils get Page Icon
	 * @param $pageId
	 * @return string
	 */
	protected function getPageType($pageId) {
		$tce = GeneralUtility::makeInstance( DataHandler::class );
		return $tce->pageInfo($pageId,'doktype');
	}

	/**
	 * Utils Get Is Site Root
	 * @param $pageId
	 * @return boolean
	 */
	protected function isSiteRoot($pageId) {
		$tce = GeneralUtility::makeInstance( DataHandler::class );
		return $tce->pageInfo($pageId,'is_siteroot');
	}

	/**
	 * Utils Get Is Hidden In Navigation
	 * @param $pageId
	 * @return boolean
	 */
	protected function isNavHide($pageId) {
		$tce = GeneralUtility::makeInstance( DataHandler::class );
		return $tce->pageInfo($pageId,'nav_hide');
	}

	/**
	 * Utils Get Is Page Hidden
	 * @param $pageId
	 * @return boolean
	 */
	protected function isHidden($pageId) {
		$tce = GeneralUtility::makeInstance( DataHandler::class );
		return $tce->pageInfo($pageId,'hidden');
	}

	/**
	 * Utils Get Is Limited In Time
	 * @param $pageId
	 * @return boolean
	 */
	protected function isLimitedInTime($pageId) {
		$tce = GeneralUtility::makeInstance( DataHandler::class );
		return $tce->pageInfo($pageId,'starttime') > 0 || $tce->pageInfo($pageId,'endtime') > 0;
	}

	/**
	 * Utils Get Page Title
	 * @param $pageId
	 * @return string
	 */
	protected function getPageTitle($pageId) {
		$tce = GeneralUtility::makeInstance( DataHandler::class );
		return $tce->pageInfo($pageId,'title');
	}

	/**
	 * Utils Get Page Group Access
	 * @param $pageId
	 * @return integer
	 */
	protected function getPageGroupAccess($pageId) {
		$tce = GeneralUtility::makeInstance( DataHandler::class );
		return $tce->pageInfo($pageId,'fe_group');
	}
}