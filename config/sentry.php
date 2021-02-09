<?php

return array(
    'dsn' => 'https://1c39ff6af199421d9026fbcd9ece7601:a05a17a6943c4d53b44af542eb03d9d1@sentry.io/248495',

    // capture release as git sha
    // 'release' => trim(exec('git log --pretty="%h" -n1 HEAD')),
    'release' => env('APP_VERSION'),
    // Capture bindings on SQL queries
    'breadcrumbs.sql_bindings' => true,

    // Capture default user context
    'user_context' => true,
);
