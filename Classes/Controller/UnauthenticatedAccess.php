<?php

namespace Homeinfo\SysMon2\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

use TYPO3\CMS\Core\Database\ConnectionPool;
use Homeinfo\SysMon2\Domain\Repository\CheckResultsRepository;

class UnauthenticatedAccess extends ActionController
{
    public function listLastMonth()
    {
        $customerId = $this->request->getArgument('customer');
        $deploymentRepository = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(DeploymentRepository::class);
        $deployments = $deploymentRepository->findByCustomerId($customerId);
        $systemRepository = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(SystemRepository::class);
        $systems = $systemRepository->findByDeployments($deployments);
        $checkResultsRepository = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(CheckResultsRepository::class);
        $checkResults = $checkResultsRepository->findLastMonthBySystems($systems);
        $this->view->assign('check_results', $records);
    }
}
