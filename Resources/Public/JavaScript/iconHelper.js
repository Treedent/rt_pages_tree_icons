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

define('SYRADEV/RtPagesTreeIcons/iconHelper', ['TYPO3/CMS/Backend/Notification'], (Notification) => {

    'use strict';

    const iconsContainer = document.querySelector('#icons-container');
    const newIconContainer = document.querySelector('#new-icon-container');
    const iconName = document.querySelector('#iconName');
    const iconSize = document.querySelector('#iconSize');
    const icon = document.querySelector('#icon');
    const copyBtn = document.querySelector('#copyBtn');
    const copySuccessTitle = document.querySelector('#copySuccessTitle');
    const copySuccessMessage = document.querySelector('#copySuccessMessage');
    const semiTransparent = document.querySelector('#semitransparent');
    const searchWords = document.querySelector('#search-words');

    iconsContainer.addEventListener('click', (e) => {
        const li = e.target.closest('li');
        if (li && li.dataset.icon !== undefined) {
            getSiblings(li).forEach(icon => {
                icon.classList.remove('icon-current');
            });
            li.classList.add('icon-current');
            iconName.value = li.dataset.icon;
            setNewIcon();
        }
    }, true);

    iconSize.addEventListener('change', () => {
        setNewIcon();
    });

    semiTransparent.addEventListener('click', () => {
        setNewIcon();
    });

    let setNewIcon = () => {
        require(['TYPO3/CMS/Core/Ajax/AjaxRequest'], (AjaxRequest) => {
            const body = {
                newIconName: iconName.value,
                newIconSize: iconSize.value,
                semiTransparent: semiTransparent.checked
            };
            const init = {
                mode: 'cors'
            };
            const request = new AjaxRequest(TYPO3.settings.ajaxUrls.set_newIcon);
            request.post(body, init).then(
                async (response) => {
                    const reponse = await response.resolve();
                    icon.value = reponse.newIconInfos.icon
                    newIconContainer.innerHTML = reponse.newIconInfos.partialView;
                }, (error) => {
                    console.error('Request failed because of error: ' + error.status + ' ' + error.statusText);
                }
            );
        });
    };

    copyBtn.addEventListener('click', () => {
        const vh2copy = `<core:icon identifier="${icon.value}" size="${iconSize.value}"/>`;
        navigator.clipboard.writeText(vh2copy).then(() => {
            Notification.success(
                copySuccessTitle.value,
                copySuccessMessage.value
            );
        })
    });

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

    let loadIcons = () => {
        require(['TYPO3/CMS/Core/Ajax/AjaxRequest'], (AjaxRequest) => {
            const body = {
                action: 'iconsHelper'
            };
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
    };

    require(['TYPO3/CMS/Backend/Input/Clearable'], function () {
        if (searchWords !== null) {
            searchWords.clearable(
                {
                    onClear: function () {
                        iconsContainer.innerHTML = spinner;
                        loadIcons();
                    }
                }
            );
        }
    });

    loadIcons();

});








