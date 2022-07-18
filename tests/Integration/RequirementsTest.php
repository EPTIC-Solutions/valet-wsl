<?php

namespace Valet\Tests\Integration;

use Illuminate\Container\Container;
use Mockery;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Valet\CommandLine;
use Valet\Requirements;

class RequirementsTest extends TestCase
{
    public function setUp(): void
    {
        $_SERVER['SUDO_USER'] = user();

        Container::setInstance(new Container());
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function test_home_path_is_inside_root()
    {
        $this->expectNotToPerformAssertions();
        // TODO: Move VALET_HOME_PATH to something changeable
    }

    public function test_home_path_is_not_inside_root()
    {
        $this->expectNotToPerformAssertions();
        // TODO: Move VALET_HOME_PATH to something changeable
    }

    public function test_selinux_is_enabled()
    {
        $this->expectException(RuntimeException::class);

        $cli = Mockery::mock(CommandLine::class);
        $cli->shouldReceive('run')->once()->with('sestatus')->andReturn('SELinux status:                 enabled
SELinuxfs mount:                /sys/fs/selinux
SELinux root directory:         /etc/selinux
Loaded policy name:             targeted
Current mode:                   enforcing
Mode from config file:          enforcing
Policy MLS status:              enabled
Policy deny_unknown status:     allowed
Max kernel policy version:      30
');
        swap(CommandLine::class, $cli);

        $requirements = resolve(Requirements::class);
        $requirements->seLinuxIsEnabled();
    }

    public function test_selinux_is_in_permissive_mode()
    {
        $this->expectNotToPerformAssertions();
        $cli = Mockery::mock(CommandLine::class);
        $cli->shouldReceive('run')->once()->with('sestatus')->andReturn('SELinux status:                 enabled
SELinuxfs mount:                /sys/fs/selinux
SELinux root directory:         /etc/selinux
Loaded policy name:             targeted
Current mode:                   permissive
Mode from config file:          permissive
Policy MLS status:              enabled
Policy deny_unknown status:     allowed
Max kernel policy version:      30
');
        swap(CommandLine::class, $cli);

        $requirements = resolve(Requirements::class);
        $requirements->seLinuxIsEnabled();
    }

    public function test_selinux_is_disabled()
    {
        $this->expectNotToPerformAssertions();
        $cli = Mockery::mock(CommandLine::class);
        $cli->shouldReceive('run')->once()->with('sestatus')->andReturn('SELinux status:                 disabled' . PHP_EOL);
        swap(CommandLine::class, $cli);

        $requirements = resolve(Requirements::class);
        $requirements->seLinuxIsEnabled();
    }

    public function test_selinux_is_enabled_but_ignore_flag_is_set()
    {
        $this->expectNotToPerformAssertions();
        $cli = Mockery::mock(CommandLine::class);
        $cli->shouldNotReceive('run');
        swap(CommandLine::class, $cli);

        $requirements = resolve(Requirements::class);
        $requirements->setIgnoreSELinux(true);
        $requirements->seLinuxIsEnabled();
    }
}
