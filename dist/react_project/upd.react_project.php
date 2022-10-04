<?php

use ExpressionEngine\Service\Addon\Installer;

class React_project_upd extends Installer
{

    public function __construct()
    {
        parent::__construct();
    }

    public $has_cp_backend = 'y';
    public $has_publish_fields = 'n';
}