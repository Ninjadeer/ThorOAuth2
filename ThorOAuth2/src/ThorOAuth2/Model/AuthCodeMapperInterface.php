<?php

namespace ThorOAuth2\Model;

interface AuthCodeMapperInterface
{
    public function persist(AuthCodeInterface $user);

    public function findByCode($id);
}
