<?php


namespace App\Repository;


use App\Entity\Setting;
use Doctrine\ORM\EntityRepository;

class SettingRepository extends EntityRepository
{
    public function create(string $locale): Setting
    {
        $setting = new Setting();
        $setting->setLocale($locale);
        return $setting;
    }

    public function findById(int $id, string $locale): ?Setting
    {
        $setting = $this->find($id);
        if (!$setting) {
            return null;
        }

        $setting->setLocale($locale);

        return $setting;
    }
}
