<?php

declare(strict_types=1);

namespace Mos\Config;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the configuration file bootstrap.php.
 */
class ConfigRouterTest extends TestCase
{
    private $configFile = INSTALL_PATH . "/config/router.php";
    
    /**
     * Require the config file.
     */
    public function testRequireRouterFile()
    {   
        $exp = 1;
        $res = require $this->configFile;
        $this->assertEquals($exp, $res);
    }
}
