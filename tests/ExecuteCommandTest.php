<?php
declare(strict_types=1);

namespace LaravelDoctrine\Migrations\Tests;

use Illuminate\Config\Repository;
use Illuminate\Console\OutputStyle;
use LaravelDoctrine\Migrations\Console\ExecuteCommand;
use Mockery;
use Symfony\Component\Console\Output\NullOutput;

class ExecuteCommandTest extends CommandTestCase
{

    public function testCallCommand()
    {
        $this->inputMock
            ->shouldReceive("getOption")
            ->with("connection")
            ->once()
            ->andReturn(null);

        $diffCommand = Mockery::mock(ExecuteCommand::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
        $diffCommand
            ->shouldReceive("runDoctrineCommand")
            ->once()
            ->with(
                \Doctrine\Migrations\Tools\Console\Command\ExecuteCommand::class,
                $this->dependencyFactoryMock
            )
            ->andReturn(0);

        $diffCommand->setInput($this->inputMock);
        $diffCommand->setOutput(new OutputStyle($this->inputMock, new NullOutput()));
        $diffCommand->handle($this->dependencyFactoryProviderMock, $this->configurationFactoryMock);
    }
}