<?php

function gravatar_url($email)
{

    $query = http_build_query([
        's' => 60,
    ]);

    $email = md5($email);
    return "https://www.gravatar.com/avatar/$email" . $query;
}