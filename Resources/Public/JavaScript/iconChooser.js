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

define('SYRADEV/RtPagesTreeIcons/pageIconChanger', () => {

    'use strict';

    const pagesIconsContainer = document.querySelector('#icons-container');
    const newIcon = document.querySelector('#newIcon');
    const newSubIcon = document.querySelector('#newSubIcon');
    const setsubpages = document.querySelector('a[data-name="_setsubpages"]');
    const setSubpagesIconsForm = document.querySelector('#setSubpagesIconsForm');
    const iconsContainer = document.querySelector('#icons-container');
    const pageId = document.querySelector('#pageId');
    const pageModule = document.querySelector('#pageModule');
    const pageDoktype = document.querySelector('#pageDoktype');
    const pageNavHide = document.querySelector('#pageNavHide');
    const pageIsSiteroot = document.querySelector('#pageIsSiteroot');

    let getSiblings = function (e) {
        let siblings = [];
        if (!e.parentNode) {
            return siblings;
        }
        let sibling = e.parentNode.firstChild;
        while (sibling) {
            if (sibling.nodeType === 1 && sibling !== e) {
                siblings.push(sibling);
            }
            sibling = sibling.nextSibling;
        }
        return siblings;
    };

    if (pagesIconsContainer !== null) {
        pagesIconsContainer.addEventListener('click', (e) => {
            const li = e.target.closest('li');
            getSiblings(li).forEach(icon => {
                icon.classList.remove('icon-current');
            });
            li.classList.add('icon-current');
            newIcon.value = li.dataset.icon;
            newSubIcon.value = li.dataset.icon;
        }, true);
    }

    if (setsubpages !== null) {
        setsubpages.addEventListener('click', (e) => {
            let linkAction = e.currentTarget;
            if (linkAction.dataset.value === '2') {
                setSubpagesIconsForm.submit();
            }
        });
    }

    if (pageId !== null) {
        require(['TYPO3/CMS/Core/Ajax/AjaxRequest'], (AjaxRequest) => {
            let body = {
                pageId: parseInt(pageId.value),
                pageModule: pageModule.value,
                pageDoktype: pageDoktype.value,
                pageNavHide: pageNavHide.value,
                pageIsSiteroot: pageIsSiteroot.value
            }
            const init = {
                mode: 'cors'
            };
            const request = new AjaxRequest(TYPO3.settings.ajaxUrls.get_allIcons);
            request.post(body, init).then(
                async (response) => {
                    iconsContainer.innerHTML = await response.resolve();
                }, (error) => {
                    console.error('Request failed because of error: ' + error.status + ' ' + error.statusText);
                }
            );
        });
    }
});