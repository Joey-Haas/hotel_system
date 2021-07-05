<?php
session_start();
session_destroy();
// Redirect naar de login pagina:
header('Location: login.html');
?>
