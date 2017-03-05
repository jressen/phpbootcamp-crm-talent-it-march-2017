<?php

namespace Contact\Model;


use Contact\Entity\CountryInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Hydrator\HydratorInterface;

class CountryModel implements CountryModelInterface
{
    /**
     * @var AdapterInterface
     */
    protected $db;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @var CountryInterface
     */
    protected $countryPrototype;

    /**
     * CountryModel constructor.
     *
     * @param AdapterInterface $db
     * @param HydratorInterface $hydrator
     * @param CountryInterface $countryPrototype
     */
    public function __construct(
        AdapterInterface $db,
        HydratorInterface $hydrator,
        CountryInterface $countryPrototype
    )
    {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->countryPrototype = $countryPrototype;
    }

    /**
     * @inheritDoc
     */
    public function getAllCountries()
    {
        $sql = new Sql($this->db);
        $select = $sql->select('country');

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new \RuntimeException('Cannot connect to data storage');
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->countryPrototype);
        $resultSet->initialize($result);

        return $resultSet;
    }

    /**
     * @inheritDoc
     */
    public function getCountryByCountryCode($countryCode)
    {
        $sql = new Sql($this->db);
        $select = $sql->select('country');
        $select->where(['iso = ?' => $countryCode]);

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new \RuntimeException('Cannot connect to data storage');
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->countryPrototype);
        $resultSet->initialize($result);

        return $resultSet;
    }

}