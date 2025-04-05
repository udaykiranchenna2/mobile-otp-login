<?php

namespace Botble\MobileOtpLogin\Repositories\Caches;

use Botble\MobileOtpLogin\Repositories\Interfaces\MobileOtpLoginInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class MobileOtpLoginCacheDecorator extends CacheAbstractDecorator implements MobileOtpLoginInterface
{
    public function findByPhone(string $phone)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function createOrUpdate($data, array $conditions = [])
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    public function deleteByPhone(string $phone)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
} 