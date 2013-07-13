<?php
if ($_GET['randomId'] != "Aqu0xIDx_2gD6IlP9kJCYdEnfXKPDibaOt6TLkSDfEI8HUfOA79QpAhkmEoR3aqT") {
    echo "Access Denied";
    exit();
}

// display the HTML code:
echo stripslashes($_POST['wproPreviewHTML']);

?>  
