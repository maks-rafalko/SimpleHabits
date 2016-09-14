<?php

declare(strict_types=1);

namespace SimpleHabits\Domain\Model\User;

class User
{
    const PASSWORD_MIN_LENGTH = 1;

    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * User constructor.
     *
     * @param UserId $userId
     * @param string $email
     * @param string $password
     */
    public function __construct(UserId $userId, string $email, string $password)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return UserId
     */
    public function getId() : UserId
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function changePassword(string $password)
    {
        \Assert\that($password)->notEmpty()->string()->minLength(self::PASSWORD_MIN_LENGTH);

        $this->password = $password;
    }
}
