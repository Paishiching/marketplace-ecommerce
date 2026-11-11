<?php

return [
    // Google reCAPTCHA v2 ("I'm not a robot" checkbox)
    //
    // Live site : .env te nijer key din (https://www.google.com/recaptcha/admin)
    //     RECAPTCHA_SITE_KEY=...
    //     RECAPTCHA_SECRET_KEY=...
    //
    // Local (APP_ENV=local) e key na dile Google er public TEST key use hoy,
    // jate captcha box ta shathe shathe dekha jay (ei test key shobshomoy pass kore).
    'site_key'   => env('RECAPTCHA_SITE_KEY', env('APP_ENV') === 'local'
        ? '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI' : null),

    'secret_key' => env('RECAPTCHA_SECRET_KEY', env('APP_ENV') === 'local'
        ? '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe' : null),
];