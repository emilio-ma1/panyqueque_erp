<?php
/**
 * Canonical 301 redirect from legacy Spanish endpoint to English POS URL.
 * Complies with Section 7.1.1 (Consistent URL English naming convention).
 */
header('Location: pos.php', true, 301);
exit;
