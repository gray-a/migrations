<?php

namespace LaravelDoctrine\Migrations;

use Symfony\Component\Console\Command\Command;

class CommandUtils
{
    public static function argumentExists(Command $command, string $argName): bool
    {
        foreach ($command->getDefinition()->getArguments() as $arg) {
            if ($arg->getName() === $argName) {
                return true;
            }
        }
        return false;
    }

    public static function optionExists(Command $command, string $optionName): bool
    {
        foreach ($command->getDefinition()->getOptions() as $option) {
            if ($option->getName() === $optionName) {
                return true;
            }
        }
        return false;
    }
}