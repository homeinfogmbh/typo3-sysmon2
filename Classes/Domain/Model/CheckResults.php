<?php

namespace Homeinfo\SysMon2\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class CheckResults extends AbstractEntity
{
    /**
     * @var int $id
     */
    public $id;

    /**
     * @var DateTime $timestamp
     */
    public $timestamp;

    /**
     * @var int $system
     */
    public $system;

    /**
     * @var bool $icmp_request 
     */
    public $icmp_request;

    /**
     * @var string $ssh_login  
     */
    public $ssh_login ;

    /**
     * @var string $http_request 
     */
    public $http_request;

    /**
     * @var string $application_state 
     */
    public $application_state;

    /**
     * @var string $smart_check 
     */
    public $smart_check;

    /**
     * @var string $baytrail_freeze 
     */
    public $baytrail_freeze;

    /**
     * @var string $fsck_repair 
     */
    public $fsck_repair;

    /**
     * @var bool $application_version 
     */
    public $application_version;

    /**
     * @var int $ram_total 
     */
    public $ram_total;

    /**
     * @var int $ram_free 
     */
    public $ram_free;

    /**
     * @var int $ram_available 
     */
    public $ram_available;

    /**
     * @var string $efi_mount_ok 
     */
    public $efi_mount_ok;

    /**
     * @var int $download 
     */
    public $download;

    /**
     * @var int $upload 
     */
    public $upload;

    /**
     * @var string $root_not_ro 
     */
    public $root_not_ro;

    /**
     * @var string $sensors 
     */
    public $sensors;

    /**
     * @var bool $in_sync 
     */
    public $in_sync;

    /**
     * @var int $recent_touch_events 
     */
    public $recent_touch_events;

    /**
     * @var DateTime $offline_since 
     */
    public $offline_since;

    /**
     * @var DateTime $blackscreen_since 
     */
    public $blackscreen_since;
}