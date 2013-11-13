<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.11.13
 * Time: 11:13
 */


namespace Templates\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Exception;

class ViewFilesPath extends AbstractHelper implements ServiceLocatorAwareInterface
{

    /**
     * Путь до файлов для видов.
     *
     * @var string
     */
    protected $path;

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;


    /**
     * Returns site's base path, or file with base path prepended.
     *
     * $file is appended to the base path for simplicity.
     *
     * @param  string|null $file
     * @throws Exception\RuntimeException
     * @return string
     */
    public function __invoke($file = null)
    {
        if (null !== $file) {
            $file = '/' . ltrim($file, '/');
        }

        return $this->getPath() . $file;
    }



    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    protected function getPath()
    {
        if (null === $this->path)
        {
            $config = $this->getServiceLocator()->getServiceLocator()->get('config');

            if (isset($config['template_config']['space']['files']))
            {
                $this->path = '/view/' . $config['template_config']['space']['files'];
            }

        }

        return $this->path;
    }

    /**
     * Set the service locator.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return CustomHelper
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * Get the service locator.
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

} 