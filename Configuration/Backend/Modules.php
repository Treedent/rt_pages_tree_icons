<?php

use Syradev\RtPagesTreeIcons\Controller\PageIconsController;

return [
    'web_RtPagesTreeIconsRtptim1' => [
        'parent' => 'web',
        'position' => ['after' => 'web_info'],
        'access' => 'user',
        'workspaces' => 'live',
        'path' => '/module/web/RtPagesTreeIconsRtptim1',
        'labels' => 'LLL:EXT:rt_pages_tree_icons/Resources/Private/Language/locallang.xlf',
        'extensionName' => 'RtPagesTreeIcons',
        'iconIdentifier' => 'module-pagetreeicons',
        'controllerActions' => [
            PageIconsController::class => [
                'list','changePageIcon','changeSubpagesIcons','iconsHelper'
            ]
        ]
    ]
];
