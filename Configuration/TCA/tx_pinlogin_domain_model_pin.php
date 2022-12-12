<?php

return [
    'ctrl' => [
        'title' => 'User PINs',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'name,',
        'iconfile' => 'EXT:pinlogin/Resources/Public/Icons/Extension.svg',
    ],
    'types' => [
        '1' => ['showitem' => 'hidden, feuser_id, pin'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => 1,
            'label' => 'Hide',
            'config' => [
                'type' => 'check',
            ],
        ],

        'feuser_id' => [
            'exclude' => false,
            'label' => 'UID',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',

                'foreign_table' => 'fe_users',
                'foreign_table_where' => ' ORDER BY username ',
                
                'size' => 1,
                'minitems' => 0,
            ],
        ],

        'pin' => [
            'exclude' => false,
            'label' => 'PIN',
            'config' => [
                'type' => 'input',
            ],
        ],
    ],
];
