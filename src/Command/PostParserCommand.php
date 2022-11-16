<?php

namespace App\Command;

use App\Message\PostParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class PostParserCommand extends Command
{
	protected static $defaultName = 'app:post-parser';
	protected static $defaultDescription = 'Get articles from https://www.spiegel.de/politik';
	private MessageBusInterface $bus;

	public function __construct(MessageBusInterface $bus, string $name = null)
	{
		parent::__construct($name);

		$this->bus = $bus;
	}

	protected function configure(): void
	{
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$io = new SymfonyStyle($input, $output);
		$io->info('Scraping: Starting');

		$this->bus->dispatch(new PostParser('https://www.spiegel.de/politik/index.rss'));

		$io->success('Scraping: Success');

		return Command::SUCCESS;
	}
}
