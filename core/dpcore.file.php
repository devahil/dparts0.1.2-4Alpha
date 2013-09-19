<?php
/**
 * 	D-Parts Web App Framework v 0.1.2-4 APLHA
 *
 * 	@copyright Devahil Leivzieük, devahil@gmail.com 2010 - 2013
 * 	@author devahil@gmail.com
 *
 */

/**
 * This class contains the logic for the subsystem that creates and upload files to the filesystem.
 *
 * @author devahil
 */

require_once 'dpcore.config.php';
require_once 'dpcore.log.php';

class corefile{
    
	public $fileError = null;
	public $filename = null;
	public $fileSize = null;
	public $fileTmp = null;
	public $fileType = null;

	/**
     * Function that provides the file creation subsystem 
     * 
     * @param <type> $names
     * @param <type> $files
     * @param <type> $types
     * @param <type> $sizes
     * @return <type> 
     */
    public function createFiles($names = false, $files = false, $types = false, $sizes = false){

        $conf = new coreconfig();

        if (!is_array($names) and !is_array($files) and !is_array($types)) {
	        return false;
	    }
 
	    for($i = 0; $i <= count($files) - 1; $i++) {
	        $data = $files[$i];
	        $type = $types[$i];

	        ini_set("upload_max_filesize", $conf->upload_max_filesize);
	        ini_set("memory_limit", $conf->memory_limit);
	        ini_set("max_execution_time", $conf->max_execution_time);

	        $parts = explode(".", $names[$i]);
	        $filename = substr(sha1($parts[0]), 0, 15);
	        $extension = end($parts);
	        $dir = "unknown";

	        switch($type) {
	            case 'image/jpeg':
	            	$extension = "jpg";
	            	$dir = "images";
	            	break;
	            case 'image/png':
	            	$extension = "png";
	            	$dir = "images";
	            	break;
	            case 'image/gif':
	            	$extension = "gif";
	            	$dir = "images";
	            	break;
	            case 'application/msword':
	            	$extension = "doc";
	            	$dir = "documents";
	            	break;
	            case 'application/vnd.ms-powerpoint':
	            	$extension = "ppt";
	            	$dir = "documents";
	            	break;
	            case 'application/vnd.ms-excel':
	            	$extension = "xls";
	            	$dir = "documents";
	            	break;
	            case 'application/pdf':
	            	$extension = "pdf";
	            	$dir = "documents";
	            	break;
	            case 'text/plain':
	            	$extension = "txt";
	            	$dir = "documents";
	            	break;
	            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
	            	$extension = "docx";
	            	$dir = "documents";
	            	break;
	            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
	            	$extension = "xlsx";
	            	$dir = "documents";
	            	break;
	            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
	            	$extension = "pptx";
	            	$dir = "documents";
	            	break;
	            case 'application/zip':
	            	$extension = "zip";
	            	$dir = "documents";
	            	break;
	            case 'text/php':
	            	$extension = "php";
	            	$dir = "codes";
	            	break;
	            case 'text/html':
	            	$extension = "html";
	            	$dir = "codes";
	            	break;
	            case 'text/javascript':
	            	$extension = "js";
	            	$dir = "codes";
	            	break;
	            case 'text/css':
	            	$extension = "css";
	            	$dir = "codes";
	            	break;
	            case 'audio/mp3':
	            	$extension = "mp3";
	            	$dir = "audio";
	            	break;
	            case 'video/mp4':
	            	$extension = "mp4";
	            	$dir = "videos";
	            	break;
	            case 'octet-stream':
	            	$extension = "exe";
	            	$dir = "programs";
	            	break;
	        }

	        $data = str_replace("data:$type;base64,", "", $data);
	        $data = str_replace(" ", "+", $data);
	        $data = base64_decode($data);

	        if (file_exists("../uploads/$dir/$filename.$extension")) {
	            $filename = substr(sha1(code(10)), 0, 15);
	        }

	        file_put_contents("../uploads/$dir/$filename.$extension", $data);

	        if (file_exists($file)) {
		        $f[$i]["filename"] = $names[$i];
		        $f[$i]["url"] = $file;
		        $f[$i]["category"] = $dir;
		        $f[$i]["size"] = $sizes[$i];
	        } else {
	        	return false;
	        }
	    }

	    return $f;
	}


    /**
     * Delete files
     *
     * @param <type> $files
     * @return <type>
     */
	public function deleteFiles($files){

		if (is_array($files)) {
			foreach($files as $file) {
				@unlink($file);
			}

			return true;
		} else {
			return false;
		}
	}

    /**
     * Function that provides the info of file
     *
     * @param <type> $filename
     * @return <type>
     */

