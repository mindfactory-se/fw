<?php

class FooBarModel extends modFooModel {

    public function __construct() {
        
    }

    public function index() {
        return 'Mod: foo - OK<br>Controller: bar - OK<br>Action: index - OK';
    }
}