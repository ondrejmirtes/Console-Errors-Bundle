<?php

namespace VasekPurchart\ConsoleErrorsBundle\Console;

use Psr\Log\LoggerInterface;

use Symfony\Component\Console\Event\ConsoleExceptionEvent;

class ConsoleExceptionListener
{

	/** @var \Psr\Log\LoggerInterface */
	private $logger;

	public function __construct(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}

	public function onConsoleException(ConsoleExceptionEvent $event)
	{
		$command = $event->getCommand();
		$exception = $event->getException();

		$message = sprintf(
			'%s: %s (uncaught exception) at %s line %s while running console command `%s`',
			get_class($exception),
			$exception->getMessage(),
			$exception->getFile(),
			$exception->getLine(),
			$command->getName()
		);

		$this->logger->error($message, [
			'exception' => $exception,
		]);
	}

}
