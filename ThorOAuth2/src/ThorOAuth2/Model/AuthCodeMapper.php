<?php

namespace ThorOAuth2\Model;

use ZfcBase\Mapper\DbMapperAbstract,
    ThorOAuth2\Module as ThorOAuth2,
    ArrayObject,
    DateTime;

class AuthCodeMapper extends DbMapperAbstract implements AuthCodeMapperInterface
{
    protected $tableName         = 'oauth2_code';
    protected $codeField       = 'code';

    public function persist(AuthCodeInterface $code)
    {
    }

    public function insert(AuthCodeInterface $authCode) {
    	$data = new ArrayObject($this->toScalarValueArray($authCode)); // or perhaps pass it by reference?
    	$this->getTableGateway()->insert((array) $data);
    	return $authCode;
    }

    public function findByCode($code)
    {
        $rowset = $this->getTableGateway()->select(array($this->codeField => $code));
        $row = $rowset->current();
        $code = $this->fromRow($row);
        $this->events()->trigger(__FUNCTION__ . '.post', $this, array('code' => $code, 'row' => $row));
        return $code;
    }

    protected function fromRow($row)
    {
        if (!$row) return false;

        $codeModelClass = new Code();
        $code = $codeModelClass::fromArray($row->getArrayCopy());
        return $code;
    }
}
