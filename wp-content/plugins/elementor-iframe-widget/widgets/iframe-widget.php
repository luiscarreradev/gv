<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Evita el acceso directo.
}

class Elementor_Iframe_Widget extends \Elementor\Widget_Base {

	// Nombre único del widget.
	public function get_name() {
		return 'iframe_widget';
	}

	// Título que se mostrará en el panel de Elementor.
	public function get_title() {
		return __( 'Iframe Responsive Avanzado', 'elementor-iframe-widget' );
	}

	// Ícono que representará al widget.
	public function get_icon() {
		return 'eicon-code';
	}

	// Categorías en las que se agrupará el widget.
	public function get_categories() {
		return [ 'basic' ];
	}

	// Registrar los controles del widget.
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Contenido', 'elementor-iframe-widget' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Control para el texto que se usará como URL del iframe.
		// Se define como TEXT para aceptar valores de campos ACF (u otros) y etiquetas dinámicas.
		$this->add_control(
			'iframe_url',
			[
				'label'       => __( 'Texto del Iframe', 'elementor-iframe-widget' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => __( 'Ingrese la URL o valor del campo', 'elementor-iframe-widget' ),
				'default'     => '',
			]
		);

		// Control responsivo para el ancho.
		$this->add_responsive_control(
			'iframe_width',
			[
				'label'      => __( 'Ancho', 'elementor-iframe-widget' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1920,
					],
					'%'  => [
						'min' => 10,
						'max' => 100,
					],
					'vw' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 600,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .iframe-container iframe' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Control responsivo para el alto.
		$this->add_responsive_control(
			'iframe_height',
			[
				'label'      => __( 'Alto', 'elementor-iframe-widget' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'size_units' => [ 'px', '%', 'vh' ],
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1080,
					],
					'%'  => [
						'min' => 10,
						'max' => 100,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 400,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .iframe-container iframe' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Sección de Atributos Avanzados.
		$this->start_controls_section(
			'advanced_attributes_section',
			[
				'label' => __( 'Atributos Avanzados', 'elementor-iframe-widget' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Switch para activar allowfullscreen.
		$this->add_control(
			'enable_allowfullscreen',
			[
				'label'        => __( 'Activar Allowfullscreen', 'elementor-iframe-widget' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Sí', 'elementor-iframe-widget' ),
				'label_off'    => __( 'No', 'elementor-iframe-widget' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		// Switch y control para el atributo "allow".
		$this->add_control(
			'enable_allow',
			[
				'label'        => __( 'Activar atributo allow', 'elementor-iframe-widget' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Sí', 'elementor-iframe-widget' ),
				'label_off'    => __( 'No', 'elementor-iframe-widget' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		$this->add_control(
			'allow_value',
			[
				'label'       => __( 'Valor de allow', 'elementor-iframe-widget' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture',
				'condition'   => [
					'enable_allow' => 'yes',
				],
			]
		);

		// Switch y control para el atributo "sandbox".
		$this->add_control(
			'enable_sandbox',
			[
				'label'        => __( 'Activar atributo sandbox', 'elementor-iframe-widget' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Sí', 'elementor-iframe-widget' ),
				'label_off'    => __( 'No', 'elementor-iframe-widget' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		$this->add_control(
			'sandbox_value',
			[
				'label'       => __( 'Valor de sandbox', 'elementor-iframe-widget' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Ejemplo: allow-scripts allow-same-origin', 'elementor-iframe-widget' ),
				'default'     => '',
				'condition'   => [
					'enable_sandbox' => 'yes',
				],
			]
		);

		// Switch y control para el atributo "referrerpolicy".
		$this->add_control(
			'enable_referrerpolicy',
			[
				'label'        => __( 'Activar atributo referrerpolicy', 'elementor-iframe-widget' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Sí', 'elementor-iframe-widget' ),
				'label_off'    => __( 'No', 'elementor-iframe-widget' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		$this->add_control(
			'referrerpolicy_value',
			[
				'label'     => __( 'Valor de referrerpolicy', 'elementor-iframe-widget' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'no-referrer-when-downgrade',
				'options'   => [
					'no-referrer'              => __( 'no-referrer', 'elementor-iframe-widget' ),
					'no-referrer-when-downgrade' => __( 'no-referrer-when-downgrade', 'elementor-iframe-widget' ),
					'origin'                   => __( 'origin', 'elementor-iframe-widget' ),
					'origin-when-cross-origin' => __( 'origin-when-cross-origin', 'elementor-iframe-widget' ),
					'unsafe-url'               => __( 'unsafe-url', 'elementor-iframe-widget' ),
				],
				'condition' => [
					'enable_referrerpolicy' => 'yes',
				],
			]
		);

		// Switch y control para el atributo "loading".
		$this->add_control(
			'enable_loading',
			[
				'label'        => __( 'Activar atributo loading', 'elementor-iframe-widget' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Sí', 'elementor-iframe-widget' ),
				'label_off'    => __( 'No', 'elementor-iframe-widget' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		$this->add_control(
			'loading_value',
			[
				'label'     => __( 'Valor de loading', 'elementor-iframe-widget' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'lazy',
				'options'   => [
					'auto'  => __( 'auto', 'elementor-iframe-widget' ),
					'lazy'  => __( 'lazy', 'elementor-iframe-widget' ),
					'eager' => __( 'eager', 'elementor-iframe-widget' ),
				],
				'condition' => [
					'enable_loading' => 'yes',
				],
			]
		);

		// Switch y control para el atributo "scrolling".
		$this->add_control(
			'enable_scrolling',
			[
				'label'        => __( 'Activar atributo scrolling', 'elementor-iframe-widget' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Sí', 'elementor-iframe-widget' ),
				'label_off'    => __( 'No', 'elementor-iframe-widget' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		$this->add_control(
			'scrolling_value',
			[
				'label'     => __( 'Valor de scrolling', 'elementor-iframe-widget' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'auto',
				'options'   => [
					'auto' => __( 'auto', 'elementor-iframe-widget' ),
					'yes'  => __( 'yes', 'elementor-iframe-widget' ),
					'no'   => __( 'no', 'elementor-iframe-widget' ),
				],
				'condition' => [
					'enable_scrolling' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	// Renderizar el widget.
	protected function render() {
		$settings   = $this->get_settings_for_display();
		$iframe_url = ! empty( $settings['iframe_url'] ) ? $settings['iframe_url'] : '';

		if ( empty( $iframe_url ) ) {
			return;
		}

		// Construir los atributos adicionales según las opciones activadas.
		$attributes = '';

		if ( ! empty( $settings['enable_allowfullscreen'] ) && 'yes' === $settings['enable_allowfullscreen'] ) {
			$attributes .= ' allowfullscreen';
		}

		if ( ! empty( $settings['enable_allow'] ) && 'yes' === $settings['enable_allow'] ) {
			$allow = ! empty( $settings['allow_value'] ) ? esc_attr( $settings['allow_value'] ) : '';
			$attributes .= ' allow="' . $allow . '"';
		}

		if ( ! empty( $settings['enable_sandbox'] ) && 'yes' === $settings['enable_sandbox'] ) {
			$sandbox = ! empty( $settings['sandbox_value'] ) ? esc_attr( $settings['sandbox_value'] ) : '';
			$attributes .= ' sandbox="' . $sandbox . '"';
		}

		if ( ! empty( $settings['enable_referrerpolicy'] ) && 'yes' === $settings['enable_referrerpolicy'] ) {
			$refpolicy = ! empty( $settings['referrerpolicy_value'] ) ? esc_attr( $settings['referrerpolicy_value'] ) : '';
			$attributes .= ' referrerpolicy="' . $refpolicy . '"';
		}

		if ( ! empty( $settings['enable_loading'] ) && 'yes' === $settings['enable_loading'] ) {
			$loading = ! empty( $settings['loading_value'] ) ? esc_attr( $settings['loading_value'] ) : '';
			$attributes .= ' loading="' . $loading . '"';
		}

		if ( ! empty( $settings['enable_scrolling'] ) && 'yes' === $settings['enable_scrolling'] ) {
			$scrolling = ! empty( $settings['scrolling_value'] ) ? esc_attr( $settings['scrolling_value'] ) : '';
			$attributes .= ' scrolling="' . $scrolling . '"';
		}
		?>
		<div class="iframe-container">
			<iframe src="<?php echo esc_url( $iframe_url ); ?>" frameborder="0" <?php echo $attributes; ?>></iframe>
		</div>
		<?php
	}
}
