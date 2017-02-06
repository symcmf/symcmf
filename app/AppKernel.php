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
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new AppBundle\AppBundle(),
            //SonataProject
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'),

            //userBundle
            new Application\Sonata\UserBundle\ApplicationSonataUserBundle(),

            // CMF Symfony MessageBundle
            new MessageBundle\MessageBundle(),

            // CMF Symfony SocialAuthBundle
            new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),

            // Sonata editor
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Sonata\FormatterBundle\SonataFormatterBundle(),
            new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),

            // for Gedmo\
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),

            // CMF Symfony PageBundle
            new Sonata\PageBundle\SonataPageBundle(),
            new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle(),
            new Sonata\SeoBundle\SonataSeoBundle(),
            new Sonata\CacheBundle\SonataCacheBundle(),
            new Application\Sonata\PageBundle\ApplicationSonataPageBundle(),
            new Sonata\NotificationBundle\SonataNotificationBundle(),
            new Application\Sonata\NotificationBundle\ApplicationSonataNotificationBundle(),

        );

        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
