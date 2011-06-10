<?php

// This file exists to avoid XSS errors. Please fix if you know how?

header("Content-Type: text/xml");

echo file_get_contents($_GET['u']);

?>
