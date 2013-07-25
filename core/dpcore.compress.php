<?php

/**
 *   D-Parts Web App Framework v 0.1.2-4 APLHA
 * 	
 * 	@copyright Devahil Leivzieük, devahil@gmail.com 2010 - 2013
 * 	@author devahil@gmail.com
 * 	
 */

/**
 * The function to allows you compress info
 */
class corecompress {
   
    
    /**
     * Function that allows you to compress a file in Zip Format
     * 
     * @param type $resultfilename
     * @param type $filepathtocompress
     * @return type String as Header Location for Compressed File
     */
    public function compress($resultfilename, $filepathtocompress){
        
        $zip = new ZipArchive();
        $zip->open($resultfilename, ZipArchive::CREATE);
        
        $files = scandir($filepathtocompress);
        
        unset($files[0], $files[1]);
        
        foreach ($files as $file){
            $zip->addFile("$filepathtocompress/($file)","$files/($file)");
        }
        
        $zip->close();
        
        $str = "header('Location: $resultfilename')";
        return $str;
    }
    
    
    
    
}

?>
