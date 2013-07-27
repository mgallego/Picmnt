<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new MGP\MainBundle\MGPMainBundle(),
	    new MGP\ImageBundle\MGPImageBundle(),
            new MGP\CommentBundle\MGPCommentBundle(),
            new MGP\UserBundle\MGPUserBundle(),
            
            new SFM\PicmntBundle\SFMPicmntBundle(),      
	    new FOS\UserBundle\FOSUserBundle(),
        //new SFM\UserBundle\SFMUserBundle(),
	    new Knp\Bundle\MenuBundle\KnpMenuBundle(),
	    new Liip\FunctionalTestBundle\LiipFunctionalTestBundle(),
	    new Ideup\SimplePaginatorBundle\IdeupSimplePaginatorBundle(),
	    new Ornicar\GravatarBundle\OrnicarGravatarBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new SFM\DucksboardBundle\SFMDucksboardBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new RaulFraile\Bundle\LadybugBundle\RaulFraileLadybugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
