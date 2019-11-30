<?php


namespace App\Service;


use App\Entity\DataCsv;

class statisticService
{
    private $collection;

    private $total_calls    = 0;
    private $total_duration = 0;

    /**
     * @param string $filename
     * @throws \Exception
     */
    public function setData( string $filename )
    {
        $csv = new FileReaderCsv( $filename );

        $this->collection = $this->mapping( $csv->getData() );

        $this->fillContinents(); // get continents from API
        $this->fillGeonames();   // get geonames from file
    }

    /**
     * Fill continent from ipstack API to DataCsv
     */
    private function fillContinents()
    {
        $ipStack = new IpstackService();

        /** @var DataCsv $item */
        foreach ( $this->collection as $item ) {
            $continent = $ipStack->continentByIp( $item->getCustomerIp() );
            $item->setContinent( $continent );
        }
    }

    /**
     * Fill geoname from txtfile to DataCsv
     */
    private function fillGeonames()
    {
        /** @var DataCsv $item */
        foreach ( $this->collection as $item ) {
            $item->setGeoname( CountryInfoService::continentByPhone( $item->getDialedPhoneNumber() ) );
        }
    }

    /**
     * @param array $lines - lines from file
     * @return array - collection of objects DataCsv
     * @throws \Exception
     */
    private function mapping( array $lines )
    {
        $collection = [];
        foreach ( $lines as $line ) {
            $line_array = explode( ',', $line );
            if ( count( $line_array ) < 5 ) { // Simple check data format - need 5 columns
                throw new \Exception( 'Error data format' );
            }
            $collection[] = DataCsv::map( $line_array );
        }

        return $collection;
    }

    public function getStatistic()
    {
        $result_array = [];
        /** @var DataCsv $item */
        foreach ( $this->collection as $item ) {
            $this->total_calls++;
            $this->total_duration += $item->getDuration();
            if ( $item->isSameContinent() ) {
                if ( empty( $result_array[ $item->getCustomerId() ][ 'calls' ] ) ) {
                    $result_array[ $item->getCustomerId() ][ 'calls' ] = 1;
                } else {
                    $result_array[ $item->getCustomerId() ][ 'calls' ] = $result_array[ $item->getCustomerId() ][ 'calls' ] + 1;
                }

                if ( empty( $result_array[ $item->getCustomerId() ][ 'duration' ] ) ) {
                    $result_array[ $item->getCustomerId() ][ 'duration' ] = $item->getDuration();
                } else {
                    $result_array[ $item->getCustomerId() ][ 'duration' ] = $result_array[ $item->getCustomerId() ][ 'duration' ] + $item->getDuration();
                }
            }

            if ( empty( $result_array[ $item->getCustomerId() ][ 'total_calls' ] ) ) {
                $result_array[ $item->getCustomerId() ][ 'total_calls' ] = 1;
            } else {
                $result_array[ $item->getCustomerId() ][ 'total_calls' ] = $result_array[ $item->getCustomerId() ][ 'total_calls' ] + 1;
            }

            if ( empty( $result_array[ $item->getCustomerId() ][ 'total_duration' ] ) ) {
                $result_array[ $item->getCustomerId() ][ 'total_duration' ] = $item->getDuration();
            } else {
                $result_array[ $item->getCustomerId() ][ 'total_duration' ] = $result_array[ $item->getCustomerId() ][ 'total_duration' ] + $item->getDuration();
            }

        }

        return $result_array;
    }

    public function getTotalCalls()
    {
        return $this->total_calls;
    }

    public function getTotalDuration()
    {
        return $this->total_duration;
    }
}