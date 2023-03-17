<?php

namespace Homeinfo\SysMon2;

class MeanCheckResults
{
    function __construct(
        public readonly ?int $ram_total,
        public readonly ?int $ram_free,
        public readonly ?int $ram_available,
        public readonly ?int $download,
        public readonly ?int $upload,
        public readonly ?int $recent_touch_events
    )
    {}

    public static function fromCheckResults(array $checkResults): Self
    {
        return new Self(
            Self::meanWithNulls(array_map($checkResults, fn($checkResult) => $checkResult->ram_total)),
            Self::meanWithNulls(array_map($checkResults, fn($checkResult) => $checkResult->ram_free)),
            Self::meanWithNulls(array_map($checkResults, fn($checkResult) => $checkResult->ram_available)),
            Self::meanWithNulls(array_map($checkResults, fn($checkResult) => $checkResult->download)),
            Self::meanWithNulls(array_map($checkResults, fn($checkResult) => $checkResult->upload)),
            Self::meanWithNulls(array_map($checkResults, fn($checkResult) => $checkResult->recent_touch_events)),
        );
    }

    private static function meanWithNulls(array $values): float
    {
        return Self::mean(array_filter($values, fn($value) => $value !== NULL));
    }

    private static function mean(array $values): float
    {
        return array_sum($values) / count($values);
    }
}