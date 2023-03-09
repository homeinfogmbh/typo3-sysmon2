<?php

namespace Homeinfo\SysMon2;

use DateTime;
use Generator;

use Homeinfo\hwdb\Domain\Model\Deployment;
use Homeinfo\hwdb\Domain\Model\System;

class SystemWithCheckResults {
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
    {}

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
            Self::getDeployment($system->deployment, $deployments),
            Self::getDeployment($system->dataset, $deployments),
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

    private static function getDeployment(?int $deploymentId, array $deployments): ?Deployment
    {
        if ($deploymentId === NULL)
            return NULL;

        foreach ($deployments as $deployment)
            if ($deployment->id === $deploymentId)
                return $deployment;

        return NULL;
    }

    private static function getCheckResults(int $systemId, array $checkResults): Generator
    {
        foreach ($checkResults as $checkResult)
            if ($checkResult->system === $systemId)
                yield $checkResult;
    }
}