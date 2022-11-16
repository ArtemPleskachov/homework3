<?php
namespace Pleskachov\PhpPro\Core\CLI;


use Pleskachov\PhpPro\Core\CLI\Interfaces\ICliCommand;
use Pleskachov\PhpPro\Core\ICommandHandler;

class CommandHandler implements ICommandHandler
{
    /**
     * @var ICliCommand[];
     */
    protected array $commands = [];

    protected ICliCommand $defaultCommand;

    public function handle(array $params = [], ?callable $callback = null): void
    {
        // TODO: Implement handle() method.
    }
}