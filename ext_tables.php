<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function () use ($_EXTKEY) {
        // add page tsconfig
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:comments/Configuration/TsConfig/Page/Default.tsconfig">'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'Pluswerk.' . $_EXTKEY,
            'web',
            'commentadministration', // Submodule key
            '',
            [
                'CommentAdministration' => 'show,dashboard'
            ],
            [
                'access' => 'user,group',
                'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/Backend/Comments.svg',
                'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf',
            ]
        );
    }
);
