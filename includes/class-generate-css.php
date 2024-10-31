<?php
/**
 * Generate CSS from Attributes
 *
 * @package UltraDevs
 */

/**
 * Generate CSS from Attributes
 */
class UDRIB_Generate_CSS {

	/**
	 * Attributes
	 *
	 * @var array
	 */
	public $attributes = array();

	/**
	 * Tablet Width
	 *
	 * @var string
	 */
	public $tablet_width = '768px';

	/**
	 * Mobile Width
	 *
	 * @var string
	 */
	public $mobile_width = '480px';

	/**
	 * Constructor
	 *
	 * @param array $attributes Attributes.
	 */
	public function __construct( $attributes ) {
		$this->attributes = $attributes;


	}

	/**
	 * Tablet CSS
	 *
	 * @param string $selector Selector.
	 * @param string $data CSS.
	 * @param arrray $properties Properties.
	 * @return string
	 */
	public function tablet_css( $selector, $data, $properties = [] ) {

		$css = '';

		if ( $data && ! empty( $data['tablet'] ) ) {
			$css .= '@media (max-width: ' . $this->tablet_width . ') { ';
			$css .= $selector . ' {';

			foreach ( $properties as $property ) {
				if ( empty( $data['tablet'][ $property ] ) ) {
					continue;
				}
				$css .= $property . ': ' . $data['tablet'][ $property ] . $data['tablet'][ $property . 'Unit' ] . ';';
			}

			$css .= '} }';

		}

		return $css;
	}

	/**
	 * Mobile CSS
	 *
	 * @param string $selector Selector.
	 * @param string $data CSS.
	 * @param arrray $properties Properties.
	 * @return string
	 */
	public function mobile_css( $selector, $data, $properties = [] ) {

		$css = '';

		if ( $data && ! empty( $data['mobile'] ) ) {
			$css .= '@media (max-width: ' . $this->mobile_width . ') { ';
			$css .= $selector . ' {';

			foreach ( $properties as $property ) {
				if ( empty( $data['mobile'][ $property ] ) ) {
					continue;
				}
				$css .= $property . ': ' . $data['mobile'][ $property ] . $data['mobile'][ $property . 'Unit' ] . ';';
			}

			$css .= '} }';

		}

		return $css;
	}

	/**
	 * Generate CSS
	 *
	 * @return string
	 */
	public function generate_css() {
		$css = '';

		// Image > img.
		$css .= '.ud-random-img-block__images img {';

		$css .= isset( $this->attributes['imageSize'] ) && ! empty( $this->attributes['imageSize']['desktop']['width'] ) ? 'width: ' . $this->attributes['imageSize']['desktop']['width'] . $this->attributes['imageSize']['desktop']['widthUnit'] . '; ' : '';
		$css .= isset( $this->attributes['imageSize'] ) && ! empty( $this->attributes['imageSize']['desktop']['height'] ) ? 'height: ' . $this->attributes['imageSize']['desktop']['height'] . $this->attributes['imageSize']['desktop']['heightUnit'] . '; ' : '';
		$css .= ! empty( $this->attributes['imageObjectFit'] ) ? 'object-fit: ' . $this->attributes['imageObjectFit'] . '; ' : '';

		$css .= '}';

		// Image.
		if ( ! empty( $this->attributes['imageAlign'] ) ) {
			$image_align = $this->attributes['imageAlign'];

			$css .= '.ud-random-img-block__images {';
			$css .= isset( $image_align ) ? 'text-align: ' . $image_align . '; ' : '';
			$css .= '}';
		}

		if ( ! empty( $this->attributes['imageSize'] ) ) {
			$css .= $this->tablet_css(
				'.ud-random-img-block__images img',
				$this->attributes['imageSize'],
				[
					'width',
					'height',
				]
			);

			$css .= $this->mobile_css(
				'.ud-random-img-block__images img',
				$this->attributes['imageSize'],
				[
					'width',
					'height',
				]
			);
		}

		return $css;
	}

	/**
	 * Generate Container CSS
	 *
	 * @return string
	 */
	public function css_output() {
		$css = $this->generate_css();

		if ( ! empty( $css ) ) {
			$css = '<style>' . $css . '</style>';
			return $css;
		}
	}
}

