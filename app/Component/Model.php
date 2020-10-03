<?php

namespace App\Component;

use Exception;
use PDO;

/**
 * Class Model
 */
class Model
{
    /** @var array */
    private static $config;
    /** @var PDO */
    private static $instance;

    /**
     * @param array $config
     *
     * @throws Exception
     */
    public static function setConfig(array $config): void
    {
        foreach (['db_host', 'db_name', 'db_user', 'db_password'] as $key) {
            if (!array_key_exists($key, $config)) {
                throw new Exception('Database configuration error: "' . $key . '" must be set.');
            }
        }

        self::$config = $config;
    }

    /**
     * @return PDO
     */
    protected static function getDB(): PDO
    {
        if (self::$instance === null) {
            $dsn = 'mysql:host=' . self::$config['db_host'] . ';dbname=' . self::$config['db_name'] . ';charset=utf8';
            self::$instance = new PDO($dsn, self::$config['db_user'], self::$config['db_password']);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$instance;
    }

    /**
     * @param string $query
     * @param array  $keyValues
     */
    protected static function prepareInsertQuery(string &$query, array $keyValues): void
    {
        if (empty($keyValues)) {
            return;
        }

        $fields = [];
        $values = [];

        foreach ($keyValues as $field => $value) {
            $fields[] = $field;
            $values[] = ':' . $field;
        }

        $query .= ' (' . implode(', ', $fields) . ')';
        $query .= ' VALUES (' . implode(', ', $values) . ')';
    }

    /**
     * @param string $query
     * @param array  $keyValues
     */
    protected static function prepareUpdateQuery(string &$query, array $keyValues): void
    {
        if (empty($keyValues)) {
            return;
        }

        $values = [];

        foreach ($keyValues as $field => $value) {
            $values[] = $field . ' = :' . $field;
        }

        $query .= ' SET ' . implode(', ', $values);
    }

    /**
     * @param string $query
     * @param array  $where
     */
    protected static function prepareWhereQuery(string &$query, array $where): void
    {
        if (empty($where)) {
            return;
        }

        $qWhere = [];

        foreach ($where as $field => $value) {
            $qWhere[] = $field . ' = :' . $field;
        }

        $query .= ' WHERE ' . implode(' AND ', $qWhere);
    }

    /**
     * @param string $query
     * @param array  $orderBy
     * @param array  $allowedFields
     */
    protected static function prepareOrderByQuery(string &$query, array $orderBy, array $allowedFields): void
    {
        if (empty($orderBy)) {
            return;
        }

        $qOrder = [];

        foreach ($orderBy as $field => $order) {
            if (in_array($field, $allowedFields, true)) {
                $qOrder[] = $field . ' ' . (strtolower($order) === 'desc' ? 'DESC' : 'ASC');
            }
        }

        $query .= ' ORDER BY ' . implode(', ', $qOrder);
    }

    /**
     * @param string $query
     * @param int    $page
     * @param int    $perPage
     */
    protected static function prepareLimitQuery(string &$query, int $page, int $perPage): void
    {
        $page = $page < 1 ? 1 : $page;
        $perPage = $perPage < 1 ? 1 : $perPage;

        $query .= ' LIMIT ' . $perPage . ' OFFSET ' . ($page - 1) * $perPage;
    }
}
