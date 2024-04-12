<?php

namespace App\Tests\App\ValueObject;


use COM;
use PHPUnit\Framework\TestCase;
use App\ValueObject\CartValueObject;
use App\ValueObject\CartItemValueObject;

class AddToCartTest extends TestCase
{

    public function testAddNewItem()
    {
        $cartItemsValueObject = new CartItemValueObject(1,10);
        $cartValueObject = new CartValueObject();
        $cartValueObject->addToCart($cartItemsValueObject);
        $lines = $cartValueObject->getLines();
        $this->assertNotEmpty($lines);
        $this->assertEquals($cartItemsValueObject,$lines[1]);
    }
    public function testAddExistingItem()
    {
        $cartItemsValueObject = new CartItemValueObject(1,10);
        $cartValueObject = new CartValueObject();
        $cartValueObject->addToCart($cartItemsValueObject);
        $cartItemsValueObject2 = new CartItemValueObject(1,15);
        $cartValueObject->addToCart($cartItemsValueObject2);
        $lines = $cartValueObject->getLines();
        $this->assertNotEmpty($lines);
        $this->assertEquals(25,$lines[1]->getQuantity());

    }
}
