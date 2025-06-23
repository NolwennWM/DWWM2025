<?php 
# --- HEADERS ---

// Allow access to the API. "*" means any site is allowed.
header("Access-Control-Allow-Origin: *");
// ? But we could restrict it to a specific site only:
// header("Access-Control-Allow-Origin: https://mon-app-front.com");

// Specifies that the API responses will be in JSON.
header("Content-Type: application/json; charset=UTF-8");

// Cache time for CORS preflight requests (in seconds)
header("Access-Control-Max-Age: 3600");
/* 
    ? When a browser sends a request to an API, a preliminary "preflight" request is sent with the "OPTIONS" method.
    This allows the browser to check whether the site has access rights to the API.
    This header tells the browser how long to cache the result of that check.
*/

// Allows cookies and authentication credentials to be sent.
header("Access-Control-Allow-Credentials: true");

// Specifies allowed headers in client requests.
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
/* 
    - Content-Type  : Allows sending JSON (or other content types)
    - Authorization : Allows sending tokens such as JWT or Bearer
    - X-Requested-With  : Often used by AJAX to indicate a JS request
*/

# --- FUNCTIONS ---

// Defines a custom function to handle PHP errors.
set_error_handler("handleErrors");

/**
 * Sends a standardized JSON response and stops script execution.
 *
 * @param array $data
 * @param int $status
 * @param string $message
 * @return void
 */
function sendResponse(array $data, int $status, string $message): void
{
    http_response_code($status);
    echo json_encode([
        "data"=>$data,
        "status"=>$status,
        "message"=>$message
    ]);
    exit;
}

/**
 * Adds an error to the list of violations, or returns the list of errors.
 *
 * @param bool|string $property Field name
 * @param bool|string $message Error message
 * @return array|void Returns the list of errors if any argument is missing
 */
function setError($property = false, $message = false)
{
    static $error = [];
    // If one of the parameters is missing, return the error array
    if(!$property || !$message)
    {
        return ["violations"=>$error];
    }
    // If both parameters are present, add the error to the array:
    $error[]=[
        "propertyPath"=>$property,
        "message"=>$message
    ];
}

/**
 * Handles PHP errors by converting them to exceptions.
 *
 * @param int $severity Error level
 * @param string $message Error message
 * @param string $file File where the error occurred
 * @param int $line Line number of the error
 * @return void
 * @throws ErrorException
 */
function handleErrors(int $severity, string $message, string $file, int $line)
{
    throw new ErrorException($message, 0, $severity, $file, $line);
}

/**
 * Writes an error message to a log file.
 *
 * @param string $errorMessage Error message
 * @param string $errorFile File where the error occurred
 * @param string $errorLine Line number of the error
 * @return void
 */
function handleLogs(string $errorMessage, string $errorFile, string $errorLine)
{
    $logDir = __DIR__."/logs"; // Log directory
    $logFile = $logDir . "/error.log"; // Log file path
    $date = date("Y-m-d H:i:s"); // Current date and time
    $message = "$date - Error API : $errorMessage - Error File : $errorFile - ErrorLine : $errorLine\n"; // Message to log

    if(!is_dir($logDir))
    {
        mkdir($logDir, 0755, true); // Create directory if it doesn't exist
    }
    error_log($message, 3, $logFile); // Write to log file
    // ? The "3" means the third parameter specifies the file to log into
}

/* 
    mkdir creates a directory, specified as the first parameter.
    The second parameter sets permissions:
        - 0 indicates the next value is in octal
        - 7 gives the owner all rights
        - 5 allows the group to read or execute
        - 5 allows others to read or execute

    The third parameter enables recursion, i.e., creating multiple nested directories:
        - without true: creating "fruits/banana" fails if "fruits" doesn't exist
        - with true: creating "fruits/banana" will create both directories
*/
