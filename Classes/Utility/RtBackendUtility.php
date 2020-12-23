<?php
namespace SYRADEV\RtPagesTreeIcons\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Registry;

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
 * RtBackendUtility
 */
class RtBackendUtility {

	/*
	* Retrieve an extension configuration
	* @param string $extensionKey Extension Key
	* @return array $extConf Extension configuration
    */
	public static function getExtensionConfiguration($extensionKey) {
		 $extConf ='';
	 	if(version_compare(TYPO3_version, '9.0', '<')) {
			 $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extensionKey]);
		 } elseif(version_compare(TYPO3_version, '9.0', '>=')) {
			 $extConf = GeneralUtility::makeInstance( \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class )->get($extensionKey);
		 }
		 return $extConf;
	 }

	/*
	* Write a new extension configuration
	* @param array $newConfiguration New configuration to write
	* @param string $extensionKey Extension Key
	* @return void
	*/
	 public static function writeConfiguration($newConfiguration, $extensionKey) {
		if ( version_compare( TYPO3_version, '9.0', '<' ) ) {
			$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'] = serialize( $newConfiguration );
			$objectManager = GeneralUtility::makeInstance( ObjectManager::class );
			$configurationUtility = $objectManager->get( TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility::class );
			$oldConfiguration = $configurationUtility->getCurrentConfiguration( $extensionKey );
			ArrayUtility::mergeRecursiveWithOverrule( $newConfiguration, $oldConfiguration );
			$configurationUtility->writeConfiguration(
				$configurationUtility->convertValuedToNestedConfiguration( $newConfiguration ),
				$extensionKey
			);
		}
	}

	/*
	* Write an array to the TYPO3 system registry
	* @param string $nameSpace The registry name space
	* @param string $key Extension Key
	* @param array $information The data to store in the registry
	* @return void
	*/
	public static function setT3Registry($nameSpace, $key, $information) {
		$registry = GeneralUtility::makeInstance(Registry::class);
		$registry->set($nameSpace, $key, $information);
	}
}