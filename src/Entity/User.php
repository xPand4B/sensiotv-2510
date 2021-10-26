<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\Unique;

#[Entity(repositoryClass: UserRepository::class)]
#[Table(name: 'users')]
//#[UniqueEntity('email')]
class User implements PasswordAuthenticatedUserInterface
{
    #[Id, GeneratedValue, Column(type: 'integer')]
    private ?int $id;

    #[Column(type: 'string', length: 50)]
    private ?string $firstname;

    #[Column(type: 'string', length: 50)]
    private ?string $lastname;

    #[Column(type: 'string', length: 200)]
    #[Email]
    private ?string $email;

    #[Column(type: 'string', length: 20, nullable: true)]
    private ?string $phone;

    #[Column(type: 'string', length: 255)]
    #[/*NotCompromisedPassword,*/ Length(min: 8)]
    private ?string $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

//    #[IsTrue(message: 'The password should not contain other field values.')]
//    public function isValidPassword(): bool
//    {
//        if (!str_contains($this->password, $this->email)) {
//            return true;
//        }
//
//        return false;
//    }
}
