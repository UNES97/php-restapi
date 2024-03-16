<?php

function endpointNotFound()
{
    return [
        "statusCode" => 404,
        "message" => "Endpoint not found",
    ];
}
