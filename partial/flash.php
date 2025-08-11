<?php
// Start the session if it's not already started
if (!session_id()) session_start();

/**
 * Set a flash message to show once
 *
 * @param string $type "success", "error", "warning"
 * @param string $message Message to display
 */
function flash($type, $message) {
    $_SESSION['flash'][$type][] = $message;
}
