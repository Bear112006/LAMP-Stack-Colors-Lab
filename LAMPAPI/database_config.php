<?php
if (file_exists(__DIR__ . "/database.php"))
{
    require_once __DIR__ . "/database.php";
}
else
{
    define("host", getenv("DB_HOST") ?: "127.0.0.1");
    define("username", getenv("DB_USER") ?: "TheBeast");
    define("password", getenv("DB_PASS") ?: "WeLoveCOP4331");
    define("database", getenv("DB_NAME") ?: "COP4331_TEST");
}
?>
