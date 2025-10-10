<?php
/**
 * helper.php
 * 
 * Basic native PHP helper functions for input/output cleaning.
 * 
 * ⚠️ NOTE:
 * - For database queries, always use prepared statements (PDO / MySQLi).
 * - These helpers are for cleaning user input/output in HTML, URLs, etc.
 */

/**
 * Clean text for safe HTML output
 *
 * @param string $value
 * @return string
 */
function clean_text(string $value): string {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

/**
 * Clean text for safe database insertion (legacy only)
 * Use prepared statements instead if possible!
 *
 * @param mysqli $conn
 * @param string $value
 * @return string
 */
function clean_sql(mysqli $conn, string $value): string {
    return mysqli_real_escape_string($conn, trim($value));
}

/**
 * Clean integer value
 *
 * @param mixed $value
 * @return int
 */
function clean_int($value): int {
    return (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
}

/**
 * Clean email
 *
 * @param string $value
 * @return string|null
 */
function clean_email(string $value): ?string {
    $email = filter_var(trim($value), FILTER_SANITIZE_EMAIL);
    return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null;
}

/**
 * Clean URL
 *
 * @param string $value
 * @return string|null
 */
function clean_url(string $value): ?string {
    $url = filter_var(trim($value), FILTER_SANITIZE_URL);
    return filter_var($url, FILTER_VALIDATE_URL) ? $url : null;
}
