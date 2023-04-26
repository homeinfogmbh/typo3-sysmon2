<?php

namespace Homeinfo\SysMon2\Domain\Model;

use DateTime;

const MIN_DOWNLOAD = 1953.125;  // Kilobits/s
const MIN_UPLOAD = 488.28125;   // Kilobits/s

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
        public readonly ?string $fsck_repair,
        public readonly ?string $application_version,
        public readonly ?int $ram_total,
        public readonly ?int $ram_free,
        public readonly ?int $ram_available,
        public readonly string $efi_mount_ok,
        public readonly ?int $download,
        public readonly ?int $upload,
        public readonly string $root_not_ro,
        public readonly string $sensors,
        public readonly ?bool $in_sync,
        public readonly ?int $recent_touch_events,
        public readonly ?DateTime $offline_since,
        public readonly ?DateTime $blackscreen_since
    )
    {
    }

    public function downloadOk(): bool
    {
        return $this->download !== NULL && $this->download >= MIN_DOWNLOAD;
    }

    public function uploadOk(): bool
    {
        return $this->upload !== NULL && $this->upload >= MIN_UPLOAD;
    }

    public function isOnline(): bool
    {
        return $this->icmp_request && ($this->ssh_login === 'success');
    }

    public static function fromArray(array $array): Self
    {
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
            (($offline_since = $array['offline_since']) === NULL) ? NULL : new DateTime($offline_since),
            (($blackscreen_since = $array['blackscreen_since']) === NULL) ? NULL : new DateTime($blackscreen_since),
        );
    }
}