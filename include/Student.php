<?php
require_once 'User.php';

class Student extends User{
    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getEnrollNbr(): string
    {
        return $this->enrollNbr;
    }

    /**
     * @param string $enrollNbr
     */
    public function setEnrollNbr(string $enrollNbr): void
    {
        $this->enrollNbr = $enrollNbr;
    }

    /**
     * @return string
     */
    public function getDateAdmission(): string
    {
        return $this->dateAdmission;
    }

    /**
     * @param string $dateAdmission
     */
    public function setDateAdmission(string $dateAdmission): void
    {
        $this->dateAdmission = $dateAdmission;
    }
    protected ?string $imageUrl;
    protected ?string $phone;
    protected ?string $enrollNbr;
    protected ?string $dateAdmission;
    public function __construct(int $id=-1,string $email='',string $userName='',string $passwordHash='',string $imageUrl='',string $phone='',string $enrollNbr='',string $dateAdmission=''){
        parent::__construct($id,$email,$userName,$passwordHash,false);
            $this->imageUrl=$imageUrl;
            $this->phone=$phone;
            $this->enrollNbr=$enrollNbr;
            $this->dateAdmission=$dateAdmission;
        }

}