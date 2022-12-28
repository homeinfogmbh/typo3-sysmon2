<?php

namespace Homeinfo\SysMon2\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;
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

    public function findBySystem(int $system) {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('checkresults');
        $result = $queryBuilder
            ->select('*')
            ->from('checkresults')
            ->where(
                $queryBuilder->expr()->eq(
                    'system',
                    $queryBuilder->createNamedParameter($system, Connection::PARAM_INT)
                )
            )
            ->executeQuery();
        return $result->fetchAll();
    }
}
