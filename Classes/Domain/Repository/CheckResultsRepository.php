<?php

namespace Homeinfo\SysMon2\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

class CheckResultsRepository extends Repository
{
    public function findBySystem(int $system): QueryResultInterface {
        $query = $this->getStorageIndependentQuery();
        return $query
            ->matching($query->equals('system', $system))
            ->execute();
    }

    private function getStorageIndependentQuery() {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        return $query;
    }
}
