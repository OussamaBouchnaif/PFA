<?php

namespace App\Tests\App\ValueObject;

use App\ValueObject\CartItemsValueObject;
use App\ValueObject\CartValueObject;
use COM;
use PHPUnit\Framework\TestCase;

class AddToCartTest extends TestCase
{

    public function testAddNewItem()
    {
        $cartItemsValueObject = new CartItemsValueObject(1,10);
        $cartValueObject = new CartValueObject();
        $cartValueObject->addToCart($cartItemsValueObject);
        $lines = $cartValueObject->getLines();
        $this->assertNotEmpty($lines);
        $this->assertEquals($cartItemsValueObject,$lines[1]);
    }
    public function testAddExistingItem()
    {
        $cartItemsValueObject = new CartItemsValueObject(1,10);
        $cartValueObject = new CartValueObject();
        $cartValueObject->addToCart($cartItemsValueObject);
        $cartItemsValueObject2 = new CartItemsValueObject(1,15);
        $cartValueObject->addToCart($cartItemsValueObject2);
        $lines = $cartValueObject->getLines();
        $this->assertNotEmpty($lines);
        $this->assertEquals(25,$lines[1]->getQuantity());

    }
}
