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

define('SYRADEV/RtPagesTreeIcons/pageIconChanger', () => {

    let getSiblings = function (e) {
        let siblings = [];
        if(!e.parentNode) {
            return siblings;
        }
        let sibling  = e.parentNode.firstChild;
        while (sibling) {
            if (sibling.nodeType === 1 && sibling !== e) {
                siblings.push(sibling);
            }
            sibling = sibling.nextSibling;
        }
        return siblings;
    };

    document.querySelectorAll('li.icon-container').forEach(container => {
        container.addEventListener('click', (e) => {
            getSiblings(e.currentTarget).forEach(icon => {
                icon.classList.remove('icon-current');
            });
            e.currentTarget.classList.add('icon-current');
            document.querySelector('#newIcon').value = e.currentTarget.dataset.icon;
        });
    });
});