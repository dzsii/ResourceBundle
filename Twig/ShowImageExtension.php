<?php

namespace ThinkBig\Bundle\ResourceBundle\Twig;

class ShowImageExtension extends \Twig_Extension
{

    public function __construct($router) {

        $this->router = $router;

    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('showImage', array($this, 'showImage')),
        );
    }

    public function showImage($resource, $options)
    {

        if (!isset($options['size'])) {

            $options['size'] = 120;

        }

        if ($resource) {

            $path = $resource->getPath();

        }
        else {

            $path = 'default-placeholder.png';

        }
        
        

        return $this->router->generate('show_image', ['size' => $options['size'], 'path' => $path]);
    }

    public function getName()
    {
        return 'thinkbig_resource_extension';
    }
}