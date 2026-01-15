<?php
namespace App\Model;

use DateTime;

class User
{
    private int $user_id;
    private string $email;
    private string $password_hash;
    private string $name;
    private int $total_points;
    private DateTime $createdat;
    function __construct($email, $password_hash, $name)
    {
        $this->email = $email;
        $this->password_hash = $password_hash;
        $this->name = $name;
    }
}
