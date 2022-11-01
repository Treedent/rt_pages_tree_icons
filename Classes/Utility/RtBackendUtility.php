<?php
namespace SYRADEV\RtPagesTreeIcons\Utility;

use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
 * RtBackendUtility
 */
class RtBackendUtility {

	/*
	* Retrieve an extension configuration
	* @param string $extensionKey Extension Key
	* @return array $extConf Extension configuration
    */
    /**
     * @throws ExtensionConfigurationExtensionNotConfiguredException;
     * @throws ExtensionConfigurationPathDoesNotExistException
     *
     */
    public static function getExtensionConfiguration($extensionKey) {
       return GeneralUtility::makeInstance(ExtensionConfiguration::class)->get($extensionKey);
    }
}