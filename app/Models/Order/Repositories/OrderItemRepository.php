<?php

namespace App\Models\Order\Repositories;

use App\Contracts\DoctrineRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class OrderItemRepository extends DoctrineRepository {
    use Paginatable;
}
