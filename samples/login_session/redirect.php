<?php

    switch ($_GET['err']) {
        case 5: $string= "U Don't have access here";
        break;
    }
    
    echo $string;
?>
<BR>
<a href="javascript:history.go(-1);">Back</a>