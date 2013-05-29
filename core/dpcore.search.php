<?php

/**
 * 	D-Parts Web App Framework v 0.1.2-4 APLHA
 * 	
 * 	@copyright Devahil Leivzieük, devahil@gmail.com 2010 - 2013
 * 	@author devahil@gmail.com
 * 	
 */
/**
 * Logical structure for functions that are used for advanced searches within the apps to be developed with the core.
 */
require_once 'dpcore.db.php';

class coresearch {

    /**
     * Function meets finding any data on any attribute of an entity, and returns the location (attribute) which was found
     * 
     * 1. We walk each attribute of the entity to find the entry you want
     * 2. We logical proof of the existence of data
     * 3. If there is, back where he found, If not, return NULL location!
     * 
     * @param string $entity
     * @param string $data
     * @return array 
     */
    public function find_anything_inplace($entity, $data) {
        $result = $this->query("SHOW COLUMNS FROM $entity");
        while ($array_datos = mysql_fetch_array($result)) {
            $check = @mysql_fetch_row($this->query("SELECT $array_datos[0] FROM $entity WHERE $array_datos[0] lIKE '$data'"));
            if ($check != NULL) {
                return $array_datos[0];
                break;
            } else {
                return NULL;
            }
        }
    }

    /**
     * Function that searches for keywords within a column tuple we say. Where keywords are the search criteria, 
     * and delimiter is a sign that helps us perform the separation of these criteria. 
     * These delimiters may kindly be punctuation marks as . , or ""
     * 
     * @param string $keywords
     * @param string $delimiter
     * @param string $entity
     * @param string $atribute
     * @return array 
     */
    public function d_search($keywords, $delimiter, $entity, $atribute) {
        $data = new dwaf_mysql();
        $i = 0;
        $terms = explode($delimiter, $keywords);
        foreach ($terms as $each) {
            $i++;
            if ($i == 1) {
                $core_search = "SELECT * FROM '$entity' WHERE '$atribute' LIKE '%$each%'";
            } else {
                $core_search = "SELECT * FROM '$entity' WHERE '$atribute' LIKE '%$each%'";
            }
        }
        $query = $data->query($core_search);
        $numrows = mysql_numrows($query);
        if ($numrows > 0) {
            return $row = mysql_fetch_assoc($query);
        } else {
            return "0";
        }
    }

}

?>
