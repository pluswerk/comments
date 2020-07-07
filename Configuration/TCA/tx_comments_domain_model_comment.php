<?php

defined('TYPO3_MODE') or die();

$locallangGeneralPath = 'core/Resources/Private/Language/locallang_general.xlf';
$table = 'tx_comments_domain_model_comment';

return [
    'ctrl' => [
        'title' => 'LLL:EXT:comments/Resources/Private/Language/locallang_db.xlf:comment',
        'label' => 'comment',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
        'languageField' => 'sys_language_uid',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title',
        'iconfile' => 'EXT:comments/Resources/Public/Icons/Backend/Comments.svg',
    ],
    'interface' => [
        'showRecordFieldList' => '',
    ],
    'types' => [
        '1' => [
            'showitem' => 'user, comment, editorial_comment, disabled, mail_notification, page_uid,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.access, hidden, --palette--;;1, starttime, endtime',
        ],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:' . $locallangGeneralPath . ':LGL.language',
            'config' => [
                'type' => 'select',
                'readOnly' => false,
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    ['LLL:EXT:' . $locallangGeneralPath . ':LGL.allLanguages', -1],
                    ['LLL:EXT:' . $locallangGeneralPath . ':LGL.default_value', 0],
                ],
                'default' => 0,
                'fieldWizard' => [
                    'selectIcons' => [
                        'disabled' => false,
                    ],
                ],
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:' . $locallangGeneralPath . ':LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'readOnly' => false,
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => $table,
                'foreign_table_where' => 'AND ' . $table . '.pid=###CURRENT_PID### AND ' . $table . '.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
                'readOnly' => false,
            ],
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:' . $locallangGeneralPath . ':LGL.hidden',
            'config' => [
                'type' => 'check',
                'readOnly' => false,
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:' . $locallangGeneralPath . ':LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'readOnly' => false,
                'size' => 13,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
                ],
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:' . $locallangGeneralPath . ':LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'readOnly' => false,
                'size' => 13,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
                ],
            ],
        ],
        'sorting' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:comments/Resources/Private/Language/locallang_db.xlf:comment.user',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'required,trim',
                'readOnly' => true,
            ],
        ],
        'comment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:comments/Resources/Private/Language/locallang_db.xlf:comment.comment',
            'config' => [
                'type' => 'text',
                'eval' => 'trim',
            ],
        ],
        'editorial_comment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:comments/Resources/Private/Language/locallang_db.xlf:comment.editorial_comment',
            'config' => [
                'type' => 'text',
                'eval' => 'trim',
            ],
        ],
        'disabled' => [
            'exclude' => true,
            'label' => 'LLL:EXT:comments/Resources/Private/Language/locallang_db.xlf:comment.disabled',
            'config' => [
                'type' => 'check',
            ],
        ],
        'page_uid' => [
            'label' => 'LLL:EXT:comments/Resources/Private/Language/locallang_db.xlf:comment.page_uid',
            'exclude' => true,
            'config' => [
                'type' => 'input',
                'size' => 10,
            ],
        ],
        'mail_notification' => [
            'exclude' => true,
            'label' => 'LLL:EXT:comments/Resources/Private/Language/locallang_db.xlf:comment.mail_notification',
            'config' => [
                'type' => 'check',
                'readOnly' => true,
            ],
        ],
    ],
];
