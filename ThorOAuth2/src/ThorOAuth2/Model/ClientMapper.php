<?php

namespace ThorOAuth2\Model;

use ZfcBase\Mapper\DbMapperAbstract,
    ThorOAuth2\Module as ThorOAuth2,
    ArrayObject,
    DateTime;

class ClientMapper extends DbMapperAbstract implements ClientMapperInterface
{
    protected $tableName         = 'oauth2_client';
    protected $clientIdField       = 'client_id';

    public function persist(ClientInterface $client)
    {
        $data = new ArrayObject($this->toScalarValueArray($client)); // or perhaps pass it by reference?
        $this->events()->trigger(__FUNCTION__ . '.pre', $this, array('data' => $data, 'client' => $client));
        if ($client->getClientId() > 0) {
            $this->getTableGateway()->update((array) $data, array($this->clientIDField => $client->getClientId()));
        } else {
            $this->getTableGateway()->insert((array) $data);
            $clientId = $this->getTableGateway()->getAdapter()->getDriver()->getLastGeneratedValue();
            $client->setClientId($clientId);
        }
        return $client;
    }

    public function findById($id)
    {
        $rowset = $this->getTableGateway()->select(array($this->clientIdField => $id));
        $row = $rowset->current();
        $client = $this->fromRow($row);
        $this->events()->trigger(__FUNCTION__ . '.post', $this, array('client' => $client, 'row' => $row));
        return $client;
    }

    protected function fromRow($row)
    {
        if (!$row) return false;

        $clientModelClass = new Client();
        $client = $clientModelClass::fromArray($row->getArrayCopy());
        return $client;
    }
}
