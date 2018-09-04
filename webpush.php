<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;

class WebPushPlugin extends Plugin
{
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0],
        ];
    }
    public function onPluginsInitialized()
    {

    }
    public function onTwigTemplatePaths()
    {
        
    }

    public function onTwigSiteVariables()
    {
       
    }
}
