<?php

namespace App\Payment\Processor;

use App\Payment\Processor\AbstractPaymentProcessor;

class PaypalProcessor extends AbstractPaymentProcessor
{
    public  function processPayment()
    {
        
    }

    public function getSupportedMethod(): string
    {
        return 'paypal';
    }
    
    public function getPaymentGateWay(): string
    {
        return '';
    }


}
