<?php

require_once '../core/interface_libraries.php';

echo "<h2>Show te config vars</h2>";

$conf = new coreconfig();

echo "App Name: $conf->page_title<BR>";
echo "Copyright: $conf->copyright<BR>";

?>
