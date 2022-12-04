<?php
namespace Pleskachov\PhpPro\Core\CLI\Interfaces;

use Pleskachov\PhpPro\Core\CLI\Exceptions\CliCommandException;

interface ICliCommand
{
    /**
     * @return string
     */
    public static function getComandName(): string;

    /**
     * @return string
     */
    public static function getCommandDesc(): string;

    /**
     * @param array $params
     * @return void
     * @throws CliCommandExeption
     */
    public function run(array $params = []):void;
}