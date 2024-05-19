<?php

namespace App\Payment\Processor;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Cart\Handler\CartStorageInterface;
use App\Payment\Processor\AbstractPaymentProcessor;

class CreditCardProcessor extends AbstractPaymentProcessor
{
    public function __construct(
        protected string $successUrl,
        protected string $cancelUrl,
        private CartStorageInterface $products)
    {
        parent::__construct($successUrl, $cancelUrl);
        Stripe::setApiKey($_ENV['STRIPE_SECRETKEY']);
    }

    public  function processPayment()
    {
        [$lineItems, $total] = $this->getLines();
        return Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $this->onSuccess(),
            'cancel_url' => $this->onSuccess(),
        ]);
    }

    public function getPaymentGateWay(): string
    {
        return $this->processPayment()->url;
    }

    public function getSupportedMethod(): string
    {
        return 'credit_card';
    }


    private function getLines()
    {
        $line_items = [];
        $total = 0;
        foreach ($this->products->getCart()->getLines() as $product) {
            $price = intval($product->getPrice());
            $quantity = $product->getQuantity();

            $line_items[] = [
                'price_data' => [
                    'currency' => $_ENV['STRIPE_CURRENCY'],
                    'product_data' => [
                        'name' => $product->getName(),
                    ],
                    'unit_amount' => $price * 100,
                ],
                'quantity' => $quantity,
            ];
            $total += $price * $quantity;
        }

        return [$line_items, $total];
    }
}
