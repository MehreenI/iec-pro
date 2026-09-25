<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class IEC_Tunisian_Landing_Page {

	private int $post_id = 0;

		private array $fields = [];

	public static function for_queried_page(): self {
		$page = new self();
		$page->boot( (int) get_queried_object_id() );

		return $page;
	}

	private function boot( int $post_id ): void {
		$this->post_id = max( 0, $post_id );
		$this->fields  = $this->load_fields();
		$this->register_lcp_preload();
	}

		private function load_fields(): array {
		if ( $this->post_id < 1 || ! function_exists( 'get_fields' ) ) {
			return [];
		}

		$fields = get_fields( $this->post_id );

		return is_array( $fields ) ? $fields : [];
	}

		public function field( $key, $default = null ) {
		return $this->fields[ $key ] ?? $default;
	}

	public function image_url( $value, string $fallback = '' ): string {
		$url = iec_resolve_media_to_url( $value );

		return $url !== '' ? $url : $fallback;
	}

	public function render( string $wrapper = 'main' ): void {
		$wrapper = in_array( $wrapper, array( 'main', 'div' ), true ) ? $wrapper : 'div';
		$id_attr = ( 'main' === $wrapper ) ? ' id="main"' : '';

		echo '<' . $wrapper . ' class="iec-tab-landing"' . $id_attr . '>';

		$this->render_partial( 'hero' );
		$this->render_partial( 'tabs' );

		echo '</' . $wrapper . '>';
	}

	private function render_partial( string $slug ): void {
		$path = get_template_directory() . '/template-parts/tab-landing/' . $slug . '.php';

		if ( ! is_readable( $path ) ) {
			return;
		}

		$iec_tab_landing = $this;
		include $path;
	}

	private function register_lcp_preload(): void {
		$hero   = $this->field( 'hero', [] );
		$slider = is_array( $hero['slider'] ?? null ) ? $hero['slider'] : [];
		$urls   = [];

		foreach ( array_slice( $slider, 0, 2 ) as $banner ) {
			if ( ! is_array( $banner ) ) {
				continue;
			}

			$desktop = $this->image_url( $banner['banner'] ?? null );
			$mobile  = $this->image_url( $banner['mobile_image'] ?? null, $desktop );

			if ( $desktop !== '' ) {
				$urls[] = $desktop;
			}

			if ( $mobile !== '' && $mobile !== $desktop ) {
				$urls[] = $mobile;
			}
		}

		if ( $urls === [] ) {
			return;
		}

		add_action(
			'wp_head',
			static function () use ( $urls ) {
				foreach ( array_values( $urls ) as $i => $url ) {
					$priority = ( 0 === $i ) ? ' fetchpriority="high"' : '';
					printf(
						'<link rel="preload" as="image" href="%s"%s />' . "\n",
						esc_url( $url ),
						$priority
					);
				}
			},
			2
		);
	}
}

// Office CPT Tunisian path loads assets/css/pages/tunisian-landing-page.css via IEC_Asset_Loader.
