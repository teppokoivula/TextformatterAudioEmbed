<?php namespace ProcessWire;

/**
 * ProcessWire Audio Embedding Textformatter
 *
 * Looks for audio URLs wrapped in <p></p> tags and automatically converts them to HTML5 <audio> elements.
 *
 * @author Teppo Koivula <teppo.koivula@gmail.com>
 * @license Mozilla Public License v2.0 https://mozilla.org/MPL/2.0/
 */
class TextformatterAudioEmbed extends Textformatter {

	/**
	 * Get module info
	 *
	 * @return array
	 */
	public static function getModuleInfo() {
		return [
			'title' => 'Audio Embed Text Formatter',
			'version' => '0.1.0',
			'summary' => 'Converts audio file URLs within paragraph tags into HTML5 audio elements.',
			'author' => 'Teppo Koivula',
		];
	}

	/**
	 * Audio formats
	 *
	 * @var array
	 */
	protected $audio_formats = [
		'mp3' => 'audio/mpeg',
		'ogg' => 'audio/ogg',
		'wav' => 'audio/wav',
	];

	/**
	 * Text formatting function as used by the Textformatter interface
	 *
	 * Here we look for audio file URLs on first pass using a fast strpos() function.
	 * If found, we do our second pass with preg_match_all and replace the audio URLs
	 * with HTML5 <audio> tags.
	 *
	 * @param string $str
	 */
	public function format(&$str) {

		// bail out early if there are no audio files
		if (stripos($str, '.mp3') === false && stripos($str, '.ogg') === false && stripos($str, '.wav') === false) {
			return;
		}

		// capture audio file URLs with regex and replace found matches with <audio> elements
		if (preg_match_all('/\<p\>\s*((?:https?:\/\/.*?|\/site\/assets\/files\/.*?)\.(mp3|ogg|wav))\s*\<\/p\>/i', $str, $matches)) {
			foreach ($matches[0] as $key => $line) {
				$url = $this->wire('sanitizer')->url($matches[1][$key], [
					'allowIDN' => true,
					'allowSchemes' => ['http', 'https'],
					'requireScheme' => false,
				]);
				if ($url) {
					$tag = '<audio controls class="TextformatterAudioEmbed">'
						. '<source src="' . $url . '" type="' . $this->audio_formats[strtolower($matches[2][$key])] . '">'
						. '</audio>';
					$str = str_replace($line, $tag, $str); 
				}
			}
		}
	}

}
