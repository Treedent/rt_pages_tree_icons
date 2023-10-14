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

declare(strict_types=1);

namespace Syradev\RtPagesTreeIcons\Controller;

use PDO;
use Psr\Http\Message\ResponseInterface;
use Syradev\RtPagesTreeIcons\Components\Search\SearchBar;
use TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Backend\Tree\Repository\PageTreeRepository;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Error\Exception;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Package\Exception as T3Exception;
use TYPO3\CMS\Core\Type\Bitmask\Permission;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Page Icons Controller
 */
final class PageIconsController extends ActionController
{

    /**
     * @var ModuleTemplateFactory The module template factory
     */
    private ModuleTemplateFactory $moduleTemplateFactory;

    /**
     * @var IconFactory The icon factory
     */
    private IconFactory $iconFactory;

    /**
     * @var ModuleTemplate The module template
     */
    private ModuleTemplate $moduleTemplate;

    /**
     * Page Icons Module Constructor
     * @param ModuleTemplateFactory $moduleTemplateFactory
     * @param IconFactory $iconFactory
     */
    public function __construct(ModuleTemplateFactory $moduleTemplateFactory, IconFactory $iconFactory)
    {
        $this->moduleTemplateFactory = $moduleTemplateFactory;
        $this->iconFactory = $iconFactory;
    }

