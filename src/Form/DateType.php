<?php
/**
 * Created by PhpStorm.
 * User: cirykpopeye
 * Date: 2019-12-19
 * Time: 14:54
 */

namespace App\Form;

use Sulu\Bundle\FormBundle\Entity\FormField;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType as DateTypeBase;
use Sulu\Bundle\FormBundle\Dynamic\Types\DateType as DateTypeSulu;

class DateType extends DateTypeSulu implements FormFieldTypeInterface
{
    public function build(FormBuilderInterface $builder, FormField $field, $locale, $options)
    {
        $type = DateTypeBase::class;
        $translation = $field->getTranslation($locale);
        if ($translation && $translation->getOption('birthday')) {
            $type = BirthdayType::class;
        }
        $options['widget'] = 'single_text';
        $options['input'] = 'string';
        $builder
            ->add($field->getKey(), $type, $options);
    }
}
