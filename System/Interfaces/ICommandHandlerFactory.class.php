<?php
namespace System\Interfaces;

/**
 * ICommandHandlerFactory 接口
 *
 * @codeCoverageIgnore
 *
 * @author chloroplast
 * @version 1.0: 20160828
 */
interface ICommandHandlerFactory
{
    /**
     * 返回 CommandHandler
     */
    public function getHandler(string $commandName) : ICommandHandler ;
}
