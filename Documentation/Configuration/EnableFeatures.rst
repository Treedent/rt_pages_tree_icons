..  include:: /Includes.rst.txt
..  index:: Configuration
..  _enable_features:

=====================
Enable Features
=====================

- In TYPO3 V11 or V12  : Admin Tools > Settings module > Configure extension > rt_pages_tree_icons.

Enable changing page tree icons when editing page properties in behavior tab > Use as Container.

..  figure:: /Images/SettingsConfiguratioFeatures.jpg
    :class: with-shadow
    :alt: Enable features
    :width: 700px

    Enable features

..  figure:: /Images/PageBehavior.jpg
    :class: with-shadow
    :alt: Page Behavior: Use as container
    :width: 700px

    Page Module > Edit Page properties > Behavior > Use as container

|
|

..  confval:: PHP - Enable Features

    Enable changing page tree icons when editing page properties::

       <?php
       // TYPO3 V11: typo3conf/LocalConfiguration.php
       // TYPO3 V12: config/system/settings.php

       return [
          'EXTENSIONS' => [
             'rt_pages_tree_icons' => [
               'diplayIconsInBehaviourTab' => '1',
            ],
         ],
      ];
