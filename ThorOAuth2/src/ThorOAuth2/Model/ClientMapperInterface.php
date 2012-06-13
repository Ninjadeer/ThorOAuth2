<?php

namespace ThorOAuth2\Model;

interface ClientMapperInterface
{
    public function persist(ClientInterface $user);

    public function findById($id);
}
