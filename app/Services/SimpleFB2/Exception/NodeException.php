<?php
namespace App\Services\SimpleFB2\Exception;

class NodeException extends \Exception
{
    public function __construct()
    {
        $this->message == 'Node not found';
    }
}

?>