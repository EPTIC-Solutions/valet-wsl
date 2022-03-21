<?php

use Illuminate\Container\Container;
use PHPUnit\Framework\TestCase;
use Valet\CommandLine;
use Valet\Contracts\PackageManager;
use Valet\Contracts\ServiceManager;
use Valet\DnsMasq;
use Valet\Filesystem;

class DnsMasqTest extends TestCase
{
    public function setUp()
    {
        $_SERVER['SUDO_USER'] = user();
        Container::setInstance(new Container());
    }

    public function tearDown()
    {
        exec('rm -rf '.__DIR__.'/output');
        mkdir(__DIR__.'/output');
        touch(__DIR__.'/output/.gitkeep');

        Mockery::close();
    }

    public function test_createCustomConfigFile_correctly_creates_valet_dns_config_file()
    {
        $pm = Mockery::mock(PackageManager::class);
        $sm = Mockery::mock(ServiceManager::class);

        swap(PackageManager::class, $pm);
        swap(ServiceManager::class, $sm);

        $dnsMasq = resolve(DnsMasq::class);
        $dnsMasq->configPath = __DIR__.'/output/valet';

        $dnsMasq->createCustomConfigFile('test');

        $this->assertSame('address=/.test/127.0.0.1'.PHP_EOL, file_get_contents(__DIR__.'/output/valet'));
    }

    public function test_update_domain_removes_old_resolver_and_reinstalls()
    {
        $pm = Mockery::mock(PackageManager::class);
        $sm = Mockery::mock(ServiceManager::class);
        $cli = Mockery::mock(Filesystem::class);
        $files = Mockery::mock(CommandLine::class);

        $dnsMasq = Mockery::mock(DnsMasq::class.'[createCustomConfigFile,fixResolved]', [$pm, $sm, $cli, $files]);

        $dnsMasq->shouldReceive('createCustomConfigFile')->once()->with('new');
        $sm->shouldReceive('restart')->once()->with('dnsmasq');
        $dnsMasq->updateDomain('old', 'new');
    }
}

class StubForFiles extends Filesystem
{
    public function ensureDirExists($path, $owner = null, $mode = 0755)
    {
    }
}
