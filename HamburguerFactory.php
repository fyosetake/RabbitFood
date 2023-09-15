<?php

class HamburguerFactory
{
    public static function createHamburguer($type)
    {
        switch ($type) {
            case 'cheese':
                return new CheeseBurger();
            case 'chicken':
                return new ChickenBurger();
            default:
                throw new InvalidArgumentException("Tipo de hamburguer inválido: $type");
        }
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
