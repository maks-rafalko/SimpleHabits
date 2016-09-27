<?php

declare(strict_types=1);

namespace SimpleHabits\Domain\Model\User;

class User
{
    const PASSWORD_MIN_LENGTH = 1;

    /**
     * @var UserId
     */
    protected $id;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * User constructor.
     *
     * @param UserId $userId
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct(UserId $userId, string $username, string $email, string $password)
    {
        $this->id = $userId;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return UserId
     */
    public function getId() : UserId
    {
        return $this->id;
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

    /**
     * @return string
     */
    public function getUsername() : string
    {
        return $this->username;
    }
}
