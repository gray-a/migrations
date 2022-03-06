<?php
declare(strict_types=1);

namespace LaravelDoctrine\Migrations\Console;

use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command\DoctrineCommand;
use Illuminate\Console\Command;
use LaravelDoctrine\Migrations\CommandUtils;
use Symfony\Component\Console\Input\ArrayInput;

abstract class BaseCommand extends Command
{

    protected function runDoctrineCommand(string $class, DependencyFactory $dependencyFactory): int
    {
        /** @var DoctrineCommand $command */
        $command = new $class($dependencyFactory);
        return $command->run($this->getDoctrineInput($command), $this->output->getOutput());
    }

    /**
     * @param DoctrineCommand $command
     * @return void
     */
    protected function getDoctrineInput(DoctrineCommand $command): ArrayInput
    {
        $definition = $this->getDefinition();
        var_dump($definition);
        $input = new ArrayInput([]);


        foreach ($definition->getArguments() as $argument) {
            $argName = $argument->getName();

            if ($argName === 'command' || !CommandUtils::argumentExists($command, $argName)) {
                continue;
            }

            if ($this->hasArgument($argName)) {
                $input->setArgument($argName, $this->input->getArgument($argName));
            }
        }

        foreach ($definition->getOptions() as $option) {
            $optionName = $option->getName();

            if ($optionName === 'connection' || !CommandUtils::optionExists($command, $optionName)) {
                continue;
            }

            if ($this->input->hasOption($optionName)) {
                $input->setOption($optionName, $this->input->getOption($optionName));
            }
        }

        $input->setInteractive(!($this->input->getOption("no-interaction") ?? false));
        return $input;
    }
}