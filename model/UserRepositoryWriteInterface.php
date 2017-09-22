<?php

namespace model;

interface UserRepositoryWriteInterface
{

    public static function saveUser(\PDO $db, \model\User $user);
}