	public function getFileInformation($filename = false){

		if (!$this->filename and !$filename) {
			return false;
		} else {
			$filename = ($this->filename) ? $this->filename : $filename;
		}

		$file["icon"] = null;

		$parts = explode(".", $filename);

		if (is_array($parts)) {
			$file["name"] = $parts[0];
			$file["extension"] = array_pop($parts);

			$audio = array("wav", "midi", "mid", "mp3", "wma");
			$codes = array("asp", "php", "c", "as", "html", "js", "css", "rb");
			$document = array("csv", "doc", "docx", "pdf", "ppt", "pptx", "txt", "xls", "xlsx");
			$image = array("jpg", "jpeg", "png", "gif", "bmp");
			$programs = array("7z", "ai", "cdr", "fla", "exe", "dmg", "pkg", "iso", "msi", "psd", "rar", "svg", "swf", "zip");
			$video = array("mpg", "mpeg", "avi", "wmv", "asf", "mp4", "flv", "mov");

			if (in_array(strtolower($file["extension"]), $audio)) {
				$file["type"] = "audio";
			} elseif (in_array(strtolower($file["extension"]), $codes)) {
			 	$file["type"] = "code";
			} elseif (in_array(strtolower($file["extension"]), $document)) {
				$file["type"] = "document";
			} elseif (in_array(strtolower($file["extension"]), $image)) {
				$file["type"] = "image";
			} elseif (in_array(strtolower($file["extension"]), $video)) {
				$file["type"] = "program";
			} elseif (in_array(strtolower($file["extension"]), $video)) {
				$file["type"] = "video";
			} else {
				$file["type"] = "unknown";
			}

			$icons = array(
				"txt"  => array(_get("webURL") ."../shared/images/icons/files/text.png", __("Text File")),
				"doc"  => array(_get("webURL") ."../shared/images/icons/files/doc.png", __("Document File")),
				"docx" => array(_get("webURL") ."../shared/images/icons/files/doc.png", __("Document File")),
			 	"pdf"  => array(_get("webURL") ."../shared/images/icons/files/pdf.png", __("PDF File")),
			 	"ppt"  => array(_get("webURL") ."../shared/images/icons/files/ppt.png", __("Power Point File")),
			 	"pptx" => array(_get("webURL") ."../shared/images/icons/files/ppt.png", __("Power Point File")),
			 	"rar"  => array(_get("webURL") ."../shared/images/icons/files/rar.png", __("WinRAR File")),
			 	"iso"  => array(_get("webURL") ."../shared/images/icons/files/rar.png", __("ISO File")),
			 	"xls"  => array(_get("webURL") ."../shared/images/icons/files/xls.png", __("Excel File")),
			 	"xlsx" => array(_get("webURL") ."../shared/images/icons/files/xls.png", __("Excel File")),
			 	"csv"  => array(_get("webURL") ."../shared/images/icons/files/xls.png", __("Excel File")),
			 	"zip"  => array(_get("webURL") ."../shared/images/icons/files/zip.png", __("WinZIP File")),
			 	"7z"   => array(_get("webURL") ."../shared/images/icons/files/7z.png",  __("7z File")),
			 	"ai"   => array(_get("webURL") ."../shared/images/icons/files/ai.png",  __("Adobe Illustrator File")),
			 	"svg"  => array(_get("webURL") ."../shared/images/icons/files/ai.png",  __("Adobe Illustrator File")),
			 	"cdr"  => array(_get("webURL") ."../shared/images/icons/files/cdr.png", __("Corel Draw File")),
			 	"msi"  => array(_get("webURL") ."../shared/images/icons/files/exe.png", __("Executable File")),
			 	"exe"  => array(_get("webURL") ."../shared/images/icons/files/exe.png", __("Executable File")),
			 	"dmg"  => array(_get("webURL") ."../shared/images/icons/files/exe.png", __("Executable File")),
			 	"pkg"  => array(_get("webURL") ."../shared/images/icons/files/exe.png", __("Executable File")),
			);

			foreach($icons as $extension => $icon) {
				if ($file["extension"] === $extension) {
					$file["icon"] = $icon;
					break;
				}
			}

			return $file;
		}

		return false;
	}


    /**
     * Function that uploads a file into filesystem
     *
     * @param <type> $path
     * @param <type> $type
     * @return <type>
     *
     */

	public function upload($path = null, $type = "image"){

		$conf = new coreconfig();
        $message = new corelog();
        
        ini_set("post_max_size", $conf->post_max_size);
		ini_set("upload_max_filesize", $conf->upload_max_filesize);
		ini_set("max_execution_time", $conf->max_execution_time);
		ini_set("max_input_time", $conf->max_input_time);

		$file = $this->getFileInformation();

		if (!$file) {
            return $message->sysmessages("8");
		}

		$filename = code(5, false) ."_". slug($file["name"]) .".". $file["extension"];
		$URL = $path . $filename;

		if (file_exists($URL)) {
            $error["upload"] = false;
			$error = $message->sysmessages("6");
            $error["filename"] = $filename;
		} elseif ($this->fileSize > FILE_SIZE) {
            $error["upload"] = false;
			$error = $message->sysmessages("9");
            $error["filename"] = $filename;
		} elseif ($this->fileError === 1) {
			$error = $message->sysmessages("3");
            $error["upload"] = false;
            $error["filename"] = $filename;
		} elseif ($file["type"] !== $type) {
            $error["upload"] = false;
			$error = $message->sysmessages("10");
            $error["filename"] = $filename;
		} elseif (move_uploaded_file($this->fileTmp, $URL)) {
			chmod($URL, 0777);
			$error["upload"] = true;
            $error = $message->sysmessages("2");
			$error["filename"] = $filename;
		} else {
			$error["upload"] = false;
            $error = $message->sysmessages("8");
		}

		return $error;
	}

    /**
     * Create a file on 64Base
     * 
     * @param <bin> $data
     * @param <string> $filename
     * @return <bin> 
     */
	public function createFileFromBase64($data, $filename = false){
        
		$start = strpos($data, ",") + 1;
		$base64 = substr($data, $start);
		$base64 = str_replace(" ", "+", $base64);
        $data = base64_decode($base64);

        if (is_string($filename)) {
        	file_put_contents($filename, $data, LOCK_EX);

        	if (file_exists($filename)) {
        		return true;
        	} else {
        		return false;
        	}
        }

        return $data;
	}
}
?>
