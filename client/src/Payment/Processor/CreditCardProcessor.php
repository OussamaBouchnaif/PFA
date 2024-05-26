<?php

namespace App\Payment\Processor;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Payment\Processor\AbstractPaymentProcessor;
use Symfony\Component\HttpFoundation\RequestStack;

class CreditCardProcessor extends AbstractPaymentProcessor
{
    public function __construct(
        protected string $successUrl,
        protected string $cancelUrl,
        private RequestStack $stack,
    ) {
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
        $session = $this->stack->getSession();
        $total = $session->get('voucher')['discount'];
        
        $line_items = [[
            'price_data' => [
                'currency' => $_ENV['STRIPE_CURRENCY'],
                'product_data' => [
                    'name' => 'Total Purchase',
                ],
                'unit_amount' => $total * 100, 
            ],
            'quantity' => 1,
        ]];
        
        return [$line_items, $total];
    }
}
