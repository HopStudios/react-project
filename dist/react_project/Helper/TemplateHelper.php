<?php

namespace GB\ReactProject\Helper;

use ExpressionEngine\Controller\Design\AbstractDesign as AbstractDesignController;

class TemplateHelper extends AbstractDesignController
{
    public function __construct()
    {
        // Initializing the AbstractDesignController while not in a controller context will create some issues in the __construct().
    }

    public function getCodeMirrorAssets($selector = 'template_data')
    {
        $this->loadCodeMirrorAssets($selector);
    }
}
