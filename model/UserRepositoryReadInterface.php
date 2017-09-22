<?php

namespace model;

interface UserRepositoryReadInterface
{

    public static function fetchByUsername(\PDO $db, string $username);

    public static function fetchByEmail(\PDO $db, string $email);
}