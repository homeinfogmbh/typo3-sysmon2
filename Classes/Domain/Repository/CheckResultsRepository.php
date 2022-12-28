<?php

namespace Homeinfo\SysMon2\Domain\Repository;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

class CheckResultsRepository extends Repository
{
    public function findBySystem(int $system): QueryResultInterface {
        $query = $this->getStorageIndependentQuery()->matching($query->equals('system', $system));
        DebuggerUtility::var_dump($query, "Final query: ");
        return $query->execute();
    }

    private function getStorageIndependentQuery() {
        $query = $this->createQuery();
        DebuggerUtility::var_dump($query, "Raw query: ");
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        DebuggerUtility::var_dump($query, "Query without storage: ");
        DebuggerUtility::var_dump($query->getQuerySettings(), "Query settings: ");
        return $query;
    }
}
