<?php


class B extends Object {
    private $name;

    public function  __construct() {
        $this->name="B class Object";
    }
    public function  __toString() {
        return "Object of type B";
    }

    public function Greet(){
        echo "Hello";
    }

}


tri
