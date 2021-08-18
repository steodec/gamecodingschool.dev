<?php

namespace Steodec\Entity;

use Steodec\Attribute\Form;
use Steodec\Common\FormConstant;

class Users
{
    private string $id;

    #[Form("register_form", "email", FormConstant::TYPE_EMAIL, FALSE, TRUE)]
    #[Form("login_form", "email", FormConstant::TYPE_EMAIL)]
    public string $email;

    #[Form("register_form","username", FormConstant::TYPE_TEXT, FALSE)]
    public string $username;

    #[Form("register_form", "password", FormConstant::TYPE_PASSWORD, FALSE, TRUE)]
    #[Form("login_form", "password", FormConstant::TYPE_PASSWORD)]
    public string $password;

    public ?array $roles = ["ROLE_MEMBER"];

    /**
     * @param string $id
     */
    public function set_id(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function get_id(): string
    {
        return $this->id;
    }

    /**
     * @param string $email
     */
    public function set_email(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function get_email(): string
    {
        return $this->email;
    }

    /**
     * @param string $username
     */
    public function set_username(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function get_username(): string
    {
        return $this->username;
    }

    /**
     * @param string $password
     */
    public function set_password(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function get_password(): string
    {
        return $this->password;
    }

    /**
     * @param array|string[]|null $roles
     */
    public function set_roles(?array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return array|null
     */
    public function get_roles(): ?array
    {
        return $this->roles;
    }


}