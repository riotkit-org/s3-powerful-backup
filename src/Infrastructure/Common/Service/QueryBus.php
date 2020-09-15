<?php declare(strict_types=1);

namespace App\Infrastructure\Common\Service;

use App\Application\Query\BaseQuery;
use App\Domain\Common\Service\QueryBusInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class QueryBus implements QueryBusInterface
{
    protected MessageBusInterface $parent;

    public function __construct(MessageBusInterface $bus)
    {
        $this->parent = $bus;
    }

    public function query(BaseQuery $query)
    {
        /**
         * @var BaseQuery $queryResponse
         */
        $queryResponse = $this->parent->dispatch($query)->getMessage();

        return $queryResponse->getResult();
    }
}
