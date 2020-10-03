<?php

namespace App\Controller;

use App\Component\Controller;
use App\Model\Enum\TaskStatus;
use App\Model\Task;
use Exception;

/**
 * Class TaskController
 */
class TaskController extends Controller
{
    /** @var array */
    private $errors = [];

    /**
     * @return string
     *
     * @throws Exception
     */
    private function getValidUsernameParam(): string
    {
        $username = trim($_POST['username'] ?? '');
        $username = filter_var($username, FILTER_SANITIZE_STRING);

        if (!$username) {
            throw new Exception('Please enter a username.');
        }

        if (mb_strlen($username) > 32) {
            throw new Exception('Username cannot be longer than 32 characters.');
        }

        return $username;
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    private function getValidEmailParam(): string
    {
        $email = trim($_POST['email'] ?? '');
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

        if (!$email) {
            throw new Exception('Please enter a valid email address.');
        }

        return $email;
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    private function getValidDescriptionParam(): string
    {
        $description = trim($_POST['description'] ?? '');
        $description = filter_var($description, FILTER_SANITIZE_STRING);

        if (!$description) {
            throw new Exception('Please enter a task description.');
        }

        if (mb_strlen($description) > 65535) {
            throw new Exception('Description cannot be longer than 65535 characters.');
        }

        return $description;
    }

    /**
     * @return array|false
     */
    private function getParams()
    {
        $values = [];

        try {
            $values['username'] = $this->getValidUsernameParam();
        } catch (Exception $ex) {
            $this->errors['username'] = $ex->getMessage();
        }

        try {
            $values['email'] = $this->getValidEmailParam();
        } catch (Exception $ex) {
            $this->errors['email'] = $ex->getMessage();
        }

        try {
            $values['description'] = $this->getValidDescriptionParam();
        } catch (Exception $ex) {
            $this->errors['description'] = $ex->getMessage();
        }

        return empty($this->errors) ? $values : false;
    }

    /**
     * Send Response
     */
    private function sendResponse(): void
    {
        if (empty($this->errors)) {
            $this->renderJson(['success' => true]);
        } else {
            http_response_code(400);
            $this->renderJson(['errors' => $this->errors]);
        }
    }

    /**
     * @throws Exception
     */
    public function listAction(): void
    {
        $page = (int)($_GET['page'] ?? 1);
        $perPage = (int)($_GET['per_page'] ?? 3);
        $order = $_GET['order'] ?? [];

        $pagination = Task::getPagination($page, $perPage, $order);

        $this->render('task/list', [
            'pagination' => $pagination,
            'order'      => $order
        ]);
    }

    /**
     * @throws Exception
     */
    public function addAction(): void
    {
        $statuses = TaskStatus::getStatuses();
        $task = ['status' => (new TaskStatus)->getStatus()];

        $this->render('task/add', [
            'formAction' => '/insert',
            'task'       => $task,
            'statuses'   => $statuses
        ]);
    }

    /**
     * @throws Exception
     */
    public function editAction(): void
    {
        $id = $_GET['id'] ?? null;

        if (!$id || !$this->isAuth()) {
            $this->redirect('/');
        }

        $statuses = TaskStatus::getStatuses();
        $task = Task::getById($id);

        $this->render('task/edit', [
            'formAction' => '/update',
            'task'       => $task,
            'statuses'   => $statuses
        ]);
    }

    /**
     * @throws Exception
     */
    public function insertAction(): void
    {
        if (!$this->isAjax()) {
            $this->redirect('/');
        }

        $values = $this->getParams();

        if (empty($this->errors)) {
            $values['status'] = TaskStatus::Active;
            Task::add($values);
        }

        $this->sendResponse();
    }

    /**
     * @throws Exception
     */
    public function updateAction(): void
    {
        if (!$this->isAuth()) {
            $this->redirect('/login');
        }

        $id = null;
        $values = $this->getParams();

        if (empty($this->errors)) {
            $values['status'] = TaskStatus::Active;

            if ($this->isAuth()) {
                $values['status'] = (int)($_POST['status'] ?? TaskStatus::Active);
                $id = empty($_POST['id']) ? null : (int)$_POST['id'];
            }

            Task::update($id, $values);
        }

        $this->sendResponse();
    }
}
