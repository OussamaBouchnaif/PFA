<?php


namespace App\DTO;

use App\Entity\Client;
use App\Enum\CartStatus;
use Doctrine\Common\Collections\Collection;

class CartDTO
{

    private ?int $id = null;


    private ?\DateTimeImmutable $createdAt = null;


    private ?\DateTimeImmutable $updateAt = null;


    private ?Client $Client = null;


    private Collection $items;


    private ?CartStatus $status = null;
}