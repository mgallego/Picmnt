<?php 

namespace MGP\ImageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array('required' => 'true'))
            ->add('description', 'textarea', array('required' => false))
            ->add(
                'category',
                'entity',
                array(
                    'class' => 'MGPImageBundle:Category',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('c');
                    },
                    'property' => 'name',
                )
            )
            ->add('notify_email', 'checkbox', array("required" => false));
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
                'data_class'      => 'MGP\ImageBundle\Entity\Image',
                'csrf_protection' => false,
            )
        );
    }
    
    public function getName()
    {
        return 'picmnt_image_imagetype';
    }
}
