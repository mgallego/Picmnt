<?php 

namespace SFM\PicmntBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ImageUpType extends AbstractType
{

  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder
	->add('dataFile', 'file');
  }

  public function getName()
  {
    return 'picmnt_image_imageuptype';
  }



}