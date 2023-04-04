<?php declare(strict_types=1);

namespace FakeVendor\HelloWorld\Module;

use BEAR\AppMeta\AppMeta;
use BEAR\Package\PackageModule;
use Ray\Di\AbstractModule;

class AppModule extends AbstractModule
{
    public static $modules = [];
    /**
     * {@inheritdoc}
     */
    protected function configure() : void
    {
        self::$modules[] = get_class($this);
        $this->install(new PackageModule);
    }
}
