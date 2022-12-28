<?php

namespace Homeinfo\SysMon2\Controller;

use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

use TYPO3\CMS\Core\Database\ConnectionPool;
use Homeinfo\SysMon2\Domain\Repository\CheckResultsRepository;

class DebugController extends ActionController
{
    public function listAction()
    {
        $repository = CheckResultsRepository();
        $records = $repository->findBySystem(12);
        DebuggerUtility::var_dump($records);
        $this->view->assign('check_results', $records);
    }
}
