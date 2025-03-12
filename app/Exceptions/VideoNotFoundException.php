<?php

namespace App\Exceptions;

use Exception;

class VideoNotFoundException extends Exception
{
    public function __construct(string $message = "Video not found", int $code = 404)
    {
        parent::__construct($message, $code);
    }
}
