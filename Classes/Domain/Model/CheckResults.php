<?php

namespace Homeinfo\SysMon2\Domain\Model;

use DateTime;

final class CheckResults
{
    function __construct(
        public readonly int $id,
        public readonly DateTime $timestamp,
        public readonly int $system,
        public readonly bool $icmp_request,
        public readonly string $ssh_login,
        public readonly string $http_request,
        public readonly string $application_state,
        public readonly string $smart_check,
        public readonly string $baytrail_freeze,
        public readonly string $fsck_repair,
        public readonly bool $application_version,
        public readonly int $ram_total,
        public readonly int $ram_free,
        public readonly int $ram_available,
        public readonly string $efi_mount_ok,
        public readonly int $download,
        public readonly int $upload,
        public readonly string $root_not_ro,
        public readonly string $sensors,
        public readonly bool $in_sync,
        public readonly int $recent_touch_events,
        public readonly DateTime $offline_since,
        public readonly DateTime $blackscreen_since
    )
    {
    }

    public static function fromArray(array $array): Self {
        return new self(
            $array['id'],
            new DateTime($array['timestamp']),
            $array['system'],
            $array['icmp_request'],
            $array['ssh_login'],
            $array['http_request'],
            $array['application_state'],
            $array['smart_check'],
            $array['baytrail_freeze'],
            $array['fsck_repair'],
            $array['application_version'],
            $array['ram_total'],
            $array['ram_free'],
            $array['ram_available'],
            $array['efi_mount_ok'],
            $array['download'],
            $array['upload'],
            $array['root_not_ro'],
            $array['sensors'],
            $array['in_sync'],
            $array['recent_touch_events'],
            ($array['offline_since'] === null) ? null : new DateTime($array['offline_since']),
            ($array['blackscreen_since'] === null) ? null : new DateTime($array['blackscreen_since']),
        );
    }
}