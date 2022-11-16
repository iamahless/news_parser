<?php

namespace App\Message;

class PostParser
{
	/**
	 * @var string
	 */
	private string $siteUrl;

	public function __construct(string $siteUrl)
	{
		$this->siteUrl = $siteUrl;
	}

	/**
	 * @return string
	 */
	public function getSiteUrl(): string
	{
		return $this->siteUrl;
	}
}