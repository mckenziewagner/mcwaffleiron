<?php
call_user_func(function($dotEnvFile) {
    if (!getenv('APP_ENV') && file_exists($dotEnvFile)) {
        (new \Symfony\Component\Dotenv\Dotenv())->load($dotEnvFile);
    }
}, dirname(dirname(__DIR__)).'/.env');
