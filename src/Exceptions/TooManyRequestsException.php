<?php
namespace Innotama\ChatworkWrapper\Exceptions;

use Exception;

/**
 * API実行回数制限超過例外
 *
 * Class TooManyRequestsException
 * @package Innotama\ChatworkWrapper\Exceptions
 */
class TooManyRequestsException extends \Exception
{
    public function __construct($apiResetsAt = null, $apiRateLimit = null, Exception $previous = null)
    {
        $message = 'too many requests';
        if($apiResetsAt) {
            $message .= ' apiResetsAt=' . $apiResetsAt;
        }
        if($apiRateLimit) {
            $message .= ' apiRateLimit=' . $apiRateLimit;
        }

        parent::__construct($message, 0, $previous);
    }
}
