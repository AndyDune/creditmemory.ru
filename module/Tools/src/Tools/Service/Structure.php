<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19.11.13
 * Time: 14:39
 */

namespace Tools\Service;


class Structure
{
    protected $root = '';
    protected $path = '';

    protected $subDomain = 'www';

    protected $configFile = '/config.php';

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

    public function run()
    {

    }

    protected function _buildStructureData()
    {
        $path = $this->path;
        $root = $this->root;
        $fileToLook = $this->configFile;
        $result = [];
        $currentExistKey = '/';


        $root .= $this->subDomain;

        $value = $root . $fileToLook;
        if (is_file($value))
        {
            $result['/'] = include($value);
        }
        $parts = explode('/', $path);
        $accumulatorPath = '';

        $pathPartsInStructure = [];
        $pathPartsOutStructure = [];

        foreach($parts as $value)
        {
            $value = trim($value);
            if (!$value)
                continue;
            $accumulatorPath .= '/' . $value;
            $file = $root . $accumulatorPath . $fileToLook;
            if (is_file($file))
            {
                $pathPartsInStructure[$accumulatorPath] = $value;
                $currentExistKey = $accumulatorPath;
                $result[$accumulatorPath] = include($file);
            }
            else
            {

                break;
            }

        }
    }

} 