<?php

namespace App\Formatter;

class PriceFormatter
{
    public function formatPriceRange(string $priceRange): string
    {
        $prices = explode(' - ', $priceRange);
        $prices = array_map(function ($price) {
            return floatval(str_replace('$', '', $price));
        }, $prices);

        return implode('..', $prices);
    }

    public function displayFormattedPrice(?string $priceRange): string
    {
        if (!$priceRange) {
            return "";
        }

        $prices = explode('..', $priceRange);
        if (count($prices) == 2) {
            return "$" . $prices[0] . " - $" . $prices[1];
        }

        return "";  
    }
}
