<?php

namespace lm\Autoload\Exception {
    require_once __DIR__ . '/../Exception.php';
    use lm\Autoload\Exception;

    /**
     * Description of SecurityException
     *
     * @author lozymon
     */
    class ClassNotFoundException extends \Exception implements Exception {
    }

}