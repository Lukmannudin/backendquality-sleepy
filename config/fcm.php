<?php
return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,
    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAA9ETz_qw:APA91bEm5KA8uTHSOFVZ1G-FWx4FMUhGE2neqort0slsGm8FCJ9GuRU2SrUTLEUrHqGpPki3yqJkXsepF9cR_zvKeNvf5t_fFESleoHWMH2oy0sWvU1fl-8IPxmXTbaeLAUADbfLlmoZ'),
        'sender_id' => env('FCM_SENDER_ID', '1049128861356'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];