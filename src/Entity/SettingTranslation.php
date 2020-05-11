<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="setting_translation")
 */
class SettingTranslation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $locale;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Setting", inversedBy="translations")
     * @ORM\JoinColumn(name="setting_id", onDelete="cascade", referencedColumnName="id")
     */
    private $setting;

    /**
     * @ORM\Column(type="string")
     */
    private $value;

    public function __construct(Setting $setting, string $locale)
    {
        $this->setting = $setting;
        $this->locale = $locale;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    public function getSetting(): Setting
    {
        return $this->setting;
    }

    public function setSetting(Setting $setting): void
    {
        $this->setting = $setting;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
