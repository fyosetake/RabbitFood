<?php

class HamburguerFactory
{
    public static function createHamburguer($type)
    {
        return match ($type) {
            'cheese' => new CheeseBurger(),
            'chicken' => new ChickenBurger(),
            default => throw new InvalidArgumentException("Tipo de hamburguer inválido: $type"),
        };
    }
}

class CheeseBurger
{
    public function getDescription()
    {
        return "Cheeseburger delicioso!";
    }
}

class ChickenBurger
{
    public function getDescription()
    {
        return "Frango grelhado no pão!";
    }
}
