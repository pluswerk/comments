<?php
defined('TYPO3_MODE') or die('Access denied.');

call_user_func(
    function () {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Pluswerk.Comments',
            'Comments',
            'LLL:EXT:comments/Resources/Private/Language/locallang_db.xlf:pluginWizard.title'
        );

        $pluginSignature = 'comments_comments';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature,
            'FILE:EXT:comments/Configuration/FlexForm/Comments.xml'
        );
    }
);
