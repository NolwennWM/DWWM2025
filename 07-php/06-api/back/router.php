<?php

try
{
    // Retrieve and sanitize the requested URL
    $url = filter_var($_SERVER["REQUEST_URI"], FILTER_SANITIZE_URL);
    $url = explode("?", $url)[0]; // Remove possible GET parameters
    $url = trim($url, "/");       // Remove slashes from beginning/end

    // Check if the URL matches a defined route
    if (array_key_exists($url, ROUTES)) {
        // Include the corresponding controller
        $controllerPath = "./controller/" . ROUTES[$url];
        if (file_exists($controllerPath)) {
            require($controllerPath);
        } else {
            sendResponse([], 500, "Controller Not Found");
        }
    } else {
        sendResponse([], 404, "Not Found");
    }
}
catch (\Throwable $e) {
    // Log the error in the error.log file
    handleLogs($e->getMessage(), $e->getFile(), $e->getLine());

    $error = [];
    if(APP_ENV === "dev")
    {
        $error = [
            "errorMessage"=>$e->getMessage(),
            "errorFile"=>$e->getFile(),
            "errorLine"=>$e->getLine()
        ];
    }
    sendResponse($error, 500, "Internal Server Error");
}
