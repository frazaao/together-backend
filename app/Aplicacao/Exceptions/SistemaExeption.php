<?php

namespace App\Exceptions;

use Exception;

class SistemaExeption extends Exception
{
    private $_options;

    public function __construct(
        $message,
        $code = 0,
        Exception $previous = null,
        $options = []
    ) {
        if (is_array($message)) {
            $message = [key($message) => [current($message)]];
        }

        parent::__construct(json_encode($message), $code, $previous);

        $this->_options = $options;
    }

    public function getOptions()
    {
        return $this->_options;
    }
}
