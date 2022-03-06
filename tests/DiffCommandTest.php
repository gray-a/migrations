<?php
declare(strict_types=1);

namespace LaravelDoctrine\Migrations\Tests;

use Illuminate\Config\Repository;
use Illuminate\Console\OutputStyle;
use LaravelDoctrine\Migrations\Console\DiffCommand;
use Mockery;
use Symfony\Component\Console\Output\NullOutput;

class DiffCommandTest extends CommandTestCase
{

    public function testLoadFilterFromConfig()
    {
        $this->configurationFactoryMock
            ->shouldReceive("getConfigAsRepository")
            ->once()
            ->andReturn(
                new Repository([
                    'schema' => [
                        'filter' => 'filter'
                    ]
                ])
            );

        $this->inputMock->shouldReceive("getOption")->with("filter-expression")->once()->andReturn(null);
        $this->inputMock->shouldReceive("getOption")->with("connection")->twice()->andReturn(null);
        $this->inputMock->shouldReceive("setOption")->with("filter-expression", "filter")->once();

        $diffCommand = Mockery::mock(DiffCommand::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
        $diffCommand
            ->shouldReceive("runDoctrineCommand")
            ->once()
            ->with(
                \Doctrine\Migrations\Tools\Console\Command\DiffCommand::class,
                $this->dependencyFactoryMock
            )
            ->andReturn(0);

        $diffCommand->setInput($this->inputMock);
        $diffCommand->setOutput(new OutputStyle($this->inputMock, new NullOutput()));
        $diffCommand->handle($this->dependencyFactoryProviderMock, $this->configurationFactoryMock);
    }

    public function testNoFilterInConfig()
    {
        $this->configurationFactoryMock
            ->shouldReceive("getConfigAsRepository")
            ->once()
            ->andReturn(
                new Repository([
                    'schema' => [
                    ]
                ])
            );

        $this->inputMock->shouldReceive("getOption")->with("filter-expression")->once()->andReturn(null);
        $this->inputMock->shouldReceive("getOption")->with("connection")->twice()->andReturn(null);
        $this->inputMock->shouldReceive("setOption")->with("filter-expression", null)->once();

        $diffCommand = Mockery::mock(DiffCommand::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
        $diffCommand
            ->shouldReceive("runDoctrineCommand")
            ->once()
            ->with(
                \Doctrine\Migrations\Tools\Console\Command\DiffCommand::class,
                $this->dependencyFactoryMock
            )
            ->andReturn(0);

        $diffCommand->setInput($this->inputMock);
        $diffCommand->setOutput(new OutputStyle($this->inputMock, new NullOutput()));
        $diffCommand->handle($this->dependencyFactoryProviderMock, $this->configurationFactoryMock);
    }
}