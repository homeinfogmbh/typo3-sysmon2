<?php

namespace Homeinfo\SysMon2\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Object\ObjectManager;

use Homeinfo\hwdb\Domain\Model\Deployment;
use Homeinfo\hwdb\Domain\Repository\DeploymentRepository;
use Homeinfo\hwdb\Domain\Repository\SystemRepository;

use Homeinfo\SysMon2\Domain\Repository\CheckResultsRepository;
use Homeinfo\SysMon2\SystemWithCheckResults;

class UnauthenticatedAccess extends ActionController
{
    public function systemDetailsAction()
    {
        $deploymentRepository = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(DeploymentRepository::class);
        $deployments = iterator_to_array($deploymentRepository->findByCustomerId(Self::getCustomerId()));
        $systemRepository = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(SystemRepository::class);
        $deploymentIds = [];
        
        foreach ($deployments as &$deployment)
            $deploymentIds[] = $deployment->id;

        $systems = iterator_to_array($systemRepository->findByDeploymentIds($deploymentIds));
        $checkResultsRepository = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(CheckResultsRepository::class);
        $systemIds = [];
            
        foreach ($systems as $system)
            $systemIds[] = $system->id;

        $checkResults = iterator_to_array($checkResultsRepository->findLastMonthBySystems($systemIds));
        $systemsWithCheckResults = iterator_to_array(
            SystemWithCheckResults::fromSystemsDeploymentsAndCheckResults($systems, $deployments, $checkResults)
        );
        $this->view->assign('systemsWithCheckResults', $systemsWithCheckResults);
    }

    private static function getCustomerId(): int
    {
        //return $this->request->getArgument('customer');
        return 1030020;
    }
}
