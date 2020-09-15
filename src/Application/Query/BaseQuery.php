<?php declare(strict_types=1);

namespace App\Application\Query;

abstract class BaseQuery
{
    /**
     * @var mixed
     */
    protected $result = null;

    public function setResult($result)
    {
        if ($this->result) {
            throw new \Exception('Cannot set query result twice. Result is immutable');
        }

        $this->result = $result;
    }

    public function getResult()
    {
        return $this->result;
    }
}
