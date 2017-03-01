<?php
if(!isset($_SESSION)){
    session_start();    
    $_SESSION['success'] = "";
    $_SESSION['error'] = ""; 
}