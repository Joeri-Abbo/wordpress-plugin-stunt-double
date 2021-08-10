<?php


namespace StuntDouble\Fields;


class Image extends Base
{
	public const FIELD = 'image';

	/**
	 * Get value for field
	 * @return mixed
	 */
	public function getValue()
	{
		$min_width  = ! empty($this->field['min_width']) ? $this->field['min_width'] : null;
		$min_height = ! empty($this->field['min_height']) ? $this->field['min_height'] : null;

		return $this->getImage($min_width, $min_height);
	}

	/**
	 * Get random image
	 * @param int|null $min_width
	 * @param int|null $min_height
	 *
	 * @return mixed
	 */
	public function getImage(int $min_width = null, int $min_height = null)
	{
		if ($min_width && $min_height) {
			$width  = $min_width * 2;
			$height = $min_height * 2;
		} else {
			$width  = 1000 * 2;
			$height = 1000 * 2;
		}

		file_put_contents(STUNTDOUBLE_PATH . 'tmp/image.jpg',
			file_get_contents(sprintf('https://source.unsplash.com/random/%sx%s', $width, $height)));

		$image = STUNTDOUBLE_URI . 'tmp/image.jpg';

		return $this->addImage($image);
	}

	/**
	 * Add image of url
	 * @param string $image_url
	 *
	 * @return mixed
	 */
	public function addImage(string $image_url)
	{
		$image            = pathinfo($image_url);//Extracting information into array.
		$image_name       = $image['basename'];
		$upload_dir       = wp_upload_dir();
		$image_data       = file_get_contents($image_url);
		$unique_file_name = wp_unique_filename($upload_dir['path'], $image_name);
		$filename         = basename($unique_file_name);

		if ($image != '') {
			// Check folder permission and define file location
			if (wp_mkdir_p($upload_dir['path'])) {
				$file = $upload_dir['path'] . '/' . $filename;
			} else {
				$file = $upload_dir['basedir'] . '/' . $filename;
			}
			// Create the image  file on the server
			file_put_contents($file, $image_data);
			// Check image file type
			$wp_filetype = wp_check_filetype($filename, null);
			// Set attachment data
			$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_title'     => sanitize_file_name($filename),
				'post_content'   => '',
				'post_status'    => 'inherit',
			);
			// Create the attachment
			$attach_id = wp_insert_attachment($attachment, $file);
			// Include image.php
			require_once ABSPATH . 'wp-admin/includes/image.php';
			// Define attachment metadata
			$attach_data = wp_generate_attachment_metadata($attach_id, $file);
			// Assign metadata to attachment
			wp_update_attachment_metadata($attach_id, $attach_data);

			unlink(STUNTDOUBLE_PATH . 'tmp/image.jpg');

			return $attach_id;
		}

	}
}
