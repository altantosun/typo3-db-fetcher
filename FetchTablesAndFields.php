<?php
declare(strict_types=1);

namespace Z3\Z3Upgrade\Helper;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FetchTablesAndFields
{
    public static function fetchFieldsFromTable(string $tableName): array
    {

        /** @var ConnectionPool $connectionPool */
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getConnectionForTable($tableName);
        $tableFields = $queryBuilder->executeQuery('SHOW FIELDS FROM ' . $tableName)->fetchAllAssociative();

        $tableFieldNames = [];

        foreach ($tableFields as $tableField) {
            $tableFieldNames[] = $tableField['Field'];
        }

        return $tableFieldNames;
    }

    /**
     * @return array<string>
     * @throws \Doctrine\DBAL\DBALException|\Doctrine\DBAL\Driver\Exception
     */
    public static function fetchTableNames(): array
    {
        /** @var ConnectionPool $connectionPool */
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getConnectionForTable('pages'); // just name one table name, usually pages always exists
        $tables = $queryBuilder->executeQuery('SHOW TABLES')->fetchAllAssociative();

        $tableNames = [];

        foreach ($tables as $table) {
            foreach ($table as $item) {
                $tableNames[] = $item;
            }
        }

        return $tableNames;
    }
}
