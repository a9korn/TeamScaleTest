<?php


namespace App\Service;

class FileReaderCsv
{
    private $filename;

    /**
     * FileReaderCsv constructor.
     * @param string $filename
     */
    public function __construct( string $filename )
    {
        $this->filename = $filename;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getData()
    {
        $lines = [];
        if(!$this->isExists()) {
            throw new \Exception(sprintf('File "%s" does not exists',$this->filename));
        }

        $handle = fopen($this->filename, "r");
        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                $lines[] = preg_replace("/\n/","",$buffer);
            }
            if (!feof($handle)) {
                throw new \Exception("Error reading file!\n");
            }
            fclose($handle);
        }

        return $lines;
    }

    /**
     * @return bool
     */
    private function isExists()
    {
        return file_exists( $this->filename );
    }
}