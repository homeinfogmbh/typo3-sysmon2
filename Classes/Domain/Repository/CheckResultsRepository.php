<?php

namespace Homeinfo\SysMon2\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

final class CheckResultsRepository
{    
    public function __construct(
        private readonly ConnectionPool $connectionPool
    ) {
    }

    public function findBySystem(int $system): QueryResultInterface {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('checkresults');
        $statement = $queryBuilder
            ->select('*')
            ->where(
                $queryBuilder->expr()->eq('checkresults.system', $queryBuilder->createNamedParameter(system))
            );
        DebuggerUtility::var_dump($statement, "Statement: ");
        $statement->executeStatement();
        // $query = $this->getStorageIndependentQuery();
        // $query = $query->matching($query->equals('system', $system));
        // DebuggerUtility::var_dump($query, "Final query: ");
        // return $query->execute();
    }

    private function getStorageIndependentQuery() {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        DebuggerUtility::var_dump($query, "Query: ");
        return $query;
    }
}
