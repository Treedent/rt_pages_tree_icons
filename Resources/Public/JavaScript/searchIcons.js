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

define('SYRADEV/RtPagesTreeIcons/searchIcons', ['TYPO3/CMS/Backend/Notification'], (Notification) => {

    'use strict';

    const searchWords = document.querySelector('#search-words');
    const btnSearch = document.querySelector('#btn-search');
    const searchWarningTitle = document.querySelector('#searchWarningTitle');
    const searchWarningMessage = document.querySelector('#searchWarningMessage');
    const iconsContainer = document.querySelector('#icons-container');

    let loadResult = () => {
        require(['TYPO3/CMS/Core/Ajax/AjaxRequest'], (AjaxRequest) => {
            let body = {
                searchWords: searchWords.value
            }
            const init = {
                mode: 'cors'
            };
            const request = new AjaxRequest(TYPO3.settings.ajaxUrls.search_icons);
            request.post(body, init).then(
                async (response) => {
                    iconsContainer.innerHTML = await response.resolve();
                }, (error) => {
                    console.error('Request failed because of error: ' + error.status + ' ' + error.statusText);
                }
            );
        });
    };

    let doSearch = () => {
        if (searchWords.value.trim().length > 0) {
            iconsContainer.innerHTML = spinner;
            loadResult();
        } else {
            Notification.warning(
                searchWarningTitle.value,
                searchWarningMessage.value
            );
        }
    };

    btnSearch.addEventListener('click', () => {
        doSearch();
    });

    searchWords.addEventListener('keyup', (e) => {
        if (e.key === 'Enter') {
            doSearch();
        }
    });

});