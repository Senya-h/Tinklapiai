<?php

namespace OOP;

class User {
    protected $name, $email, $phone, $comment;

    public function __construct($name, $email, $phone) {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    public function profile() {
        $data[] = $this->name;
        $data[] = $this->email;
        $data[] = $this->phone;
        $data[] = $this->comment;
        return $data;
    }

}