<?php
/**
 * 	D-Parts Web App Framework v 0.1.2-4 APLHA
 *
 * 	@copyright Devahil Leivzieük, devahil@gmail.com 2010 - 2013
 * 	@author devahil@gmail.com
 *
 */

/**
 * Description of dpcorexmlserializer
 *
 * @author devahil
 */
class corexmlserializer{
    
    private $XML = NULL;


    /**
     *
     * function that sets the xml segment creation
     *
     * @param <type> $array
     * @param <type> $ID
     * @return <bool>
     */
    private function xml_create($array, $ID){

        if (is_array($array)) {
            $keys = array_keys($array);

            for($i = 0; $i < sizeof($keys); $i++) {
                $tag = $keys[$i];

                if (is_numeric($tag)) {
                    $tag = $ID;
                }

                if ($tag === "_id") {
                    $tag = "id";
                }

                $this->XML .= ($tag === $ID) ? "<". strtolower($tag) .">" : "<". strtolower($tag) .">";
                $this->xml_create($array[$keys[$i]], $ID);
                $this->XML .= ($tag === $ID) ? "</". strtolower($tag) .">" : "</". strtolower($tag) .">";
            }
        } elseif (!empty($array)) {
            if ($this->checkForHTML($array)) {
                $array = '<![CDATA['. $array .']]>';
            }

            $this->XML .= $array;
        } else {
            return false;
        }
    }


    /**
     * Function that checks the HTML segment compared with xml
     *
     * @param <type> $string
     * @return <bool>
     */
    private function checkForHTML($string){

        if (strlen($string) !== strlen(strip_tags($string))) {
            return true;
        }

        return false;
    }

    
    /**
     * Function that displays a XML
     *
     * @param <type> $array
     * @param <type> $root
     * @param <type> $ID 
     */
    public function printXML($array, $root = "data", $ID = "node"){
        
        $this->toXML($array, $root, $ID);
        header("Content-Type: text/xml");
        print $this->XML;
    }

    
    /**
     * Convert an array to XML
     *
     * @param <type> $array
     * @param <type> $root
     * @param <type> $ID
     * @return <string>
     */
    public function toXML($array, $root = "data", $ID = "node"){

        $this->XML .= '<?xml version="1.0" encoding="UTF-8"?>';
        $this->XML .= "<". strtolower($root) .">";
        $this->XML .= $this->xml_create($array, $ID);
        $this->XML .= "</". strtolower($root) .">";
        return $this->XML;
    }
}

?>
