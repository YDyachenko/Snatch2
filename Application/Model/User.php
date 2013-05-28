<?php

namespace Application\Model;

class User extends AbstractModel
{
    public function checkForceChangePassword()
    {
        return (bool)$this->force_change_password;
    }
}