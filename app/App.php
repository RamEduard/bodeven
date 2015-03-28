<?php

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Description of App
 *
 * @author Ramón Serrano <ramon.calle.88@gmail.com>
 */
class App
{

    /**
     * Default Array Options
     * 
     * @var array
     */
    static $defaultOptions = array(
        'debug' => false
    );
    
    /**
     * Silex Application
     * 
     * @var Application
     */
    private $application;
    
    /**
     * Array Options
     * 
     * @var array
     */
    private $options;
    
    public function __construct(array $options = array())
    {
        $this->setApplication(new Application())
             ->setOptions($options)
             ->registerProviders()
             ->registerRoutes();
    }
    
    /**
     * Get Application Dir
     * 
     * @return string Application Dir
     */
    public function getAppDir()
    {
        $r = new \ReflectionObject($this);
        return str_replace('\\', '/', dirname($r->getFileName()));
    }

    /**
     * Get Silex Application
     * 
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Get Application Option
     * 
     * @param string $key
     * @return mixed|null
     */
    public function getOption($key)
    {
        return (array_key_exists($key, $this->options)) ? $this->options[$key] : null;
    }
    
    /**
     * Get Application Options
     * 
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
    
    /**
     * Get Provider 
     * 
     * @param string $key
     * @return ServiceProviderInterface
     */
    public function getProvider($key)
    {
        return $this->application[$key];
    }
    
    /**
     * Register the Provider
     * 
     * @param ServiceProviderInterface $provider
     * @param array $optionsValues
     * @return \App
     */
    protected function registerProvider(ServiceProviderInterface $provider, array $optionsValues = array())
    {
        $this->application->register($provider, $optionsValues);
        
        return $this;
    }
    
    /**
     * Register the providers
     * 
     * @throws \InvalidArgumentException
     * @return \App
     */
    protected function registerProviders()
    {
        if (file_exists($providersFile = $this->getAppDir() . '/config/providers.php')) {
            $providers = require_once $providersFile;
            
            foreach ($providers as $name => $provider) {
                if (!is_array($provider)) {
                    throw new \InvalidArgumentException('Provider must be Array.');
                } else if (count($provider) == 2 && (is_object($provider[0]) && is_array($provider[1]))) {
                    if ('doctrine_dev' == $name && $this->options['debug']) {
                        $this->registerProvider($provider[0], $provider[1]);
                    } else if ('doctrine_prod' == $name && !$this->options['debug']) {
                        $this->registerProvider($provider[0], $provider[1]);
                    } else {
                        $this->registerProvider($provider[0], $provider[1]);
                    }
                } else if (count($provider) && is_object($provider[0])) {
                    $this->registerProvider($provider[0]);
                }
            }
        }
        
        return $this;
    }
    
    /**
     * Register the routes
     * 
     * @return \App
     */
    protected function registerRoutes()
    {
        # Local var required
        $app = $this->application;
        
        if (file_exists($routesFolder = $this->getAppDir() . '/config/routes')) {
            $fsi = new \FilesystemIterator($routesFolder);
            
            while ($fsi->valid()) {
                if ($fsi->isDir()) {
                    $ffsi = new \FilesystemIterator($routesFolder . '/' . $fsi->getFilename());
                    while ($ffsi->valid()) {
                        if (preg_match('/[a-zA-Z0-9_]+\.php/i', $ffsi->getFilename())) {
                            require_once $routesFolder . '/' . $fsi->getFilename() . '/' . $ffsi->getFilename();
                        }
                        $ffsi->next();
                    }
                } else {
                    if (preg_match('/[a-zA-Z0-9_]+\.php/i', $ffsi->getFilename())) {
                        require_once $routesFolder . '/' . $ffsi->getFilename();
                    }
                }
                $fsi->next();
            }
        }
        
        return $this;
    }

    /**
     * Silex Application Run
     */
    public function run()
    {
        $this->application->run();
    }
    
    public function setApplication(Application $application)
    {
        $this->application = $application;
        
        return $this;
    }

    /**
     * Set Options
     * 
     * @param array $options
     * @return \App
     */
    public function setOptions(array $options)
    {
        foreach ($options as $name => $option) {
            $this->application[$name] = $option;
        }
        
        $this->options = array_merge($options, self::$defaultOptions);
        
        return $this;
    }
    
}