    /**
     * action list
     *
     * @return ResponseInterface display
     * @throws T3Exception
     */
    public function listAction(): ResponseInterface
    {

        $version = ExtensionManagementUtility::getExtensionVersion('rt_pages_tree_icons');
        if (str_starts_with($version, 'v')) {
            $version = substr($version, 1);
        }
        $pageId = 0;
        if (GeneralUtility::_GET('id') !== null) {
            $pageId = (int)GeneralUtility::_GET('id');
        }
        $page0 = $pageId === 0;

        //Get Page Icon
        if (!$page0) {

            // Get page information
            $pageInfos = $this->getPageInfos($pageId);

            // Get page type label
            $frontendLangFile = 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf';
            $coreLangFile = 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf';
            $pageInfos['pageTypeLabel'] = match ($pageInfos['doktype']) {
                3 => $frontendLangFile . ':pages.doktype.I.8',
                4 => $frontendLangFile . ':pages.doktype.I.2',
                6 => $frontendLangFile . ':pages.doktype.I.4',
                7 => $frontendLangFile . ':pages.doktype.I.5',
                199 => $frontendLangFile . ':pages.doktype.I.7',
                254 => $coreLangFile . ':doktype.I.1',
                255 => $coreLangFile . ':doktype.I.2',
                default => $coreLangFile . ':doktype.I.0',
            };

            // Get page real icon name
            if (empty($pageInfos['module'])) {
                // Get page default icon
                $pageInfos['pageIcon'] = $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$pageInfos['doktype']];
                if ($pageInfos['nav_hide']) {
                    $pageInfos['pageIcon'] = $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$pageInfos['doktype'] . '-hideinmenu'];
                }
                if ($pageInfos['is_siteroot']) {
                    $pageInfos['pageIcon'] = $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$pageInfos['doktype'] . '-root'];
                }
            } else {
                $pageInfos['pageIcon'] = $this->getPageIcon($pageInfos['module']);
            }

            $searchWarningTitle = LocalizationUtility::translate('actionmenu.list', 'rt_pages_tree_icons');
            $searchWarningMessage = LocalizationUtility::translate('search.warning', 'rt_pages_tree_icons');

            // Send page infos to view
            $this->view->assignMultiple([
                'version' => $version,
                'pageId' => $pageId,
                'page0' => false,
                'pageInfos' => $pageInfos,
                'searchWarningTitle' => $searchWarningTitle,
                'searchWarningMessage' => $searchWarningMessage
            ]);

        } else {
            $this->view->assignMultiple([
                'version' => $version,
                'page0' => true
            ]);
        }

        $perms_clause = $this->getBackendUser()->getPagePermsClause(Permission::PAGE_SHOW);
        $pageAcess = BackendUtility::readPageAccess($pageId, $perms_clause) ?: [];
        if ($pageAcess !== []) {
            $this->moduleTemplate->getDocHeaderComponent()->setMetaInformation($pageAcess);
        }

        $moduleTitle = LocalizationUtility::translate('module_title', 'rt_pages_tree_icons') . ' V' . $version;
        $this->moduleTemplate->setTitle($moduleTitle);
        $this->moduleTemplate->setContent($this->view->render());
        return $this->htmlResponse($this->moduleTemplate->renderContent());
    }

    /**
     * Utils: get Page Information
     * @param $pageId
     * @return array
     */
    private function getPageInfos($pageId): array
    {
        $pageInfos = [];
        $dhc = GeneralUtility::makeInstance(DataHandler::class);
        $pageInfos['module'] = $dhc->pageInfo($pageId, 'module');
        $pageInfos['title'] = $dhc->pageInfo($pageId, 'title');
        $pageInfos['doktype'] = (int)$dhc->pageInfo($pageId, 'doktype');
        $pageInfos['nav_hide'] = $dhc->pageInfo($pageId, 'nav_hide') === 1;
        $pageInfos['hidden'] = $dhc->pageInfo($pageId, 'hidden') === 1;
        $pageInfos['limited'] = $dhc->pageInfo($pageId, 'starttime') > 0 || $dhc->pageInfo($pageId, 'endtime') > 0;
        $pageInfos['fe_group'] = $dhc->pageInfo($pageId, 'fe_group');
        $pageInfos['is_siteroot'] = $dhc->pageInfo($pageId, 'is_siteroot') === 1;
        return $pageInfos;
    }

    /**
     * Get page real icon name
     * @param string $module
     * @return string
     */
    private function getPageIcon(string $module): string
    {
        $pageIcon = '';
        foreach ($GLOBALS['TCA']['pages']['columns']['module']['config']['items'] as $declared_icons) {
            $declared_icons = array_values($declared_icons);
            if ($declared_icons[1] === $module) {
                $pageIcon = $declared_icons[2];
                break;
            }
        }
        return $pageIcon;
    }

    /**
     * Utils: Returns an instance of BackendUserAuthentication
     * @return BackendUserAuthentication
     */
    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     * action icons helper
     *
     * @return ResponseInterface display
     */
    public function iconsHelperAction(): ResponseInterface
    {
        $majorVersion = GeneralUtility::makeInstance(Typo3Version::class)->getMajorVersion();
        $iconSizes = [];
        if ($majorVersion === 11) {
            $iconSizes = ['overlay' => 'Overlay - 1em', 'small' => 'Small - 16px', 'default' => 'Default - 32px', 'large' => 'Large - 48px'];
        }
        if ($majorVersion === 12) {
            $iconSizes = ['default' => 'Default - 1em', 'small' => 'Small - 16px', 'medium' => 'Medium - 32px', 'large' => 'Large - 48px', 'mega' => 'Mega - 64px'];
        }
        $moduleTitle = $copySuccessTitle = $searchWarningTitle = LocalizationUtility::translate('actionmenu.iconsHelper', 'rt_pages_tree_icons');
        $copySuccessMessage = LocalizationUtility::translate('copy.success', 'rt_pages_tree_icons');
        $searchWarningMessage = LocalizationUtility::translate('search.warning', 'rt_pages_tree_icons');
        $this->view->assignMultiple([
            'iconSizes' => $iconSizes,
            'copySuccessTitle' => $copySuccessTitle,
            'copySuccessMessage' => $copySuccessMessage,
            'searchWarningTitle' => $searchWarningTitle,
            'searchWarningMessage' => $searchWarningMessage
        ]);
        $this->moduleTemplate->setTitle($moduleTitle);
        $this->moduleTemplate->setContent($this->view->render());
        return $this->htmlResponse($this->moduleTemplate->renderContent());
    }

    /**
     * Action: change Page Icon
     * @return ForwardResponse
     * @throws Exception
     */
    public function changePageIconAction(): ForwardResponse
    {

        //Retrieve vars
        $postVars = $this->request->getParsedBody();
        extract($postVars);
        /** @var $newIcon */
        /** @var $pageId */

        // Get page information
        $pageInfos = $this->getPageInfos($pageId);
        // Force Shortcut Icon on certain icons
        if (($pageInfos['doktype'] === 4 && str_starts_with($newIcon, 'page')) || ($pageInfos['doktype'] === 4 && str_starts_with($newIcon, 'rpage')) || ($pageInfos['doktype'] === 4 && str_starts_with($newIcon, 'symbearth'))) {
            $newIcon .= '-s';
        }
        // Force Hidden in menu Icon
        if ($pageInfos['nav_hide']) {
            $newIcon .= '-h';
        }

        //Update page icon in database
        $pagesQueryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $page_update = $pagesQueryBuilder
            ->update('pages')
            ->where($pagesQueryBuilder->expr()->eq('uid', $pagesQueryBuilder->createNamedParameter($pageId, PDO::PARAM_INT)))
            ->set('tstamp', time())
            ->set('module', $newIcon)
            ->executeStatement();


        //Reload the page tree
        if ($page_update) {
            BackendUtility::setUpdateSignal('updatePageTree');
        }
        return new ForwardResponse('list');
    }

    /**
     * Action: change Subpages Icons
     * @return ForwardResponse
     * @throws Exception
     */
    public function changeSubpagesIconsAction(): ForwardResponse
    {

        //Retrieve vars
        $postVars = $this->request->getParsedBody();
        $newSubIcon = (string)$postVars['newSubIcon'];
        $pagePid = (int)$postVars['pagePid'];

        $subPages = $this->getSubpages($pagePid);
        $pagesQueryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        foreach ($subPages as $subPageId) {
            $module = $newSubIcon;
            $pageInfos = $this->getPageInfos($subPageId);
            // Force certain Shortcut Icon
            if (($pageInfos['doktype'] === 4 && str_starts_with($module, 'page')) || ($pageInfos['doktype'] === 4 && str_starts_with($module, 'rpage')) || ($pageInfos['doktype'] === 4 && str_starts_with($module, 'symbearth'))) {
                $module .= '-s';
            }
            // Force Hidden in menu Icon
            if ($pageInfos['nav_hide']) {
                $module .= '-h';
            }

            //Update page icon in database
            $page_update = $pagesQueryBuilder
                ->update('pages')
                ->where($pagesQueryBuilder->expr()->eq('uid', $pagesQueryBuilder->createNamedParameter($subPageId, PDO::PARAM_INT)))
                ->set('tstamp', time())
                ->set('module', $module)
                ->executeStatement();
        }
        //Reload the page tree
        BackendUtility::setUpdateSignal('updatePageTree');
        return new ForwardResponse('list');
    }

    /**
     * Initialize List Action
     * @return void
     * @throws RouteNotFoundException
     * @throws T3Exception
     */
    protected function initializeListAction(): void
    {
        $this->moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $this->addMenu();
        $this->addListButtons();
    }

    /**
     * @return void
     */
    private function addMenu(): void
    {
        $menuRegistry = $this->moduleTemplate->getDocHeaderComponent()->getMenuRegistry();
        $menu = $menuRegistry->makeMenu();
        $menu->setIdentifier('actionmenu');

        $menuItems = ['list', 'iconsHelper'];
        foreach ($menuItems as $key => $action) {
            $uri = $this->uriBuilder->reset()->uriFor($action, [], 'PageIcons');
            $isActive = $this->request->getControllerActionName() === $action;
            $title = LocalizationUtility::translate('actionmenu.' . $action, 'rt_pages_tree_icons');
            $menuItem = $menu->makeMenuItem()
                ->setTitle($title)
                ->setHref($uri)
                ->setActive($isActive);
            $menu->addMenuItem($menuItem);
        }
        $menuRegistry->addMenu($menu);
    }

    /**
     * Add the Buttons into the docheader for List View
     * @throws RouteNotFoundException
     * @throws T3Exception
     */
    private function addListButtons(): void
    {
        $buttonBar = $this->moduleTemplate->getDocHeaderComponent()->getButtonBar();
        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $pageId = 0;
        if (GeneralUtility::_GET('id') !== null) {
            $pageId = (int)GeneralUtility::_GET('id');
        }
        $moduleTitle = LocalizationUtility::translate('module_title', 'rt_pages_tree_icons');
        $version = ExtensionManagementUtility::getExtensionVersion('rt_pages_tree_icons');
        if (str_starts_with($version, 'v')) {
            $version = substr($version, 1);
        }

        // Save icon buttons
        if ($pageId > 0) {
            $saveButtonDropdown = $buttonBar->makeSplitButton();

            // Apply on current page
            $saveTitle = LocalizationUtility::translate('apply_current_page', 'rt_pages_tree_icons');
            $saveButton = $buttonBar->makeInputButton()
                ->setForm('setPageIconForm')
                ->setName('_setcurrentpage')
                ->setValue('1')
                ->setShowLabelText(true)
                ->setIcon($this->iconFactory->getIcon('actions-save', Icon::SIZE_SMALL))
                ->setTitle($saveTitle);
            $saveButtonDropdown->addItem($saveButton);

            // Apply on subpages
            if (!empty($this->getSubpages($pageId))) {
                $saveSubTitle = LocalizationUtility::translate('apply_subpages', 'rt_pages_tree_icons');
                $saveSubButton = $buttonBar->makeInputButton()
                    ->setForm('setSubpagesIconsForm')
                    ->setName('_setsubpages')
                    ->setValue('2')
                    ->setShowLabelText(true)
                    ->setIcon($this->iconFactory->getIcon('actions-arrow-right-down-alt', Icon::SIZE_SMALL))
                    ->setTitle($saveSubTitle);
                $saveButtonDropdown->addItem($saveSubButton);
                $buttonBar->addButton($saveButtonDropdown, ButtonBar::BUTTON_POSITION_LEFT, 1);
            } else {
                $buttonBar->addButton($saveButton, ButtonBar::BUTTON_POSITION_LEFT, 1);
            }

            // Search bar
            $specialButtonBar = GeneralUtility::makeInstance(SearchBar::class);
            $searchIcon = $this->iconFactory->getIcon('actions-search', Icon::SIZE_SMALL);
            $searchTitle = LocalizationUtility::translate('search.icon', 'rt_pages_tree_icons');
            $searchBar = $specialButtonBar->makeSearchBar()
                ->setTitle($searchTitle)
                ->setIcon($searchIcon);
            $buttonBar->addButton($searchBar, ButtonBar::BUTTON_POSITION_LEFT, 2);
        }

        // Module infos fake button
        $infosLabel = $moduleTitle . ' - V' . $version . ' - SYRADEV © ' . date('Y');
        $infosButton = $buttonBar->makeLinkButton()
            ->setHref('#')
            ->setTitle($infosLabel)
            ->setIcon($this->iconFactory->getIcon('actions-pagetree-change-page-icon', Icon::SIZE_SMALL))
            ->setShowLabelText(True)
            ->setClasses('btn-warning')
            ->setDisabled(true);
        $buttonBar->addButton($infosButton, ButtonBar::BUTTON_POSITION_LEFT, 3);

        // Edit page button
        if ($pageId > 0) {
            $sReturnUrl = (string)$uriBuilder->buildUriFromRoute('web_RtPagesTreeIconsRtptim1', ['id' => $pageId]);
            $urlEditPage = (string)$uriBuilder->buildUriFromRoute('record_edit', [
                'edit[pages][' . $pageId . ']' => 'edit',
                'returnUrl' => $sReturnUrl
            ]);
            $editPageTitle = $this->getLanguageService()->sL('LLL:EXT:backend/Resources/Private/Language/locallang_layout.xlf:editPageProperties');
            $editPageButton = $buttonBar->makeLinkButton()
                ->setHref($urlEditPage)
                ->setTitle($editPageTitle)
                ->setIcon($this->iconFactory->getIcon('actions-file-edit', Icon::SIZE_SMALL));
            $buttonBar->addButton($editPageButton, ButtonBar::BUTTON_POSITION_RIGHT, 3);
        }

        // Reload button
        $reloadTitle = $this->getLanguageService()->sL('LLL:EXT:core/Resources/Private/Language/locallang_common.xlf:reload');
        $reloadIcon = $this->iconFactory->getIcon('actions-refresh', Icon::SIZE_SMALL);
        $moduleUrl = (string)$uriBuilder->buildUriFromRoute('web_RtPagesTreeIconsRtptim1', ['id' => $pageId]);
        $reloadButton = $buttonBar->makeLinkButton()
            ->setHref($moduleUrl)
            ->setTitle($reloadTitle)
            ->setIcon($reloadIcon);
        $buttonBar->addButton($reloadButton, ButtonBar::BUTTON_POSITION_RIGHT, 4);

        // Shortcut button
        $majorVersion = GeneralUtility::makeInstance(Typo3Version::class)->getMajorVersion();
        $shortcutButton = $buttonBar->makeShortcutButton();
        if ($majorVersion === 11) {
            $shortcutButton->setRouteIdentifier('web_RtPagesTreeIconsRtptim1')
                ->setDisplayName($moduleTitle)
                ->setArguments([
                    'tx_rtpagestreeicons_web_rtpagestreeiconsrtptim1' => [
                        'action' => 'list',
                        'controller' => 'PageIcons'
                    ],
                ]);
        }
        if ($majorVersion === 12) {
            $shortcutButton->setRouteIdentifier('web_RtPagesTreeIconsRtptim1.PageIcons_list')
                ->setDisplayName($moduleTitle);
        }
        $buttonBar->addButton($shortcutButton, ButtonBar::BUTTON_POSITION_RIGHT, 5);
    }

    /**
     * Utils: get array of a page subpages ids
     * @param $pagePid
     * @return array
     */
    private function getSubpages($pagePid): array
    {
        $ptr = GeneralUtility::makeInstance(PageTreeRepository::class);
        $subpages = $ptr->getTree($pagePid)['_children'];
        $subpagesIds = [];
        foreach ($subpages as $subpage) {
            $subpagesIds[] = $subpage['uid'];
        }
        return ($subpagesIds);
    }

    /**
     * Utils: Returns an instance of LanguageService
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    /**
     * Initialize Icons Helper Action
     * @return void
     * @throws T3Exception
     */
    protected function initializeIconsHelperAction(): void
    {
        $this->moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $this->addMenu();
        $this->addHelperButtons();
    }

    /**
     * Add the Buttons into the docheader for Icons helper View
     * @return void
     * @throws T3Exception
     */
    private function addHelperButtons(): void
    {
        $buttonBar = $this->moduleTemplate->getDocHeaderComponent()->getButtonBar();
        $moduleTitle = LocalizationUtility::translate('actionmenu.iconsHelper', 'rt_pages_tree_icons');
        $version = ExtensionManagementUtility::getExtensionVersion('rt_pages_tree_icons');
        if (str_starts_with($version, 'v')) {
            $version = substr($version, 1);
        }

        // Search bar
        $specialButtonBar = GeneralUtility::makeInstance(SearchBar::class);
        $searchIcon = $this->iconFactory->getIcon('actions-search', Icon::SIZE_SMALL);
        $searchTitle = LocalizationUtility::translate('search.icon', 'rt_pages_tree_icons');
        $searchBar = $specialButtonBar->makeSearchBar()
            ->setTitle($searchTitle)
            ->setIcon($searchIcon);
        $buttonBar->addButton($searchBar, ButtonBar::BUTTON_POSITION_LEFT, 1);

        // Module infos fake button
        $infosLabel = $moduleTitle . ' - V' . $version . ' - SYRADEV © ' . date('Y');
        $infosButton = $buttonBar->makeLinkButton()
            ->setHref('#')
            ->setTitle($infosLabel)
            ->setIcon($this->iconFactory->getIcon('actions-pagetree-change-page-icon', Icon::SIZE_SMALL))
            ->setShowLabelText(True)
            ->setClasses('btn-warning')
            ->setDisabled(true);
        $buttonBar->addButton($infosButton, ButtonBar::BUTTON_POSITION_LEFT, 2);

        // Reload button
        $reloadTitle = $this->getLanguageService()->sL('LLL:EXT:core/Resources/Private/Language/locallang_common.xlf:reload');
        $reloadIcon = $this->iconFactory->getIcon('actions-refresh', Icon::SIZE_SMALL);
        $moduleUrl = $this->uriBuilder->reset()->uriFor('iconsHelper', [], 'PageIcons');
        $reloadButton = $buttonBar->makeLinkButton()
            ->setHref($moduleUrl)
            ->setTitle($reloadTitle)
            ->setIcon($reloadIcon);
        $buttonBar->addButton($reloadButton, ButtonBar::BUTTON_POSITION_RIGHT, 3);

        // Shortcut button
        $majorVersion = GeneralUtility::makeInstance(Typo3Version::class)->getMajorVersion();
        $shortcutButton = $buttonBar->makeShortcutButton();
        if ($majorVersion === 11) {
            $shortcutButton->setRouteIdentifier('web_RtPagesTreeIconsRtptim1')
                ->setDisplayName($moduleTitle)
                ->setArguments([
                    'tx_rtpagestreeicons_web_rtpagestreeiconsrtptim1' => [
                        'action' => 'iconsHelper',
                        'controller' => 'PageIcons'
                    ],
                ]);
        }
        if ($majorVersion === 12) {
            $shortcutButton->setRouteIdentifier('web_RtPagesTreeIconsRtptim1.PageIcons_iconsHelper')
                ->setDisplayName($moduleTitle);
        }
        $buttonBar->addButton($shortcutButton, ButtonBar::BUTTON_POSITION_RIGHT, 4);
    }
}