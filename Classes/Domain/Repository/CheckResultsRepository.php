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

    public function findLastMonthBySystems(array $systems): Generator
    {    
        $systemIds = [];
            
        foreach ($systems as $system)
            $systemIds[] = $system->id;

        return $this->findLastMonthBySystemIds($systemIds);
    }

    public function findLastMonthBySystemIds(array $systemIds): Generator {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('checkresults');
        $query = $queryBuilder
            ->select('*')
            ->from('checkresults')
            ->where(
                $queryBuilder->expr()->and(
                    $queryBuilder->expr()->in(
                        'system',
                        $queryBuilder->createNamedParameter($systemIds, Connection::PARAM_INT_ARRAY)
                    ),
                    $queryBuilder->expr()->gte(
                        'timestamp',
                        date("'Y-m-d'", strtotime("first day of previous month"))
                    ),
                    $queryBuilder->expr()->lte(
                        'timestamp',
                        date("'Y-m-d'", strtotime("last day of previous month"))
                    )
                )
            );

        foreach ($query->executeQuery()->fetchAll() as &$record)
        {
            yield CheckResults::fromArray($record);
        }
    }

    public function findBySystemIds(array $systemIds): Generator {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('checkresults');
        $result = $queryBuilder
            ->select('*')
            ->from('checkresults')
            ->where(
                $queryBuilder->expr()->in(
                    'system',
                    $queryBuilder->createNamedParameter($systemIds, Connection::PARAM_INT_ARRAY)
                )
            )
            ->executeQuery();

        foreach ($result->fetchAll() as &$record)
        {
            yield CheckResults::fromArray($record);
        }
    }

    public function findBySystemId(int $systemId): Generator {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('checkresults');
        $result = $queryBuilder
            ->select('*')
            ->from('checkresults')
            ->where(
                $queryBuilder->expr()->eq(
                    'system',
                    $queryBuilder->createNamedParameter($systemId, Connection::PARAM_INT)
                )
            )
            ->executeQuery();

        foreach ($result->fetchAll() as &$record)
        {
            yield CheckResults::fromArray($record);
        }
    }
}
