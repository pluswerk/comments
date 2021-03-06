<?php

defined('TYPO3_MODE') or die('Access denied.');

/** @var string $_EXTKEY */
call_user_func(function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Pluswerk.Comments',
        'Comments',
        [
            'Comments' => 'list,create,delete,report',
        ],
        [
            'Comments' => 'list,create,delete,report',
        ]
    );
    if (TYPO3_MODE === 'BE') {
        /** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
        $iconRegistry->registerIcon(
            'ext-comments-wizard-icon',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:comments/Resources/Public/Icons/Backend/Comments.svg']
        );
    }
}, $_EXTKEY);
