<?php
/**
 * Created by PhpStorm.
 * User: moksleivis
 * Date: 2020-01-30
 * Time: 14:40
 */

namespace OOP;


class Spausdintuvas {
    public static function spausdinti($data) {
        foreach($data as $value) {
            echo $value . "<br>";
        }
    }
}