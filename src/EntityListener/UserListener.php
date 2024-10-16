<?php

Namespace App\EntityListener;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener
{
    private UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordHasherInterface $hasher )
    {
        $this->hasher = $hasher;
    }
    public function prePersist(User $user)
    {

    }
    public function preUpdate(User $user)
    {

    }
    public function encodePassword(User $user)
    {
        if ($user->getPlainPassword() == null)
        {
            return ;
        }
        $user->setPassword(
            $user,
            $user->getPlainPassword()
        );


    }
}
