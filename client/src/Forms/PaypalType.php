<?php

namespace App\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PaypalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('paypal', SubmitType::class, [
            'label' => 'Pay with PayPal',
            'attr' => ['class' => 'btn btn-primary']
        ]);
    }
}
