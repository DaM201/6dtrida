<?php
session_start();
unset($_SESSION['profile_name']);
http_response_code(200);
echo "Úspěšně smazáno jméno.";
exit();
?>
