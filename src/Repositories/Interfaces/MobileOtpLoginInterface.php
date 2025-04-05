<?php

namespace Botble\MobileOtpLogin\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface MobileOtpLoginInterface extends RepositoryInterface
{
    public function findByPhone(string $phone);

    public function createOrUpdate(array $data, array $conditions = []);

    public function deleteByPhone(string $phone);
}
