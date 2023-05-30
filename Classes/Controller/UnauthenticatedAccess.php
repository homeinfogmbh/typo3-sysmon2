<?php

namespace Homeinfo\SysMon2\Controller;

use DateTime;
use DateInterval;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Object\ObjectManager;

use Homeinfo\hwdb\Domain\Model\Deployment;
use Homeinfo\hwdb\Domain\Model\System;
use Homeinfo\hwdb\Domain\Repository\DeploymentRepository;
use Homeinfo\hwdb\Domain\Repository\SystemRepository;

use Homeinfo\SysMon2\Domain\Repository\CheckResultsRepository;
use Homeinfo\SysMon2\SystemWithCheckResults;


class UnauthenticatedAccess extends ActionController
{
    function __construct()
    {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->deploymentRepository = $this->objectManager->get(DeploymentRepository::class);
        $this->systemRepository = $this->objectManager->get(SystemRepository::class);
        $this->checkResultsRepository = $this->objectManager->get(CheckResultsRepository::class);
    }

    public function systemDetailsAction()
    {
        if (($customerId = Self::getCustomerId()) === NULL)
            return $this->errorAction();

        $deployments = iterator_to_array($this->deploymentRepository->findByCustomerId($customerId));
        $systems = iterator_to_array($this->systemRepository->findByDeployments($deployments));
        $checkResults = iterator_to_array($this->checkResultsRepository->findLastMonthBySystems($systems));
        $systemsWithCheckResults = iterator_to_array(
            SystemWithCheckResults::fromSystemsDeploymentsAndCheckResults($systems, $deployments, $checkResults)
        );
        $this->view->assign(
            'alwaysOffline',
            array_filter(
                $systemsWithCheckResults,
                fn($systemWithCheckResults) => $systemWithCheckResults->alwaysOffline()
            )
        );
        $this->view->assign(
            'downlaodUploadCritical',
            array_filter(
                $systemsWithCheckResults,
                fn($systemWithCheckResults) => $systemWithCheckResults->downloadAlwaysCritical() || $systemWithCheckResults->uploadAlwaysCritical()
            )
        );
        $this->view->assign(
            'sensorsCritical',
            array_filter(
                $systemsWithCheckResults,
                fn($systemWithCheckResults) => $systemWithCheckResults->sensorsAlwaysCritical()
            )
        );
        $this->view->assign(
            'notFitted',
            array_filter(
                $systemsWithCheckResults,
                fn($systemWithCheckResults) => !$systemWithCheckResults->deployedAndFitted()
            )
        );
        $this->view->assign('date', strtotime("first day of previous month"));
        $this->view->assign(
            'outOfSync',
            array_filter(
                $systemsWithCheckResults,
                fn($systemWithCheckResults) => Self::isOutOfSync($systemWithCheckResults, new DateTime())
            )
        );
    }

    private static function getCustomerId(): ?int
    {
        if (($customerId = $_GET['customer']) == NULL)
            return NULL;

        return intval($customerId);
    }

    private static function isOutOfSync(SystemWithCheckResults $systemWithCheckResults, DateTime $now): bool
    {
        if (($lastSync = $systemWithCheckResults->last_sync) === NULL)
            return true;
            
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
            [
                "system" => $systemWithCheckResults,
                "ood" => $lastSync < $now->add(DateInterval::createFromDateString('48 hours'))
            ],
            "Out of date: "
        );
        return $lastSync < $now->add(DateInterval::createFromDateString('48 hours'));
    }
}
