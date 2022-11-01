<?php

namespace SYRADEV\RtPagesTreeIcons\Controller;

use TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Package\Exception;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2022 Regis TEDONE <regis.tedone@gmail.com>, SYRADEV
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
class PageIconsController extends ActionController
{
    /**
     * action list
     *
     * @return void display
     * @throws Exception
     */
public function listAction()
    {

        $urlvars = $_GET;
        $pageId = $urlvars['pageId'] ?? $urlvars['id'];
        $page0 = (int)$pageId === 0 || $pageId === null;

        $langFile = 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf';

        $pageIconClass = '';

        //Get Page Icon
        $pageIconName = $this->getPageIcon($pageId);

        // Get Page Type
        $pageType = (string)$this->getPageType($pageId);

        // Get Page Menu State
        $pageMenuState = $this->getPageMenuState($pageId);

        // Get Page Hidden State
        $pageIsHidden = $this->isHidden($pageId);

        // Get Page Is Limited In Time
        $pageIsLimitedInTime = $this->isLimitedInTime($pageId);

        // Get Page Access Group
        $pageGroupAccess = $this->getPageGroupAccess($pageId);

        // Default page type label

        $pageTypeLabel = match ($pageType) {
            '3' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.doktype.I.8',
            '4' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.doktype.I.2',
            '6' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.doktype.I.4',
            '7' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.doktype.I.5',
            '199' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.doktype.I.7',
            '254' => $langFile . ':doktype.I.1',
            '255' => $langFile . ':doktype.I.2',
            default => $langFile . ':doktype.I.0',
        };

        $defaultPageIconClass = $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$pageType];
        if ($this->isNavHide($pageId)) {
            $defaultPageIconClass = $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$pageType . '-hideinmenu'];
        }
        if ($this->isSiteRoot($pageId)) {
            $defaultPageIconClass = $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$pageType . '-root'];
        }

        // Set default icon
        $default_label = LocalizationUtility::translate('defaultPageType', 'rt_pages_tree_icons');
        $icons[0] = [$default_label, '', $defaultPageIconClass, 'svg', 'default'];

        $selectedIcon = '';
        $tabs = [];

        foreach ($GLOBALS['TCA']['pages']['columns']['module']['config']['items'] as $declared_icons) {

            // declared_icons
            // 0 > label
            // 1 > icon id
            // 2 > class
            // 3 > type
            // 4 > category

            if (empty($declared_icons[4])) {
                $declared_icons[4] = 'default';
            }

            if (empty($declared_icons[0])) {
                continue;
            }

            //Get Page icon class
            if (!empty($pageIconName)) {
                if ($declared_icons[1] === $pageIconName || str_starts_with($pageIconName, $declared_icons[1])) {
                    $pageIconClass = $declared_icons[2];
                    $selectedIcon = $pageIconName;
                    $pIN = substr($pageIconName, -2);
                    if ($pIN === '-s' || $pIN === '-h') {
                        $selectedIcon = substr($pageIconName, 0, -2);
                    }

                    // Set tab
                    $tabs[$declared_icons[4]]['isactive'] = 'show active';
                }
            } else {
                $pageIconClass = $defaultPageIconClass;
                $tabs['default']['isactive'] = 'show active';
            }
            //Remove empty icons or Shortcut Icons
            $dis = substr($declared_icons[1], -2);
            if ($dis === '-s' || $dis === '-h') {
                continue;
            }
            //Remove gifs/png from your TYPO3 extensions, switch to SVG, please!
            if (str_ends_with($declared_icons[2], '.png')) {
                $declared_icons[3] = 'png';
            }
            if (str_ends_with($declared_icons[2], '.gif')) {
                $declared_icons[3] = 'gif';
            } else {
                $declared_icons[3] = 'svg';
            }
            if (str_starts_with($declared_icons[0], 'LLL')) {
                $declared_icons[0] = LocalizationUtility::translate($declared_icons[0], 'rt_pages_tree_icons');
            }
            $icons[] = $declared_icons;
        }

        $this->view->assignMultiple([
            'version' => ExtensionManagementUtility::getExtensionVersion('rt_pages_tree_icons'),
            'pageTypeLabel' => $pageTypeLabel,
            'icons' => $icons,
            'pageId' => $pageId,
            'pageIcon' => $pageIconClass,
            'selectedIcon' => $selectedIcon,
            'page0' => $page0,
            'pageTitle' => $this->getPageTitle($pageId),
            'tabs' => $tabs,
            'pageMenuState' => $pageMenuState,
            'pageIsHidden' => $pageIsHidden,
            'pageIsLimitedInTime' => $pageIsLimitedInTime,
            'pageGroupAccess' => $pageGroupAccess
        ]);
    }

    /**
     * action changePageIcon
     * @return ForwardResponse
     */
    public function changepageiconAction(): ForwardResponse
    {

        //Retrieve vars
        $postVars = GeneralUtility::_POST('tx_rtpagestreeicons_web_rtpagestreeiconsmod1');
        $newIcon = $postVars['newIcon'];

        $getVars = GeneralUtility::_GET('tx_rtpagestreeicons_web_rtpagestreeiconsmod1');
        $pageId = (int)$getVars['pageId'];

        $pageType = $this->getPageType($pageId);
        // Force Shortcut Icon
        if (($pageType === '4' && str_starts_with($newIcon, 'page')) || ($pageType === '4' && str_starts_with($newIcon, 'symbearth'))) {
            $newIcon .= '-s';
        }

        // Force Hidden in menu Icon
        $pageMenuState = $this->getPageMenuState($pageId);
        if ($pageMenuState == '1') {
            $newIcon .= '-h';
        }

        //Update page icon in database
        $page_update = false;

        $pagesQueryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $page_update = $pagesQueryBuilder
            ->update('pages')
            ->where($pagesQueryBuilder->expr()->eq('uid', $pagesQueryBuilder->createNamedParameter($pageId, \PDO::PARAM_INT)))
            ->set('tstamp', time())
            ->set('module', $newIcon)
            ->execute();


        //Reload the page tree
        if ($page_update) {
            BackendUtility::setUpdateSignal('updatePageTree');
        }
        return new ForwardResponse('list');
    }

    /**
     * action editPageProperties
     * @return void
     * @throws NoSuchArgumentException|RouteNotFoundException
     * @throws StopActionException
     */
    public function editPagePropertiesAction()
    {
        $pageId = $this->request->getArgument('pageId');
        $urlEditPage = '';

        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $sReturnUrl = (string)$uriBuilder->buildUriFromRoute('web_RtPagesTreeIconsMod1', ['id' => $pageId]);
        $urlEditPage = (string)$uriBuilder->buildUriFromRoute('record_edit', [
            'edit[pages][' . $pageId . ']' => 'edit',
            'pageId' => $pageId,
            'returnUrl' => $sReturnUrl
        ]);

        //typo3/record/edit?edit%5Bpages%5D%5B78%5D=edit&returnUrl=%2Ftypo3%2Fmodule%2Fweb%2Flayout%3Ftoken%3D903671f8161d33927b14304dd103c56fe4645063%26id%3D78
        //typo3/record/edit?token=f71e23906af03e3b5db54c784a28b305088bc21c&edit%5Bpages%5D%5B78%5D=edit&pageId=78&returnUrl=%2Ftypo3%2Fmodule%2Fweb%2FRtPagesTreeIconsMod1%3Ftoken%3D12532993c108b8c3c81d6c6306bfb0a028a70ac0%26id%3D78

        //$this->response->setStatus(303);
        //dd($urlEditPage);
        $this->redirect($urlEditPage);
    }

    /**
     * utils get Page Menu State
     * @param $pageId
     * @return bool|null
     */
    protected function getPageMenuState($pageId): bool|null
    {
        $tce = GeneralUtility::makeInstance(DataHandler::class);
        return $tce->pageInfo($pageId, 'nav_hide');
    }

    /**
     * utils get Page Icon
     * @param $pageId
     * @return string|null
     */
    protected function getPageIcon($pageId): string|null
    {
        $tce = GeneralUtility::makeInstance(DataHandler::class);
        return $tce->pageInfo($pageId, 'module');
    }

    /**
     * utils get Page Icon
     * @param $pageId
     * @return string|null
     */
    protected function getPageType($pageId): string|null
    {
        $tce = GeneralUtility::makeInstance(DataHandler::class);
        return $tce->pageInfo($pageId, 'doktype');
    }

    /**
     * Utils Get Is Site Root
     * @param $pageId
     * @return bool|null
     */
    protected function isSiteRoot($pageId): bool|null
    {
        $tce = GeneralUtility::makeInstance(DataHandler::class);
        return $tce->pageInfo($pageId, 'is_siteroot');
    }

    /**
     * Utils Get Is Hidden In Navigation
     * @param $pageId
     * @return bool|null
     */
    protected function isNavHide($pageId): bool|null
    {
        $tce = GeneralUtility::makeInstance(DataHandler::class);
        return $tce->pageInfo($pageId, 'nav_hide');
    }

    /**
     * Utils Get Is Page Hidden
     * @param $pageId
     * @return bool|null
     */
    protected function isHidden($pageId): bool|null
    {
        $tce = GeneralUtility::makeInstance(DataHandler::class);
        return $tce->pageInfo($pageId, 'hidden');
    }

    /**
     * Utils Get Is Limited In Time
     * @param $pageId
     * @return boolean
     */
    protected function isLimitedInTime($pageId): bool
    {
        $tce = GeneralUtility::makeInstance(DataHandler::class);
        return $tce->pageInfo($pageId, 'starttime') > 0 || $tce->pageInfo($pageId, 'endtime') > 0;
    }

    /**
     * Utils Get Page Title
     * @param $pageId
     * @return string|null
     */
    protected function getPageTitle($pageId): string|null
    {
        $tce = GeneralUtility::makeInstance(DataHandler::class);
        return $tce->pageInfo($pageId, 'title');
    }

    /**
     * Utils Get Page Group Access
     * @param $pageId
     * @return string|null
     */
    protected function getPageGroupAccess($pageId): string|null
    {
        $tce = GeneralUtility::makeInstance(DataHandler::class);
        return $tce->pageInfo($pageId, 'fe_group');
    }
}