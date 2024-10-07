<?php 

namespace App\DTOs;

class Base {
    public function find(string $name) {
        return $this->$name;
    }
}