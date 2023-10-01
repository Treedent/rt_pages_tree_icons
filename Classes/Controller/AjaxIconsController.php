<?php

declare(strict_types=1);

namespace Syradev\RtPagesTreeIcons\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

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


/**
 * Ajax Icons Controller
 */
final class AjaxIconsController extends ActionController
{

    /**
     * Ajax function to render All icons listed by category
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function getAllIconsAction(ServerRequestInterface $request): ResponseInterface
    {
        $postVars = $request->getParsedBody();
        $pageModule = $selectedIcon = '';
        $tab = 'default';
        $icons = [];

        if(isset($postVars['action']) && $postVars['action']==='iconsHelper') {
            $tab='symbol';
            $selectedIcon = 'symbcocotier';
        } else {
            $pageModule = $postVars['pageModule'];
            $pageDoktype = $postVars['pageDoktype'];
            $pageNavHide = (bool)$postVars['pageNavHide'];
            $pageIsSiteroot = (bool)$postVars['pageIsSiteroot'];
            $defaultPageIcon = $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$pageDoktype];
            if ($pageNavHide) {
                $defaultPageIcon = $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$pageDoktype . '-hideinmenu'];
            }
            if ($pageIsSiteroot) {
                $defaultPageIcon = $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$pageDoktype . '-root'];
            }
            // Set first icon : default page type
            $icons[0] = [
                LocalizationUtility::translate('defaultPageType', 'rt_pages_tree_icons'),
                '',
                $defaultPageIcon,
                'default',
                'svg'
            ];
        }

        foreach ($GLOBALS['TCA']['pages']['columns']['module']['config']['items'] as $declared_icons) {

            $declared_icons = array_values($declared_icons);

            // --- V12
            // 0 => label
            // 1 => value
            // 2 => icon
            // 3 => group
            // 4 => description

            if ($declared_icons[1] === 'fe_users') {
                continue;
            }

            if (empty($declared_icons[3])) {
                $declared_icons[3] = 'default';
            }

            if (empty($declared_icons[0])) {
                continue;
            }

            //Get Page icon class
            if (!empty($pageModule)) {
                if ($declared_icons[1] === $pageModule) {
                    $selectedIcon = $pageModule;
                    if(str_ends_with($pageModule, '-s') || str_ends_with($pageModule, '-h')) {
                        $selectedIcon = substr($pageModule, 0, -2);
                    }
                    // Set tab
                    $tab = $declared_icons[3];
                }
            }

            //Remove empty icons or Shortcut Icons
            if( str_ends_with($declared_icons[1], '-s') || str_ends_with($declared_icons[1], '-h') ) {
                continue;
            }

            // Some default icons have no description
            if (!isset($declared_icons[4])) {
                $declared_icons[4] = 'svg';
            }

            // Get icons label
            if (str_starts_with($declared_icons[0], 'LLL')) {
                $declared_icons[0] = LocalizationUtility::translate($declared_icons[0], 'rt_pages_tree_icons');
            }
            $icons[] = $declared_icons;
        }

        $iconsVars = [
            'icons'         => $icons,
            'tab'           => $tab,
            'selectedIcon'  => $selectedIcon
        ];
        $partialView = $this->getPartialTemplate('PageIcons/AllIcons',$iconsVars);
        $response = $this->responseFactory->createResponse()->withHeader('Content-Type', 'text/html; charset=utf-8');
        $response->getBody()->write($this->minify($partialView));
        return $response;
    }

    /**
     * Ajax function to render Selected helper icon
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \JsonException
     */
    public function setNewIconAction(ServerRequestInterface $request): ResponseInterface
    {
        $postVars = $request->getParsedBody();
        extract($postVars);

        /** @var $newIconName */
        /** @var $newIconSize */
        /** @var $semiTransparent */

        $newIcon = [];

        foreach ($GLOBALS['TCA']['pages']['columns']['module']['config']['items'] as $declared_icons) {
            $declared_icons = array_values($declared_icons);
            if ($declared_icons[1] === $newIconName) {
                $newIcon = [
                    'icon' => $declared_icons[2],
                    'iconSize' => $newIconSize
                ];
                if($semiTransparent==='true') {
                    $newIcon['icon'] .= '-h';
                }
                break;
            }
        }
        $partialView = $this->minify($this->getPartialTemplate('PageIcons/NewIcon', $newIcon));
        $newIconInfos = [
            'partialView' => $partialView,
            'icon' => $newIcon['icon']
        ];
        $response = $this->responseFactory->createResponse()->withHeader('Content-Type', 'application/json; charset=utf-8');
        $response->getBody()->write(json_encode(['newIconInfos' => $newIconInfos], JSON_THROW_ON_ERROR));
        return $response;
    }

    /**
     * Minify HTML
     * @param string $html
     * @return string
     */
    private function minify(string $html=''): string
    {
        $sr = array(
            '/\/\*\*.\*\//' => ' ',
            '/\n/' => ' ',
            '/\t/' => ' ',
            '/[ ]+/' => ' ',
            '/\>\s\<(?:(?!(?:a|b|strong|img|em|i|span|small|big)[ ]))/' => '><'
        );
        return preg_replace(array_keys($sr), array_values($sr), $html);
    }


    /**
     * Get partial template html from its name
     *
     * @param string $partialName
     * @param array $variables
     * @return string
     */
    private function getPartialTemplate(string $partialName, array $variables=[]): string
    {
        $extTemplatePath = 'EXT:rt_pages_tree_icons/Resources/Private/';
        $standaloneView = GeneralUtility::makeInstance(StandaloneView::class);
        $standaloneView->setFormat('html');
        $standaloneView->setPartialRootPaths([GeneralUtility::getFileAbsFileName($extTemplatePath . 'Partials')]);
        return $standaloneView->renderPartial($partialName, NULL, $variables);
    }
}