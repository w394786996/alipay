<?php

namespace Yi210\Alipay\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Yi210\Alipay
 */
class Alipay extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor() { return 'Alipay'; }

}
