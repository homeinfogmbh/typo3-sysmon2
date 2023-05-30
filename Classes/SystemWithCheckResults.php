<?php

namespace Homeinfo\SysMon2;

use DateInterval;
use DateTime;
use Generator;

use Homeinfo\hwdb\Domain\Model\Deployment;
use Homeinfo\hwdb\Domain\Model\System;

use Homeinfo\SysMon2\MeanCheckResults;

class SystemWithCheckResults {
    public readonly MeanCheckResults $mean;

    function __construct(
        public readonly int $id,
        public readonly ?int $group,
        public readonly ?Deployment $deployment,
        public readonly ?Deployment $dataset,
        public readonly ?int $openvpn,
        public readonly ?string $ipv6address,
        public readonly ?string $pubkey,
        public readonly DateTime $created,
        public readonly ?DateTime $configured,
        public readonly bool $fitted,
        public readonly string $operating_system,
        public readonly ?bool $monitor,
        public readonly ?string $serial_number,
        public readonly ?string $model,
        public readonly ?DateTime $last_sync,
        public readonly bool $updating,
        public readonly array $check_results,
    )
    {
        $this->mean = MeanCheckResults::fromCheckResults($this->check_results);
    }

    public function isAlwaysOffline(): bool
    {
        foreach ($this->check_results as $checkResult)
            if ($checkResult->isOnline())
                return false;
        
        return true;
    }

    public function isDownloadAlwaysCritical(): bool
    {
        foreach ($this->check_results as $checkResult)
            if ($checkResult->downloadOk())
                return false;
        
        return true;
    }

    public function isOutOfSync(DateTime $now): bool
    {
        if (($lastSync = $this->last_sync) === NULL)
            return true;

        return $lastSync < $now->add(DateInterval::createFromDateString('48 hours'));
    }

    public function isUploadAlwaysCritical(): bool
    {
        foreach ($this->check_results as $checkResult)
            if ($checkResult->uploadOk())
                return false;
        
        return true;
    }

    public function isUploadOrDownloadAlwaysCritical(): bool
    {
        return $this->isUploadAlwaysCritical() || $this->isDownloadAlwaysCritical();
    }

    public function isDeployedAndFitted(): bool
    {
        return $this->deployment !== NULL && $this->fitted;
    }

    /**
     * System is considered overheated, iff it was never measured as
     * not overheated, but measured as overheated.
     * Thus the system was always either overheated or could not be
     * measured.
     */
    public function isSensorsAlwaysCritical(): bool
    {
        $result = false;

        foreach ($this->check_results as $checkResult)
            if ($checkResult->sensors === 'success')
                return false;

            if ($checkResult->sensors === 'failed')
                $result = true;
        
        return $result;
    }

    public static function fromSystemsDeploymentsAndCheckResults(array $systems, array $deployments, array $checkResults): Generator
    {
        foreach ($systems as $system)
            yield Self::fromSystemDeploymentsAndCheckResults($system, $deployments, $checkResults);
    }

    public static function fromSystemDeploymentsAndCheckResults(System $system, array $deployments, array $checkResults): Self
    {
        return new Self(
            $system->id,
            $system->group,
            $system->deployment,
            $system->dataset,
            $system->openvpn,
            $system->ipv6address,
            $system->pubkey,
            $system->created,
            $system->configured,
            $system->fitted,
            $system->operating_system,
            $system->monitor,
            $system->serial_number,
            $system->model,
            $system->last_sync,
            $system->updating,
            iterator_to_array(Self::getCheckResults($system->id, $checkResults)),
        );
    }

    private static function getCheckResults(int $systemId, array $checkResults): Generator
    {
        foreach ($checkResults as $checkResult)
            if ($checkResult->system === $systemId)
                yield $checkResult;
    }
}