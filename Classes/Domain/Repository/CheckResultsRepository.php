<?php

namespace Homeinfo\SysMon2\Domain\Repository;

use Generator;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

use Homeinfo\SysMon2\Domain\Model\CheckResults;

final class CheckResultsRepository
{
    public function __construct(
        private readonly ConnectionPool $connectionPool
    ) {
    }

    public function findLastMonthBySystems(int $system): Generator {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('checkresults');
        $result = $queryBuilder
            ->select('*')
            ->from('checkresults')
            ->where(
                $queryBuilder->expr()->and(
                    $queryBuilder->expr()->in(
                        'system',
                        $queryBuilder->createNamedParameter($systems, Connection::PARAM_INT_ARRAY)
                    ),
                    $queryBuilder->expr()->ge(
                        'timestamp',
                        date("Y-m-d", strtotime("first day of previous month"))
                    ),
                    $queryBuilder->expr()->le(
                        'timestamp',
                        date("Y-m-d", strtotime("last day of previous month"))
                    )
                )
            )
            ->executeQuery();

        foreach ($result->fetchAll() as &$record)
        {
            yield CheckResults::fromArray($record);
        }
    }

    public function findBySystems(array $systems): Generator {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('checkresults');
        $result = $queryBuilder
            ->select('*')
            ->from('checkresults')
            ->where(
                $queryBuilder->expr()->in(
                    'system',
                    $queryBuilder->createNamedParameter($systems, Connection::PARAM_INT_ARRAY)
                )
            )
            ->executeQuery();

        foreach ($result->fetchAll() as &$record)
        {
            yield CheckResults::fromArray($record);
        }
    }

    public function findBySystem(int $system): Generator {
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

        foreach ($result->fetchAll() as &$record)
        {
            yield CheckResults::fromArray($record);
        }
    }
}
