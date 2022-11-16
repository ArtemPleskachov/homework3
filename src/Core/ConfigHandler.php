<?php

namespace Pleskachov\PhpPro\Core;

use Pleskachov\PhpPro\Core\Traits\SingletonTrait;
use Pleskachov\PhpPro\Core\Exceptions\ParameterNotFoundException;
use Pleskachov\PhpPro\Core\Interfaces\IConfigHandler;
use Pleskachov\PhpPro\Core\Interfaces\ISingleton;



class ConfigHandler implements IConfigHandler, ISingleton
{
    use SingletonTrait;


    /**
     * @var array Parameters from file
     */
    protected array $parameters = [];

    /**
     * @description Parameters array loading method
     * @param array $configs
     * @return $this
     */
    public function addConfigs(array $configs): self
    {
        $this->parameters = array_merge($this->parameters, $configs);
        return $this;
    }

    public function has(string $id): bool
    {
        try {
            $result = true;
            $this->getRealPath($id);
        } catch (ParameterNotFoundException $e) {
            $result = false;
        }
        return $result;
    }

    /**
     * @param string $id
     * @return mixed|void
     */

    public function get(string $id): mixed
    {
        return $this->getRealPath($id);
    }

    public function __get($name)
    {
        return $this->get(str_replace('_', '.', $name));
    }

    protected function getRealPath(string $id): mixed
    {
        $tokens = explode('.', $id);
        $context = $this->parameters;

        while (null !== ($token = array_shift($tokens))) {
            if (!isset($context[$token])) {
                throw new ParameterNotFoundException('Parameter not found: ' . $id);
            }

            $context = $context[$token];
        }
        return $context;
    }
}