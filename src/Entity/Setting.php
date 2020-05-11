<?php


namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SettingRepository")
 * @ORM\Table(name="setting")
 */
class Setting
{
    const RESOURCE_KEY = 'settings';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string $locale
     */
    private $locale;

    /**
     * @ORM\Column(type="string", name="setting_key", unique=true)
     */
    private $key;

    /**
     * @ORM\Column(type="string")
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SettingTranslation", mappedBy="setting", cascade={"all"})
     */
    private $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
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

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getTranslations(): ArrayCollection
    {
        return $this->translations;
    }

    public function getTranslation(string $locale, bool $create = false, bool $fallback = false): ?SettingTranslation
    {
        foreach ($this->translations as $translation) {
            if ($translation->getLocale() == $locale) {
                return $translation;
            }
        }

        if ($create) {
            $translation = new SettingTranslation();
            $translation->setLocale($locale);

            return $translation;
        }

        if ($fallback) {
            return $this->getTranslation('nl');
        }

        return null;
    }

    /**
     * @Serializer\VirtualProperty(name="value")
     */
    public function getValue(): ?string
    {
        return $this->getTranslation($this->locale, false, true)->getValue();
    }

    public function setValue(?string $value): Setting
    {
        $translation = $this->getTranslation($this->locale);
        if (!$translation) {
            $translation = $this->createTranslation($this->locale);
        }

        $translation->setValue($value);

        return $this;
    }

    protected function createTranslation(string $locale): SettingTranslation
    {
        $translation = new SettingTranslation($this, $locale);
        $this->translations->set($locale, $translation);

        return $translation;
    }
}
