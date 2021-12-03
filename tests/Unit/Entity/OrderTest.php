<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    private $order;

    protected function setUp():void
    {
        parent::setUp();
        $this->order = new Order();

    }
}
