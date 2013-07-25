<?php 

namespace SFM\PicmntBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageFileFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dataFile', 'file');
    }

    /**
     * setDefaultOptions
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'      => 'SFM\PicmntBundle\Form\Model\ImageFileModel',
                'csrf_protection' => false,
            )
        );
    }

    public function getName()
    {
        return 'picmnt_image_imageuptype';
    }
}
