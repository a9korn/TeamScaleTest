<?php


namespace App\Service;


class CountryInfoService
{
    private $filename = 'countryInfo.txt';

    /**
     * CountryInfoService constructor.
     */
    private function __construct()
    {
        $this->loadFromFile();
    }

    /**
     * @return array
     */
    public function loadFromFile():array
    {
        $continents = [];
        $content    = file_get_contents( ROOTPATH . $this->filename );
        $lines      = explode( "\n", $content );
        foreach ( $lines as $line ) {
            $line_array = explode( "\t", $line );
            if ( count( $line_array ) < 18 ) continue;
            if ( empty( $line_array[ 12 ] ) OR empty( $line_array[ 8 ] ) ) continue;

            if ( preg_match( "#^\d+$#", $line_array[ 12 ] ) ) {
                $continents[ $line_array[ 12 ] ] = $line_array[ 8 ];
            }
        }

        return $continents;
    }

    /**
     * @param string $phone
     * @return string
     */
    public static function continentByPhone( string $phone ): string
    {
        $continent  = '';
        $obj        = new self();
        $continents = $obj->loadFromFile();

        $threeSearch = $obj->searchBySymb( $phone, $continents );
        if ( $threeSearch ) return $threeSearch;

        $twoSearch = $obj->searchBySymb( $phone, $continents, 2 );
        if ( $twoSearch ) return $twoSearch;

        $oneSearch = $obj->searchBySymb( $phone, $continents, 1 );
        if ( $oneSearch ) return $oneSearch;

        return $continent;
    }

    /**
     * @param string $phone
     * @param array $continents
     * @param int $symb_count
     * @return string|null
     */
    private function searchBySymb( string $phone, array $continents, int $symb_count = 3 ):?string
    {
        $continent = null;

        $threeSearchStr = substr( $phone, 0, $symb_count );
        if ( array_key_exists( $threeSearchStr, $continents ) ) {
            $continent = $continents[ $threeSearchStr ];
        }

        return $continent;
    }
}