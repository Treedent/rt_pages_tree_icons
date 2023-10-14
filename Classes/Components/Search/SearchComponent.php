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

namespace Syradev\RtPagesTreeIcons\Components\Search;

use TYPO3\CMS\Backend\Template\Components\Buttons\AbstractButton;

/**
 * Search component
 *
 * This component type renders a regular search input and button tag with TYPO3s way to render
 * an input control and its button.
 **/
class SearchComponent extends AbstractButton
{

    /**
     * Renders the markup for the search component
     *
     * @return string
     */
    public function render():string
    {
        return '<div class="input-group input-group-sm form-control-clearable">
            <input type="search" class="form-control t3js-clearable" id="search-words" placeholder="' . $this->getTitle() . '" aria-describedby="btn-search" spellcheck="false">
            <button class="btn btn-outline-dark" type="button" id="btn-search">
                ' . $this->getIcon()->render() . '
            </button>
        </div>';
    }


    /**
     * Validates the current search component
     *
     * @return bool
     */
    public function isValid(): bool
    {
        if (
            trim($this->getTitle()) !== ''
            && $this->getType() === self::class
            && $this->getIcon() !== null
        ) {
            return true;
        }
        return false;
    }

    /**
     * Magic method so Fluid can access a button via {button}
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}