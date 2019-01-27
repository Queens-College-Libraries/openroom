<?php 
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('vendor/autoload.php');
include("includes/or-theme.php");
if(password_verify('eejohk3aer','$2y$10$cuOcw19BExoXTM8H3zfQtekhQoo8GKd9XDeGmY5fVusRTtAlwgqAm'))
{
    echo "good job!";
}
