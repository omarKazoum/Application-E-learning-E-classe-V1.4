<?php
class User{
    protected bool $isAdmin=false;

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }
    protected string $email;
    protected string $userName;
    protected string $passwordHash;
    protected int $id;
    public function __construct(int $id=-1,string $email='',string $userName='',string $passwordHash='',bool $isAdmin=true){
        $this->email=$email;
        $this->userName=$userName;
        $this->passwordHash=$passwordHash;
        $this->id=$id;
        $this->isAdmin=$isAdmin;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getUserName(): ?string
    {
        return $this->userName;
    }

    /**
     * @param string|null $userName
     */
    public function setUserName(?string $userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @return string|null
     */
    public function getPasswordHash(): ?string
    {
        return $this->passwordHash;
    }

    /**
     * @param string|null $passwordHash
     */
    public function setPasswordHash(?string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

}