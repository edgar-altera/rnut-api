<?php

return [
    'allowed_ips' => array_filter(explode(',', env('API_ALLOWED_IPS'))),
];
