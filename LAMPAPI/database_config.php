<?php
if (file_exists(__DIR__ . "/database.php"))
{
    require_once __DIR__ . "/database.php";
}
else
{
    $requiredVariables = [
        "DB_HOST" => "host",
        "DB_USER" => "username",
        "DB_PASS" => "password",
        "DB_NAME" => "database"
    ];

    $resolvedValues = [];

    foreach ($requiredVariables as $envName => $constantName)
    {
        $value = getenv($envName);

        if ($value === false || $value === "")
        {
            http_response_code(500);
            error_log("Missing required database configuration: " . $envName);
            exit("Missing required database configuration: " . $envName);
        }

        $resolvedValues[$constantName] = $value;
    }

    define("host", $resolvedValues["host"]);
    define("username", $resolvedValues["username"]);
    define("password", $resolvedValues["password"]);
    define("database", $resolvedValues["database"]);
}
?>
