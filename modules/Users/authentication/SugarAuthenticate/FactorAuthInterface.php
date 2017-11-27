<?php

interface FactorAuthInterface {

    public function showTokenInput();
    
    public function sendToken($token);
    
    public function validateTokenMessage();

}