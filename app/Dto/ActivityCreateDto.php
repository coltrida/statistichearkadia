<?php


namespace App\Dto;


final class ActivityCreateDto
{
    //** @var string */
    private $name;

    //** @var float */
    private $costo;

    //** @var string */
    private $tipo;

    /**
     * ActivityCreateDto constructor.
     * @param $name
     * @param $costo
     * @param $tipo
     */
    public function __construct($name, $costo, $tipo)
    {
        $this->name = $name;
        $this->costo = $costo;
        $this->tipo = $tipo;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getCosto() : float
    {
        return $this->costo;
    }

    /**
     * @return string
     */
    public function getTipo() : string
    {
        return $this->tipo;
    }




}
