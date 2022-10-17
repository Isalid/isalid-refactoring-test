<?php

namespace App\Entity;

class User
{
    private int $id;
    private string $firstname;
    private string $lastname;
    private string $email;

    public function __construct(int $id, string $firstname, string $lastname, string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \RuntimeException('Param $email must be a valid email.');
        }

        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
