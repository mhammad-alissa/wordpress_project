<?php
/**
 * Class: Jet_Woo_Builder_Single_Excerpt
 * Name: Single Excerpt
 * Slug: jet-single-excerpt
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_Single_Excerpt extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-single-excerpt';
	}

	public function get_title() {
		return esc_html__( 'Single Excerpt', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-excerpt';
	}

	public function get_script_depends() {
		return array();
	}

	public function get_jet_help_url() {
		return 'https://crocoblock.com/knowledge-base/articles/jetwoobuilder-how-to-create-and-set-a-single-product-page-template/';
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	public function show_in_panel() {
		return jet_woo_builder()->documents->is_document_type( 'single' );
	}

	protected function _register_controls() {

		$css_scheme = apply_filters(
			'jet-woo-builder/jet-single-excerpt/css-scheme',
			array(
				'excerpt' => '.jet-woo-builder .woocommerce-product-details__short-description',
			)
		);

		$this->start_controls_section(
			'section_single_excerpt_style',
			array(
				'label'      => esc_html__( 'General', 'jet-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'single_excerpt_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['excerpt'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'single_excerpt_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['excerpt'],
			)
		);

		$this->add_responsive_control(
			'single_excerpt_align',
			array(
				'label'     => esc_html__( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => jet_woo_builder_tools()->get_available_h_align_types( true ),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['excerpt'] => 'text-align: {{VALUE}};',
				),
				'classes'   => 'elementor-control-align',
			)
		);

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';

		global $product;

		if ( ! is_a( $product, 'WC_Product' ) ) {
			return;
		}

		if ( true === $this->__set_editor_product() ) {
			$this->__open_wrap();
			include $this->__get_global_template( 'index' );
			$this->__close_wrap();
			if ( jet_woo_builder_integration()->in_elementor() ) {
				$this->__reset_editor_product();
			}
		}

	}

}
