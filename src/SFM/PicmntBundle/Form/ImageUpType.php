<?php 

namespace SFM\PicmntBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ImageUpType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
	->add('dataFile', 'file');
  }

  public function getName()
  {
    return 'picmnt_image_imageuptype';
  }



}