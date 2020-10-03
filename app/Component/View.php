<?php

namespace App\Component;

use Exception;

/**
 * Class View
 */
class View
{
    /** @var array */
    private $args;

    /**
     * @param mixed $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->args[$name] ?? null;
    }

    /**
     * @param mixed $name
     * @param mixed $value
     */
    public function __set($name, $value): void
    {
        $this->args[$name] = $value;
    }

    /**
     * @param mixed $name
     *
     * @return bool
     */
    public function __isset($name): bool
    {
        return isset($this->args[$name]);
    }

    /**
     * @param string $view
     * @param array  $args
     *
     * @throws Exception
     */
    public function render(string $view, array $args = []): void
    {
        $file = Config::$ROOT_DIR . '/views/' . $view . '.php';

        foreach ($args as $key => $value) {
            $this->{$key} = $value;
        }

        require $file;
    }
}
