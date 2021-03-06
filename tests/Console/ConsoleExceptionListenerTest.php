<?php

namespace VasekPurchart\ConsoleErrorsBundle\Console;

use Psr\Log\LoggerInterface;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleExceptionListenerTest extends \PHPUnit\Framework\TestCase
{

	public function testLogError()
	{
		$commandName = 'hello:world';
		$message = 'Foobar!';
		$exception = new \Exception($message);

		$logger = $this->createMock(LoggerInterface::class);
		$logger
			->expects($this->once())
			->method('error')
			->with($this->logicalAnd(
				$this->stringContains($commandName),
				$this->stringContains($message)
			), $this->contains($exception, true));

		$command = new Command($commandName);
		$input = $this->createMock(InputInterface::class);
		$output = $this->createMock(OutputInterface::class);
		$event = new ConsoleExceptionEvent($command, $input, $output, $exception, 1);

		$listener = new ConsoleExceptionListener($logger);
		$listener->onConsoleException($event);
	}

}
