<?php declare(strict_types=1);

namespace App\Domain\Common\Service;

use App\Application\Query\BaseQuery;

interface QueryBusInterface
{
    public function query(BaseQuery $query);
}
