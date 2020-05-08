<?php


namespace App\Form\ListBuilder;

use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\ListBuilder\DynamicListFactory as SuluDynamicListFactory;
use Sulu\Component\Rest\ListBuilder\FieldDescriptor;
use Sulu\Component\Rest\ListBuilder\FieldDescriptorInterface;

class DynamicListFactory extends SuluDynamicListFactory
{
    public function getFieldDescriptors(Form $form, string $locale): array
    {
        $fieldDescriptors = parent::getFieldDescriptors($form, $locale);
        $fieldDescriptors['page'] = new FieldDescriptor(
            'page',
            'sulu_page.page',
            FieldDescriptorInterface::VISIBILITY_YES,
            FieldDescriptorInterface::SEARCHABILITY_NEVER,
            'string'
        );
        return $fieldDescriptors;
    }
}
