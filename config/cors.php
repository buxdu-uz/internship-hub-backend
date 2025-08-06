<?php

return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'], // <-- GET ham POST ham ishlaydi
    'allowed_origins' => ['*'], // vaqtincha barcha domenlar uchun
    'allowed_headers' => ['*'],
    'supports_credentials' => true,
];

