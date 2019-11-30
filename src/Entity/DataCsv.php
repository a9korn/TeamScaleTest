<?php


namespace App\Entity;


class DataCsv
{
    /**
     * @var int
     */
    private $customerId;

    /**
     * @var \DateTime
     */
    private $callDate;

    /**
     * @var int
     */
    private $duration;

    /**
     * @var int
     */
    private $dialedPhoneNumber;

    /**
     * @var string
     */
    private $customerIp;

    /**
     * @var string
     */
    private $continent;


    /**
     * @var string
     */
    private $geoname;

    public function __construct(
        $customerId,
        $callDate,
        $duration,
        $dialedPhoneNumber,
        $customerIp
    )
    {
        $this->customerId        = $customerId;
        $this->callDate          = $callDate;
        $this->duration          = $duration;
        $this->dialedPhoneNumber = $dialedPhoneNumber;
        $this->customerIp        = $customerIp;
        $this->setContinent('');
        $this->setGeoname('');
    }

    /**
     * @param array $data
     * @return DataCsv
     */
    public static function map( array $data )
    {
        return new self(
            $data[ 0 ],
            $data[ 1 ],
            $data[ 2 ],
            $data[ 3 ],
            $data[ 4 ]
        );
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    /**
     * @return \DateTime
     */
    public function getCallDate(): \DateTime
    {
        return $this->callDate;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return int
     */
    public function getDialedPhoneNumber(): int
    {
        return $this->dialedPhoneNumber;
    }

    /**
     * @return string
     */
    public function getCustomerIp(): string
    {
        return $this->customerIp;
    }

    /**
     * @return string
     */
    public function getContinent(): string
    {
        return $this->continent;
    }

    /**
     * @return string
     */
    public function getGeoname(): string
    {
        return $this->geoname;
    }

    /**
     * @param string $continent
     */
    public function setContinent( string $continent )
    {
        $this->continent = $continent;
    }

    /**
     * @param string $geoname
     */
    public function setGeoname( string $geoname )
    {
        $this->geoname = $geoname;
    }

    /**
     * @return bool
     */
    public function isSameContinent()
    {
        return $this->getGeoname() == $this->getContinent();
    }
}