<?php
use Elementor\Controls_Manager;

class My_Elementor_Widget extends \Elementor\Widget_Base
{
    public function get_name() {
		return 'complex-gallery';
	}

	public function get_title() {
		return esc_html__( 'Product complex gallery', 'elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'basic' ];
	}


	protected function register_controls() {

		// Content Tab Start

		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Title', 'elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_type',
			[
				'label' => esc_html__( 'Type', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'simple',
				'options' => [
					'simple' => esc_html__( 'Simple', 'textdomain' ),
					'medium' => esc_html__( 'Medium', 'textdomain' ),
					'complex' => esc_html__( 'Complex', 'textdomain' ),
				],
			]
		);

		$this->end_controls_section();

		// Content Tab End


		// Style Tab Start

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Text Color', 'elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hello-world' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Style Tab End

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$args = array(
			'post_type'      => 'product-complexity', // Replace 'products' with your custom post type name or use 'post' for regular posts
			'post_status'    => 'publish',  // Retrieve only published posts
			'posts_per_page' => 3,         // Number of posts to display per page
			'order'   => 'ASC',
			'orderby' => 'date', 
			'meta_query'     => array(
				array(
					'key'     => 'project_type',  // Replace with the actual ACF meta field name
					'value'   => $settings['post_type'],  // Add the specific value you want to filter by (if applicable)
					'compare' => '==' // Use a comparison operator to filter posts based on ACF meta value. For example, '!=', '=', '>', '<', etc.
				)
			), 
		);
		
		$query = new WP_Query($args);
		

		if ($query->have_posts()) {
			?>
			<div class="complext-grid">
				<?php
				while ($query->have_posts()) {
					$query->the_post();
					?>
					<div class="complex-gallery-item">
						<a href="#complex-modal-<?php echo esc_attr(get_the_ID()) ?>" class="complex-popup-link">
							<div class="gallery-images">
								<?php 
								if (has_post_thumbnail()) {
									// 'thumbnail' is the size of the thumbnail, but you can use other sizes like 'medium', 'large', or custom ones.
									the_post_thumbnail('full');
								} else {
									// If no post thumbnail is set, you can display a fallback image or any other content.
									echo '<img src="https://placehold.co/600x400" alt="Fallback Image">';
								}
								?>
							</div>
							<div class="gallery-overlay">
								<div><?php esc_html_e('View More', 'elementor'); ?></div>
							</div>
						</a>

						<div id="complex-modal-<?php echo esc_attr(get_the_ID()) ?>" class="complex-popup-main mfp-hide">
							<div class="container">
								<button class="close-modal">X</button>
								<div class="modal-wrapper-ele">
									<?php 
										$init_acf_slider = get_field('project_slider', get_the_ID());
									?>

									<?php if ($init_acf_slider ) { ?>
										<div class="complex-tabs-content">	
											<?php 
												$tab_index = 0;
												foreach ( $init_acf_slider as $main_item ) {
													$active_class = ($tab_index === 0) ? 'show' : '';
													?>
													<div class="tab-pane fade <?php echo esc_attr($active_class); ?>" id="content-<?php echo esc_attr(get_the_ID()) ?>-<?php echo esc_attr($tab_index); ?>" role="tabpanel" aria-labelledby="tab-<?php echo esc_attr($tab_index); ?>">
														
														<div class="complex-wrap-top">
															<div class="left-part">
																<h2 class="project-title"><?php echo esc_html( $main_item['slider_options'][0]['project_title'] ) ?></h2>
																<p class="project-description"><?php echo esc_html( $main_item['slider_options'][0]['project_desctiption'] ) ?></p>
															</div>
															<div class="right-part">
																<div class="tab-menu">
																	<h4><?php esc_html_e('Project', 'elementor') ?></h4>
																	<?php 
																		$tab_index = 0;
																		$slide_index = 1;
																		foreach ( $init_acf_slider as $main_item ) {
																			$active_class = ($tab_index === 0) ? 'show active' : ''; ?>
																				<button data-tab="content-<?php echo esc_attr(get_the_ID()) ?>-<?php echo esc_attr($tab_index); ?>" class="<?php echo esc_attr($active_class); ?>" aria-labelledby="tab-<?php echo esc_attr($tab_index); ?>"><?php echo esc_html(($tab_index + 1 )  ) ?></button>
																			<?php
																			$tab_index++;
																		}
																		if($main_item['second_slider_image']){
																			$slide_index++;
																		}
																		if($main_item['third_slider_image']){
																			$slide_index++;
																		}
																	?>
																</div>
																<div class="right-part-wrap">
																	<div class="navigation-text"> Image <span>1/<?php echo $slide_index ?></span></div>
																	<div class="navigation-bullet">
																		<div class="active"></div>
																		<div></div>
																		<?php if($main_item['third_slider_image']){ ?><div></div><?php } ?>
																	</div>
																</div>
															</div>
														</div>

														<div class="custom-slider-main custom-owl-carousel owl-carousel">
															<div class="first-item items-slider">
																<div class="slider-wrapper">
																	<div class="coloumn">
																		<div class="flexslider large-thumb" id="slider-<?php echo esc_attr($tab_index); ?>">
																			<ul class="slides">
																				<?php 
																				$gallery_large = $main_item['slider_options'][0]['projects_gallery'];
																				
																				foreach ( $gallery_large as $items ) { 
																				?>
																					<li data-thumb="<?php echo esc_attr( $items )?>">
																						<!-- <div class="large-thumb-img"><img src="<?php echo esc_attr( $items )?>" alt=""></div> -->
                                                                                        <img src="<?php echo esc_attr( $items )?>" alt="" width="911" height="512">
																				</li>
																				<?php } ?>
																			</ul>
																		</div>
																	</div>
																	<div class="coloumn">
																		<div class="">
																			<div class="content-block">
																				<?php echo ( $main_item['slider_options'][0]['device_designs_includes_description'] ) ?>
																			</div>
																			<div class="images-block">
																				<img src="<?php echo esc_attr( $main_item['slider_options'][0]['design_process'] ) ?>" alt="">
																			</div>
																			<?php 
																				$protfolio_button = get_field('portfolio_button', get_the_ID());
																				$protfolio_link = get_field('portfolio_link', get_the_ID());
																				if($protfolio_link != ''){
																			?>
																			<div class="portfolio-button-wrap">
																				<a href="<?php echo $protfolio_link ?>" class="portfolio-button" target="_blank"><?php echo $protfolio_button ?></a>
																			</div>
																			<?php
																				}
																			?>
																		</div>
																	</div>
																</div>
															</div>

															<div class="second-item items-slider">
																<img src="<?php echo esc_attr( $main_item['second_slider_image'] ) ?>" alt="">
															</div>
															<?php if($main_item['third_slider_image']){ ?>
															<div class="second-item items-slider">
																<img src="<?php echo esc_attr( $main_item['third_slider_image'] ) ?>" alt="">
															</div>
															<?php }?>
														</div>
													</div>
													<?php
													$tab_index++;
												}
											?>					
										</div>
									<?php }?>
								</div>
							</div>
						</div>
					</div>
					<?php
				}
				?>
			</div>
			<?php
			wp_reset_postdata(); // Reset the post data
		} else {
			// No posts found
		}
		
		?>
		<?php
	}
}