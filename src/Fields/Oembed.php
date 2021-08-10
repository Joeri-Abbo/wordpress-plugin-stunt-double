<?php


namespace StuntDouble\Fields;


class Oembed extends Base
{
	public const FIELD = 'oembed';

	/**
	 * Get value for field
	 * @return string|null
	 */
	public function getValue(): ?string
	{
		return $this->getRandomYoutubeLink();
	}

	/**
	 * Get random youtube link
	 * @return string|null
	 */
	public function getRandomYoutubeLink(): ?string
	{
		$url  = 'https://joeri-abbo.github.io/random-youtube-video/videos.json';
		$data = file_get_contents($url);

		if (empty($data)) {
			return null;
		}

		$videos     = json_decode($data, true);
		$random_key = array_rand($videos, 1);

		return $videos[$random_key]['url'];
	}
}
