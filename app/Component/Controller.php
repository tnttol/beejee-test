<?php

namespace App\Component;

use Exception;

/**
 * Abstract Controller
 */
abstract class Controller
{
    /** @var View */
    private $view;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->initView();
        $this->checkNotification();
    }

    /**
     * Init View
     */
    public function initView(): void
    {
        $this->view = new View;
        $this->view->isAuth = $this->isAuth();
    }

    /**
     * Check Notification
     */
    public function checkNotification()
    {
        if (Notifier::hasNotification()) {
            $this->view->notificationType = Notifier::getNotificationType();
            $this->view->notification = Notifier::getNotification();
            Notifier::clearNotification();
        }
    }

    /**
     * @return bool
     */
    public function isAuth(): bool
    {
        return Auth::isAuth();
    }

    /**
     * @return bool
     */
    public function isAjax(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * @param string $location
     */
    public function redirect(string $location): void
    {
        http_response_code(302);

        if ($this->isAjax()) {
            $this->renderJson(['redirect' => $location]);
        } else {
            header('Location: ' . $location);
        }

        die;
    }

    /**
     * @param string $view
     * @param array  $args
     *
     * @throws Exception
     */
    protected function render(string $view, array $args = []): void
    {
        $this->view->render($view, $args);
    }

    /**
     * @param array $args
     */
    protected function renderJson(array $args = []): void
    {
        header('Content-Type: application/json');

        echo json_encode($args);
    }
}
