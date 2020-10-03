<?php

namespace App\Component;

use ErrorException;
use Exception;

/**
 * Class Error
 */
class Error
{
    /**
     * @param int    $level
     * @param string $message
     * @param string $file
     * @param int    $line
     *
     * @throws ErrorException
     */
    public static function errorHandler(int $level, string $message, string $file, int $line): void
    {
        throw new ErrorException($message, 0, $level, $file, $line);
    }

    /**
     * @param Exception $exception
     *
     * @throws Exception
     */
    public static function exceptionHandler(Exception $exception): void
    {
        $code = $exception->getCode();
        $code = $code === 404 ? $code : 500;

        http_response_code($code);

        $errors = [
            'Uncaught exception: "' . get_class($exception) . '"',
            'Message: "' . $exception->getMessage() . '"',
            'Stack trace: ' . $exception->getTraceAsString(),
            'Thrown in "' . $exception->getFile() . '" on line ' . $exception->getLine()
        ];

        if (Config::$SHOW_ERRORS) {
            echo '<h1>Fatal error</h1>';

            foreach ($errors as $e) {
                echo '<p>' . $e . '</p>';
            }
        } else {
            $log = Config::$ROOT_DIR . '/logs/' . date('Y-m-d') . '.txt';
            ini_set('error_log', $log);
            $message = implode(PHP_EOL, $errors);
            error_log($message);

            (new View)->render('errors/' . $code);
        }
    }
}
