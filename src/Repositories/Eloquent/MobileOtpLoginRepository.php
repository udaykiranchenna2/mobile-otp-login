<?php

namespace Botble\MobileOtpLogin\Repositories\Eloquent;

use Botble\MobileOtpLogin\Models\MobileOtpLogin;
use Botble\MobileOtpLogin\Repositories\Interfaces\MobileOtpLoginInterface;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;

class MobileOtpLoginRepository extends RepositoriesAbstract implements MobileOtpLoginInterface
{
    public function findByPhone(string $phone)
    {
        return $this->model->where('phone', $phone)->first();
    }

    public function createOrUpdate($data, array $conditions = [])
    {
        if (isset($conditions['phone'])) {
            $item = $this->findByPhone($conditions['phone']);
            if ($item) {
                $item->fill($data);
                $item->save();
                return $item;
            }
        }

        return $this->create($data);
    }

    public function deleteByPhone(string $phone)
    {
        return $this->model->where('phone', $phone)->delete();
    }
} 