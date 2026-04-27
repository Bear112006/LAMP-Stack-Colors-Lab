<?php
function loadDatabaseConfigFromEnvironment()
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
            return null;
        }

        $resolvedValues[$constantName] = $value;
    }

    return $resolvedValues;
}

$resolvedValues = loadDatabaseConfigFromEnvironment();

if ($resolvedValues !== null)
{
    define("host", $resolvedValues["host"]);
    define("username", $resolvedValues["username"]);
    define("password", $resolvedValues["password"]);
    define("database", $resolvedValues["database"]);
}
elseif (file_exists(__DIR__ . "/database.php"))
{
    require_once __DIR__ . "/database.php";
}
else
{
    $missingVariables = [];

    foreach (["DB_HOST", "DB_USER", "DB_PASS", "DB_NAME"] as $envName)
    {
        $value = getenv($envName);

        if ($value === false || $value === "")
        {
            $missingVariables[] = $envName;
        }
    }

    http_response_code(500);
    error_log("Missing required database configuration: " . implode(", ", $missingVariables));
    exit("Missing required database configuration: " . implode(", ", $missingVariables));
}

?>
