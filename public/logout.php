<?php
/**
 * User Logout endpoint for Pan y Queque ERP.
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/AuthService.php';

AuthService::logout();
header('Location: login.php');
exit;
