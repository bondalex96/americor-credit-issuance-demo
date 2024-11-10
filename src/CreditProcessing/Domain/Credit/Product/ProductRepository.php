<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Credit\Product;

final class ProductRepository
{
    private array $products;

    public function __construct()
    {
        $this->products = [
            PersonalCredit::NAME => new PersonalCredit(),
            StudentCredit::NAME => new StudentCredit(),
            DebtConsolidationCredit::NAME => new DebtConsolidationCredit(),
        ];
    }


    public function getProduct(string $productName): Product
    {
        $product = $this->products[$productName]  ?? null;
        if (!$product) {
            throw new \InvalidArgumentException("Product $productName not found");
        }
        return $product;
    }
}
