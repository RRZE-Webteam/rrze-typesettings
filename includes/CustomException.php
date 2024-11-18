<?php
namespace RRZE\Typesettings;

class CustomException extends \Exception
{
    public function __construct($message = "", $code = 0, CustomException $previous = null)
    {
        parent::__construct($message, $code, $previous);

        do_action('rrze.log.error', ['plugin' => 'rrze-typesettings', 'wp-error' => $message]);
    }
}
