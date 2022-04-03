<?php


namespace SuiteCRM\MVC\Responds;


interface RespondInterface
{
    public function is_empty(): bool;

    public function show(): string;
}