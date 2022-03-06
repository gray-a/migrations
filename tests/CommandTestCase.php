<?php
declare(strict_types=1);

namespace LaravelDoctrine\Migrations\Tests;

use Doctrine\Migrations\DependencyFactory;
use LaravelDoctrine\Migrations\Configuration\ConfigurationFactory;
use LaravelDoctrine\Migrations\Configuration\DependencyFactoryProvider;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\Input;

class CommandTestCase extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected $dependencyFactoryMock;
    protected $dependencyFactoryProviderMock;
    protected $configurationFactoryMock;
    protected $inputMock;

    protected function setUp(): void
    {
        $this->dependencyFactoryMock = Mockery::mock(DependencyFactory::class);
        $this->dependencyFactoryProviderMock = Mockery::mock(DependencyFactoryProvider::class);
        $this->dependencyFactoryProviderMock
            ->shouldReceive("fromConnectionName")
            ->once()
            ->andReturn($this->dependencyFactoryMock);

        $this->configurationFactoryMock = Mockery::mock(ConfigurationFactory::class);

        $this->inputMock = Mockery::mock(Input::class);
    }
}