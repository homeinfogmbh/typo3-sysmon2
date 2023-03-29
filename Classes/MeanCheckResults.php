<?php

namespace Homeinfo\SysMon2;

class MeanCheckResults
{
    function __construct(
        public readonly ?float $ram_total,
        public readonly ?float $ram_free,
        public readonly ?float $ram_available,
        public readonly ?float $download,
        public readonly ?float $upload,
        public readonly ?float $recent_touch_events
    )
    {}

    public static function fromCheckResults(array $checkResults): Self
    {
        return new Self(
            Self::meanWithNulls(array_map(fn($checkResult) => $checkResult->ram_total, $checkResults)),
            Self::meanWithNulls(array_map(fn($checkResult) => $checkResult->ram_free, $checkResults)),
            Self::meanWithNulls(array_map(fn($checkResult) => $checkResult->ram_available, $checkResults)),
            Self::meanWithNulls(array_map(fn($checkResult) => $checkResult->download, $checkResults)),
            Self::meanWithNulls(array_map(fn($checkResult) => $checkResult->upload, $checkResults)),
            Self::meanWithNulls(array_map(fn($checkResult) => $checkResult->recent_touch_events, $checkResults)),
        );
    }

    public function getDownloadMbps(): ?float
    {
        return ($this->download === NULL) ? NULL : ($this->download / 1024);
    }

    public function getUploadMbps(): ?float
    {
        return ($this->upload === NULL) ? NULL : ($this->upload / 1024);
    }

    private static function meanWithNulls(array $values): ?float
    {
        return Self::mean(array_filter($values, fn($value) => $value !== NULL));
    }

    private static function mean(array $values): ?float
    {
        if (($cnt = count($values)) === 0)
            return NULL;

        return array_sum($values) / $cnt;
    }
}