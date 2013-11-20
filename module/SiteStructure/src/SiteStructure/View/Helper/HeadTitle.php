<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19.11.13
 * Time: 18:49
 */

namespace SiteStructure\View\Helper;
use Zend\View\Helper\HeadTitle as ZendHeadTitle;
use SiteStructure\Service\Structure;

class HeadTitle extends ZendHeadTitle
{
    /**
     * @var Structure
     */
    protected $structure;

    public function __construct(Structure $structure)
    {
        $this->structure = $structure;
        if ($title = $this->structure->getStructureSiteConfig('title'))
        {
            $this->prepend($title);
        }

        if ($data = $this->structure->getStructureDomainConfig())
        {
            foreach ($data as $run)
            {
                if (array_key_exists('title', $run) and $run['title'])
                    $this->prepend($run['title']);
            }
        }

    }
}