<?php 

namespace SFM\PicmntBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use SFM\PicmntBundle\Entity\Category;

use Doctrine\ORM\EntityRepository;


class ImageType extends AbstractType
{

  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder
	->add('title', 'text', array('required'=>'true'))
	->add('description', 'textarea')
	->add('category', 'entity', 
	    array(
		'class'=>'SFMPicmntBundle:Category',
		));
  }

  public function getName()
  {
    return 'picmnt_image_imagetype';
  }



}