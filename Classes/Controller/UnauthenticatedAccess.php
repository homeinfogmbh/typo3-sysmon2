<?php

namespace Homeinfo\SysMon2\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

use Generator;

use Homeinfo\hwdb\Domain\Model\Deployment;
use Homeinfo\hwdb\Domain\Repository\DeploymentRepository;
use Homeinfo\hwdb\Domain\Repository\SystemRepository;

use Homeinfo\SysMon2\Domain\Repository\CheckResultsRepository;
use Homeinfo\SysMon2\SystemWithCheckResults;

class UnauthenticatedAccess extends ActionController
{
    public function systemDetailsAction()
    {
        //$customerId = $this->request->getArgument('customer');
        $customerId = 1030020;
        $deploymentRepository = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(DeploymentRepository::class);
        $deployments = $deploymentRepository->findByCustomerId($customerId);
        $systemRepository = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(SystemRepository::class);
        $deploymentIds = [];
        
        foreach ($deployments as &$deployment)
            $deploymentIds[] = $deployment['id'];

        $systems = iterator_to_array($systemRepository->findByDeploymentIds($deploymentIds));
        $checkResultsRepository = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(CheckResultsRepository::class);
        $systemIds = [];
            
        foreach ($systems as $system)
            $systemIds[] = $system->id;

        $checkResults = $checkResultsRepository->findLastMonthBySystems($systemIds);
        $systemsWithCheckResults = iterator_to_array(
            SystemWithCheckResults::fromSystemsDeploymentsAndCheckResults($systems, $deployment, $checkResults)
        );
        $this->view->assign('systemsWithCheckResults', $systemsWithCheckResults);
    }
}
