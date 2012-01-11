<?php 

namespace SFM\PicmntBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use SFM\PicmntBundle\Entity\Category;

class ImageType extends AbstractType
{

  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder
      ->add('title')
      ->add('description')
      ->add('category')
      ->add('tags');
  }

  public function getName()
  {
    return 'picmnt_image_imagetype';
  }



}