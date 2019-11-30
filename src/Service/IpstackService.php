<?php


namespace App\Service;


class IpstackService
{
    const APIKEY = 'd9f000dbc0237078dfb39bf8033d244c';

    /** @var array */
    private $continents = [];

    /**
     * @param string $ip
     * @return string
     */
    public function continentByIp( string $ip )
    {
        if ( array_key_exists( $ip, $this->continents ) ) { // find in cache
            return $this->continents[ $ip ];
        }

        $query   = sprintf( "http://api.ipstack.com/%s?access_key=%s", $ip, self::APIKEY );
        $content = json_decode( file_get_contents( $query ) );

        if ( !empty( $content->continent_code ) ) {
            $this->continents[ $ip ] = $content->continent_code; // add to cache
            return $content->continent_code;
        }

        return '';
    }
}