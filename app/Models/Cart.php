<?php

namespace App\Models;

class Cart
{

    public $items = [];
    public $totalQuantity = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQuantity = $oldCart->totalQuantity;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function add($item, $id)
    {

        $currItem = ["quantity" => 0, "price" => $item->price, "item" => $item];
        if (array_key_exists($id, $this->items)) {
            $currItem = $this->items[$id];
        }
        $currItem["quantity"]++;
        $currItem["price"] = $item->price * $currItem["quantity"];
        $this->items[$id] = $currItem;
        $this->totalQuantity++;
        $this->totalPrice += $item->price;
    }

    public function delete($item, $id)
    {
        if (!array_key_exists($id, $this->items)) {
            return false;
        }

        $currItem = $this->items[$id];
        $currItem["quantity"]--;
        if($currItem["quantity"] === 0){
            unset($this->items[$id]);
        }
        $this->totalQuantity--;
        $this->totalPrice -= $item->price;

        return true;
    }
}
