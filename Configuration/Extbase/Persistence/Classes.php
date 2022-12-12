<?php
declare(strict_types = 1);

return [
    \Homeinfo\SysMon2\Domain\Model\Person::class => [
        'tableName' => 'tt_address',
        'recordType' => \Homeinfo\SysMon2\Domain\Model\CheckResults::class,
        'properties' => [
            'dateOfBirth' => [
                'fieldName' => 'birthday',
            ],
            'thoroughfare' => [
                'fieldName' => 'street',
            ],
        ],
    ],
];