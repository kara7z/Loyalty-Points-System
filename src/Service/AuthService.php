<?php
namespace App\Service;

use App\Core\Session;
use App\Model\User;

final class AuthService
{
    public function __construct(private User $users, private Session $session) {}

    public function userId(): ?int
    {
        return $this->session->get('user_id');
    }

    public function requireLogin(): int
    {
        $id = $this->userId();
        if (!$id) throw new \RuntimeException('AUTH_REQUIRED');
        return (int)$id;
    }

    public function register(string $email, string $password, ?string $name): int
    {
        $email = trim(strtolower($email));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new \InvalidArgumentException('Invalid email');
        if (strlen($password) < 6) throw new \InvalidArgumentException('Password too short (min 6)');
        if ($this->users->findByEmail($email)) throw new \InvalidArgumentException('Email already used');

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $id = $this->users->create($email, $hash, $name);
        $this->session->set('user_id', $id);
        return $id;
    }

    public function login(string $email, string $password): int
    {
        $email = trim(strtolower($email));
        $user = $this->users->findByEmail($email);
        if (!$user || !password_verify($password, $user['password_hash'])) {
            throw new \InvalidArgumentException('Wrong email or password');
        }
        $this->session->set('user_id', (int)$user['id']);
        return (int)$user['id'];
    }

    public function logout(): void
    {
        $this->session->remove('user_id');
    }
}
