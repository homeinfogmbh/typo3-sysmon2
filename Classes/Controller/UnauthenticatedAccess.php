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
    function __construct()
    {
        parent::__construct();
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->deploymentRepository = $this->objectManager->get(DeploymentRepository::class);
        $this->systemRepository = $this->objectManager->get(SystemRepository::class);
        $this->checkResultsRepository = $this->objectManager->get(CheckResultsRepository::class);
    }

    public function systemDetailsAction()
    {
        $deployments = iterator_to_array($this->deploymentRepository->findByCustomerId(Self::getCustomerId()));
        $systems = iterator_to_array($this->systemRepository->findByDeployments($deployments));
        $checkResults = iterator_to_array($this->checkResultsRepository->findLastMonthBySystems($systems));
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
