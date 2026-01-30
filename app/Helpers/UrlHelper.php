<?php

namespace App\Helpers;

use Illuminate\Support\Facades\URL;

class UrlHelper
{
   public static function baseFileUrl(): string
{
    $host = request()->getHost();

    if ($host === 'lnxstgweb.tn.gov.in') {
        return url('/') ;   // staging - already includes /tnelb_web/
    }

    return url('/');   // local
}

}
