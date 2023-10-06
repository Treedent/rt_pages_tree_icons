..  include:: /Includes.rst.txt
..  index:: Configuration
..  _login_options:

=====================
Login Options
=====================

You can adust backend login interface appearance by configuring the global extension.

- In TYPO3 V11 or V12  : Admin Tools > Settings module > Configure extension > rt_pages_tree_icons.

..  figure:: /Images/SettingsConfiguratioLoginOptions.jpg
    :class: with-shadow
    :alt: TYPO3 Login Screen Options
    :width: 700px

    TYPO3 Login Screen Options

|
|

With this configuration, you can:

- Enable changing opacity of the TYPO3 backend login form background:
   - backLoginFormTransparent [boolean]
- Change the opacity value of the TYPO3 backend login form background:
   - backLoginFormOpacity [options]
- Display the border of the TYPO3 backend login form:
   - backLoginFormBorder [boolean]
- Change the border radius value of the TYPO3 backend login form:
   - backLoginBorderRadius [string]
- Change the background color value of the TYPO3 backend login form:
   - backLoginBackColor [color]
- Enable use of random images from external URL
   - backLoginRandomImage [boolean]
- Change the Random image URL with your own
   - randomIMageUrl [https://source.unsplash.com/random]

|
|

..  confval:: PHP - Login Options

    Adjust backend login interface appearance::

       <?php
       // TYPO3 V11: typo3conf/LocalConfiguration.php
       // TYPO3 V12: config/system/settings.php

       return [
          'EXTENSIONS' => [
             'rt_pages_tree_icons' => [
             'backLoginBackColor' => '#f0b81f',
             'backLoginBorderRadius' => '6',
             'backLoginFormBorder' => '1',
             'backLoginFormOpacity' => '0.5',
             'backLoginFormTransparent' => '1',
             'backLoginRandomImage' => '1',
             'randomImageUrl' => 'https://source.unsplash.com/random',
            ],
         ],
      ];
