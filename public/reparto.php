<?php
/**
 * Canonical 301 redirect from legacy Spanish endpoint to English dispatch URL.
 * Complies with Section 7.1.1 (Consistent URL English naming convention).
 */
header('Location: dispatch.php', true, 301);
exit;
