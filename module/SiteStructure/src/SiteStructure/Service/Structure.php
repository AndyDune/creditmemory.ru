<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19.11.13
 * Time: 14:39
 */

namespace SiteStructure\Service;

class Structure
{
    protected $root = '';
    protected $path = '';

    protected $subDomain = 'www';

    protected $configFile = '/config.php';

    /**
     * Конфигурационный массив для всего сайта.
     *
     * @var null|array
     */
    protected $configForSite = null;

    /**
     * Вложенный массив с конфигами для структуры, отраженной в ссылке.
     * Актуален в раках текущего домена.
     * @var null|array
     */
    protected $configForSubDomain = null;


    /**
     * @param $path
     * @return $this
     */
    public function setRoot($path)
    {
        $this->root = $path;
        return $this;
    }

    /**
     * @param $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function getStructureSiteConfig($key = null)
    {
        if (!$this->configForSite)
            return null;
        if (array_key_exists($key, $this->configForSite))
            return $this->configForSite[$key];
        else
            return null;
        return $this->configForSite;
    }

    public function getStructureDomainConfig()
    {
        return $this->configForSubDomain;
    }

    public function run()
    {
        $this->_buildStructureData();
        return $this;
    }

    protected function _buildStructureData()
    {
        $path = $this->path;
        $root = $this->root;
        $fileToLook = $this->configFile;
        $result = [];
        $currentExistKey = '';

        $value = $root . $fileToLook;
        if (is_file($value))
        {
            $this->configForSite = include($value);
        }


        $root .=  '/' . $this->subDomain;

        $value = $root . $fileToLook;
        if (is_file($value))
        {
            $currentExistKey = '/';
            $result['/'] = include($value);
            $result['/']['dir'] = $root;
        }
        $parts = explode('/', $path);
        $accumulatorPath = '';

        $pathPartsInStructure = [];
        $pathPartsOutStructure = [];

        $break = false;
        foreach($parts as $value)
        {
            $value = trim($value);
            if (!$value)
                continue;
            $accumulatorPath .= '/' . $value;
            if ($break)
            {
                $pathPartsOutStructure[$accumulatorPath] = $value;
                continue;
            }
            $path = $root . $accumulatorPath;
            if (is_dir($path))
            {
                $pathPartsInStructure[$accumulatorPath] = $value;
                $currentExistKey = $accumulatorPath;
                $file = $path . $fileToLook;
                if (is_file($file))
                {
                    $result[$accumulatorPath] = include($file);
                    $result[$accumulatorPath]['dir'] = $root . $accumulatorPath;
                }
                else
                    $result[$accumulatorPath] = null;
            }
            else
            {
                $break = true;
            }

        }

        if (count($result))
            $this->configForSubDomain = $result;

        //if (count($pathPartsInStructure))
        //    echo 1;
    }


} 