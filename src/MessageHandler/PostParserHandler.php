<?php

namespace App\MessageHandler;

use App\Entity\Post;
use App\Message\PostParser;
use App\Repository\PostRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PostParserHandler implements MessageHandlerInterface
{
	/**
	 * @var EntityManagerInterface $entityManager
	 */
	private EntityManagerInterface $entityManager;

	/**
	 * @var LoggerInterface $$logger
	 */
	private LoggerInterface $logger;

	/**
	 * @var PostRepository $postRepository
	 */
	private PostRepository $postRepository;

	public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger, PostRepository $postRepository)
	{
		$this->entityManager = $entityManager;
		$this->logger = $logger;
		$this->postRepository = $postRepository;
	}

	public function __invoke(PostParser $postParser)
	{
		try {
			$rssFeed = simplexml_load_file($postParser->getSiteUrl());
			$rssFeedObject = json_encode($rssFeed);
			$rssFeedArray = json_decode($rssFeedObject, TRUE);

			foreach ($rssFeedArray['channel']['item'] as $item) {
				$post = $this->postRepository->findOneBy(['title' => $item['title']]);

				if (empty($post)) {
					$post = new Post();
					$post->setTitle($item['title'])
						->setLink($item['guid'])
						->setImageUrl($item['enclosure']['@attributes']['url'])
						->setPublishedDate(new DateTime($item['pubDate']))
						->setExcerpt($item['description'])
						->setCreatedAt(new DateTime('now'))
						->setUpdatedAt(new DateTime('now'));

					$this->entityManager->persist($post);
				}

			}

			$this->entityManager->flush();
		} catch (Exception $exception) {
			$this->logger->error($exception->getMessage());
		}
	}
}