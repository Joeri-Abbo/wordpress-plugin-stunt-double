<?php


namespace StuntDouble\Fields;

class GoogleMap extends Base
{
	public const FIELD = 'google_map';

	/**
	 * Get value for field
	 * @return array
	 */
	public function getValue(): array
	{
		return $this->getLocation();
	}

	/**
	 * Get a location
	 * @return array|null
	 */
	public function getLocation(): ?array
	{
		return $this->getFormattedData($this->faker->address());
	}

	/**
	 * Get formatted data.
	 * @param string $address
	 *
	 * @return array|null
	 */
	public function getFormattedData(string $address): ?array
	{
		$prepAddr = str_replace(' ', '+', $address);
		$url      = 'https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false&key=' . GOOGLE_MAPS_API_KEY;
		$url      = str_replace('\n', '', $url);
		$geocode  = file_get_contents($url);
		$output   = json_decode($geocode);

		if (empty($output->results)){
			return null;
		}
		$latitude  = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng;

		return [
			'lat'     => $latitude,
			'lng'     => $longitude,
			'address' => $address,
			"zoom"    => 10
		];
	}
}
