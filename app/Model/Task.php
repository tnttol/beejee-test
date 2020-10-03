<?php

namespace App\Model;

use App\Component\Model;
use Exception;
use PDO;

/**
 * Class User
 */
class Task extends Model
{
    /**
     * @param array $prevTask
     * @param array $currTask
     *
     * @return bool
     */
    private static function checkIsEdited(array $prevTask, array $currTask): bool
    {
        return false === filter_var($prevTask['edited'], FILTER_VALIDATE_BOOLEAN)
            && $prevTask['description'] !== $currTask['description']
        ;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public static function getById(int $id): array
    {
        $query = 'SELECT id, status, edited, username, email, description FROM tasks WHERE id = :id';
        $stmt = self::getDB()->prepare($query);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param array $values
     *
     * @return bool
     */
    public static function add(array $values): bool
    {
        $query = 'INSERT INTO tasks';

        self::prepareInsertQuery($query, $values);

        $stmt = self::getDB()->prepare($query);
        $stmt->execute($values);

        return true;
    }

    /**
     * @param int   $id
     * @param array $values
     *
     * @return bool
     */
    public static function update(int $id, array $values): bool
    {
        $task = self::getById($id);

        if (empty($task)) {
            return false;
        }

        $query = 'UPDATE tasks';

        if (self::checkIsEdited($task, $values)) {
            $values['edited'] = '1';
        }

        self::prepareUpdateQuery($query, $values);

        $values['id'] = $id;
        $where = ['id' => $id];
        self::prepareWhereQuery($query, $where);

        $stmt = self::getDB()->prepare($query);
        $stmt->execute($values);

        return true;
    }

    /**
     * @param array    $values
     * @param int|null $id
     *
     * @return bool
     */
    public static function save(array $values, int $id = null): bool
    {
        if ($id) {
            return self::update($id, $values);
        }

        return self::add($values);
    }

    /**
     * @param int   $page
     * @param int   $perPage
     * @param array $orderBy
     *
     * @return array
     *
     * @throws Exception
     */
    public static function getPagination(int $page = 1, int $perPage = 3, array $orderBy = []): array
    {
        $query = 'SELECT id, status, edited, username, email, description FROM tasks';

        self::prepareOrderByQuery($query, $orderBy, ['username', 'email', 'status']);
        self::prepareLimitQuery($query, $page, $perPage);

        $tasksStmt = self::getDB()->prepare($query);
        $tasksStmt->execute();

        $totalStmt = self::getDB()->query('SELECT COUNT(id) as cnt FROM tasks');
        $total = (int)$totalStmt->fetch(PDO::FETCH_ASSOC)['cnt'];

        return [
            'page'          => $page,
            'perPage'       => $perPage,
            'total'         => $total,
            'hasPagination' => $total > $perPage,
            'lastPage'      => (int)ceil($total / $perPage),
            'items'         => $tasksStmt->fetchAll(PDO::FETCH_ASSOC)
        ];
    }
}
