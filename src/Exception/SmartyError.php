<?php

namespace Muratoffalex\SmartyClient\Exception;

use Muratoffalex\SmartyClient\DTO\Response\AbstractResponse;
use Throwable;

class SmartyError extends SmartyClientBaseException
{
    private AbstractResponse $response;

    public function __construct(AbstractResponse $response)
    {
        $this->response = $response;
        parent::__construct('Smarty вернул ошибку: '. $response->error.' | код ошибки: '.$response->errorMessage);
    }

    /**
     * @return AbstractResponse
     */
    public function getResponse(): AbstractResponse
    {
        return $this->response;
    }
}
