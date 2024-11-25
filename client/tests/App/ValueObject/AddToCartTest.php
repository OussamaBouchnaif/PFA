<?php

namespace App\Tests\App\ValueObject;


use COM;
use PHPUnit\Framework\TestCase;
use App\ValueObject\CartValueObject;
use App\ValueObject\CartItemValueObject;
use Doctrine\Common\Collections\ArrayCollection;
class AddToCartTest extends TestCase
{

    public function testAddNewItem()
    {
        $cartItemsValueObject = new CartItemValueObject(
            id: 1,
            image: new ArrayCollection(),
            quantity: 10,
            stockage: 128.0,
            name: "Product A"
        );
        $cartItemsValueObject->setPrice(10);

        $cartValueObject = new CartValueObject();
        $cartValueObject->add($cartItemsValueObject);

        $lines = $cartValueObject->getLines();

        $this->assertNotEmpty($lines);
        $this->assertEquals($cartItemsValueObject, $lines[1]);
    }
    public function testAddExistingItem()
    {
        $cartValueObject = new CartValueObject();
        $cartItemsValueObject = new CartItemValueObject(
            id: 1,
            image: new ArrayCollection(),
            quantity: 10,
            stockage: 128.0,
            name: "Product A"
        );
        $cartItemsValueObject->setPrice(10);
        $cartValueObject->add($cartItemsValueObject);
        $cartItemsValueObject2 = new CartItemValueObject(
            id: 1,
            image: new ArrayCollection(),
            quantity: 15,
            stockage: 128.0,
            name: "Product A"
        );
        $cartItemsValueObject2->setPrice(10);
        $cartValueObject->add($cartItemsValueObject2);

        $lines = $cartValueObject->getLines();

        $this->assertNotEmpty($lines);
        $this->assertEquals(25, $lines[1]->getQuantity());

    }
}
