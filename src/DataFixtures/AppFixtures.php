<?php

namespace App\DataFixtures;

use App\Entity\Setting;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $settings = [
            'site_title' => [
                'label' => 'Site titel',
                'value' => 'Mijn website'
            ],
            'google_api_key' => [
                'label' => 'Google API key',
                'value' => 'Enter Google API key'
            ]
        ];

        foreach($settings as $key => $setting) {
            $settingObject = new Setting();
            $settingObject->setKey($key);
            $settingObject->setLabel($setting['label']);
            $settingObject->setLocale('nl');
            $settingObject->setValue($setting['value']);
            $manager->persist($settingObject);
        }
        $manager->flush();
    }
}
