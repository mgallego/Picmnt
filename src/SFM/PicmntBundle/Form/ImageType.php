<?php 

namespace SFM\PicmntBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use SFM\PicmntBundle\Entity\Category;

use Doctrine\ORM\EntityRepository;


class ImageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
	->add('title', 'text', array('required'=>'true'))
	->add('description', 'textarea', array('required'=>false))
       
        ->add('category', 'entity', 
	    array(
		'class'=>'SFMPicmntBundle:Category',
		'query_builder' => function(EntityRepository $er) {
		  return $er->createQueryBuilder('c');
		  
		},
		'property'=>'name',
		  ))
      ->add('notify_email', 'checkbox', array("required"=>false));
  }

  public function getName()
  {
    return 'picmnt_image_imagetype';
  }



}