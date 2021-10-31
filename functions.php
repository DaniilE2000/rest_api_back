<?php

require 'api.php';

// Content type constants
const CONTENT_TYPE_JSON = 'json';
const CONTENT_TYPE_HTML = 'html';

/**
 * Writes a response in an output stream.
 * 
 * @param mixed $content A content to write.
 * @param string $type   A content type.
 * @param int $code      An http response code.
 * 
 * @return void
 */
function respondWith(mixed $content, string $type = CONTENT_TYPE_JSON, int $code = 200): void
{
    \http_response_code($code);
    setContentType($type);

    echo \json_encode($content);
}

/**
 * Sets response content type.
 * 
 * @param string $type Desired content type (one of the content type constants).
 * 
 * @return void
 */
function setContentType(string $type): void
{
    switch($type) {
        case CONTENT_TYPE_HTML:
            header('Content-Type: text/html');
            return;
        case CONTENT_TYPE_JSON:
            header('Content-Type: application/json');
            return;
    }
}

/**
 * Processes a generate number request.
 * 
 * @param int $boundStart A starting bound of output number.
 * @param int $boundEnd   An ending bound of output number.
 * 
 * @return void
 */
function generateNumber(int $boundStart, int $boundEnd): void
{
    $id = API\generate($boundStart, $boundEnd);
    $response = [
        'status' => true,
        'id' => $id,
    ];

    respondWith($response, code: 201);
}


/** 
 * Processes a get number request.
 * 
 * @param string|null $id An id by which to retrieve number.
 * 
 * @return void
 */
function getNumber(string|null $id): void
{
    if ($number = API\get($id)) {
        $response = [
            'status' => true,
            'number' => $number,
        ];

        respondWith($response);
    } else {
        notFound();
    }
}

/**
 * Processes `Not Found` cause.
 * 
 * @return void
 */
function notFound(): void
{
    $response = [
        'status' => false,
        'message' => 'Page Not Found!',
    ];

    respondWith($response, code: 404);
}

?>