<?php
/**
 * Britt Theme Customizer.
 *
 * @package Britt
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function britt_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

    //Categories dropdown
    class Britt_Category_Dropdown extends WP_Customize_Control {
        private $cats = false;
        public function __construct($manager, $id, $args = array(), $options = array())
        {
            $this->cats = get_categories($options);
            parent::__construct( $manager, $id, $args );
        }
        public function render_content() {
            if(!empty($this->cats)) {
                    ?>
                        <label>
                          <span><?php echo esc_html( $this->label ); ?></span>
                          <select <?php $this->link(); ?>>
                               <?php
                                    foreach ( $this->cats as $cat )
                                    {
                                        printf('<option value="%s" %s>%s</option>', $cat->term_id, selected($this->value(), $cat->term_id, false), $cat->name);
                                    }
                               ?>
                          </select>
                        </label>
                    <?php
            }
        }
    }

    //Titles
    class Britt_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
            <h3><?php echo esc_html( $this->label ); ?></h3>
            <hr>
        <?php
        }
    }


    //Hide banner
    $wp_customize->add_setting(
        'remove_title_decs',
        array(
            'sanitize_callback' => 'britt_sanitize_checkbox',
            'default' => 0,
        )
    );
    $wp_customize->add_control(
        'remove_title_decs',
        array(
            'type' => 'checkbox',
            'label' => __('Remove site title decorations?', 'britt'),
            'section' => 'title_tagline',
            'priority' => 17,
        )
    );

    //___Featured categories___//
    $wp_customize->add_section(
        'britt_featured_cats',
        array(
            'title' => __('Featured categories', 'britt'),
            'priority' => 13,
        )
    );    
    $wp_customize->add_setting(
        'featured_cats_label',
        array(
            'sanitize_callback' => 'britt_sanitize_text',
            'default'           => __('Hot topics', 'britt')
        )
    );
    $wp_customize->add_control(
        'featured_cats_label',
        array(
            'label'         => __( 'Featured categories title', 'britt' ),
            'section'       => 'britt_featured_cats',
            'type'          => 'text',
            'priority'      => 9
        )
    );      

    for( $i= 1 ; $i <= 3 ; $i++ ) {
        $wp_customize->add_setting(
            'featured_cat_' . $i, array(
                'default' => get_option( 'default_category', '' ),
                'sanitize_callback' => 'britt_sanitize_int',
            )
        );
        $wp_customize->add_control(
            new Britt_Category_Dropdown(
                $wp_customize, 'featured_cat_' . $i, array(
                    'label' => __( 'Featured category ', 'britt' ) . $i,
                    'section' => 'britt_featured_cats',
                )
            )
        );
    }
    $wp_customize->add_setting(
          'hide_featured_cats',
          array(
            'sanitize_callback' => 'britt_sanitize_checkbox',
            'default' => 0,
          )
    );
    $wp_customize->add_control(
          'hide_featured_cats',
          array(
            'type' => 'checkbox',
            'label' => __('Hide the featured categories section?', 'britt'),
            'section' => 'britt_featured_cats',
            'priority' => 13,
          )
    );

    //___Carousel___//
    $wp_customize->add_section(
        'britt_carousel',
        array(
            'title' => __('Carousel', 'britt'),
            'priority' => 12,
        )
    );
    //Title
    $wp_customize->add_setting(
        'carousel_title',
        array(
            'sanitize_callback' => 'britt_sanitize_text',
            'default'           => __('Latest news', 'britt')
        )
    );
    $wp_customize->add_control(
        'carousel_title',
        array(
            'label'         => __( 'Carousel title', 'britt' ),
            'section'       => 'britt_carousel',
            'type'          => 'text',
            'priority'      => 10
        )
    );    
    //Post IDs
    $wp_customize->add_setting(
        'carousel_posts',
        array(
            'sanitize_callback' => 'britt_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'carousel_posts',
        array(
            'label'         => __( 'Posts IDs', 'britt' ),
            'description'   => __( 'Add a comma separated list of post IDs to display in the carousel (e.g. 344,345,932) - See how to find post IDs ', 'britt' ) . '<a href="http://theme.blue/blog/find-post-ids/" target="_blank">' . __('here', 'britt') . '</a>',
            'section'       => 'britt_carousel',
            'type'          => 'text',
            'priority'      => 11
        )
    );
    //Hide singles
    $wp_customize->add_setting(
          'hide_carousel_singles',
          array(
            'sanitize_callback' => 'britt_sanitize_checkbox',
            'default' => 1,
          )
    );
    $wp_customize->add_control(
          'hide_carousel_singles',
          array(
            'type' => 'checkbox',
            'label' => __('Hide the carousel on single posts?', 'britt'),
            'section' => 'britt_carousel',
            'priority' => 12,
          )
    );


    //___Blog___//
    $wp_customize->add_section(
        'britt_blog',
        array(
            'title' => __('Blog', 'britt'),
            'priority' => 15,
        )
    );

    $wp_customize->add_setting(
        'sticky_widgets',
        array(
            'default'           => 'on',
            'sanitize_callback' => 'britt_sanitize_sticky_widgets',
        )
    );
    $wp_customize->add_control(
        'sticky_widgets',
        array(
            'type'          => 'radio',
            'label'         => __('Sticky widgets', 'britt'),
            'section'       => 'britt_blog',
            'priority'      => 8,
            'choices'       => array(
                'on'    => __( 'On', 'britt' ),
                'off'   => __( 'Off', 'britt' ),
            ),
        )
    );

    $wp_customize->add_setting('britt_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Britt_Info( $wp_customize, 'single_posts', array(
        'label' => __('Single posts', 'britt'),
        'section' => 'britt_blog',
        'settings' => 'britt_options[info]',
        'priority' => 10
        ) )
    );   

    //Featured images
    $wp_customize->add_setting(
        'single_featured_image',
        array(
            'default'           => 'in-post',
            'sanitize_callback' => 'britt_sanitize_single_images',
        )
    );
    $wp_customize->add_control(
        'single_featured_image',
        array(
            'type'        => 'radio',
            'label'       => __('Featured images', 'britt'),
            'section'     => 'britt_blog',
            'description' => __('Featured image display for single posts', 'britt'),
            'choices' => array(
                'in-post'     => __('In post', 'britt'),
                'above-post'  => __('Above post (recommended only if you have large featured images)', 'britt'),
                'none'     	  => __('None', 'britt'),
            ),
            'priority' => 11
        )
    );

    $wp_customize->add_setting('britt_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Britt_Info( $wp_customize, 'archive_posts', array(
        'label' => __('Index and archives posts', 'britt'),
        'section' => 'britt_blog',
        'settings' => 'britt_options[info]',
        'priority' => 12
        ) )
    );

    //Ribbon
    $wp_customize->add_setting(
        'loop_text',
        array(
            'sanitize_callback' => 'britt_sanitize_text',
            'default'           => __( '<p>LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT.</p><a class="button" target="_blank" href="http://example.org">LEARN MORE</a>', 'britt' )
        )
    );
    $wp_customize->add_control(
        'loop_text',
        array(
            'label'         => __( 'Call to action area', 'britt' ),
            'description'   => __('This is the ribbon that displays on your homepage after the first two posts. HTML is supported. Leave empty to disable.', 'britt'),
            'section'       => 'britt_blog',
            'type'          => 'textarea',
            'priority'      => 13
        )
    );        
    $wp_customize->add_setting(
        'exc_length',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '20'
        )
    );
    $wp_customize->add_control(
        'exc_length',
        array(
            'label'         => __( 'Excerpt length', 'britt' ),
            'section'       => 'britt_blog',
            'type'          => 'text',
            'priority'      => 14
        )
    ); 
    //___Colors___//
    $wp_customize->add_setting(
        'primary_color',
        array(
            'default'           => '#D2AE90',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'primary_color',
            array(
                'label'         => __('Primary color', 'britt'),
                'section'       => 'colors',
                'priority'      => 12
            )
        )
    );
    $wp_customize->add_setting(
        'menu_bg',
        array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'menu_bg',
            array(
                'label'         => __('Menu background', 'britt'),
                'section'       => 'colors',
                'priority'      => 13
            )
        )
    );
    $wp_customize->add_setting(
        'menu_items',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'menu_items',
            array(
                'label'         => __('Menu items', 'britt'),
                'section'       => 'colors',
                'priority'      => 14
            )
        )
    );
    $wp_customize->add_setting(
        'header_bg',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'header_bg',
            array(
                'label'         => __('Header background', 'britt'),
                'section'       => 'colors',
                'priority'      => 14
            )
        )
    );    
    $wp_customize->add_setting(
        'site_title',
        array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'site_title',
            array(
                'label'         => __('Site title', 'britt'),
                'section'       => 'colors',
                'priority'      => 15
            )
        )
    );
    $wp_customize->add_setting(
        'site_description',
        array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'site_description',
            array(
                'label'         => __('Site description', 'britt'),
                'section'       => 'colors',
                'priority'      => 16
            )
        )
    );   
    $wp_customize->add_setting(
        'title_panels',
        array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'title_panels',
            array(
                'label' => __('Title panels', 'britt'),
                'section' => 'colors',
                'priority' => 17
            )
        )
    );
    $wp_customize->add_setting(
        'body_text_color',
        array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'body_text_color',
            array(
                'label' => __('Body text', 'britt'),
                'section' => 'colors',
                'priority' => 18
            )
        )
    );
    $wp_customize->add_setting(
        'footer_bg',
        array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_bg',
            array(
                'label' => __('Footer background', 'britt'),
                'section' => 'colors',
                'priority' => 19
            )
        )
    );

    //___Fonts___//
    $wp_customize->add_section(
        'britt_fonts',
        array(
            'title' => __('Fonts', 'britt'),
            'priority' => 15,
            'description'  => __('For help selecting fonts see the <a href="http://theme.blue/documentation/britt" target="_blank">documentation</a>. The font list is here: google.com/fonts', 'britt'),
        )
    );

    //Body fonts
    $wp_customize->add_setting(
        'body_fonts',
        array(
            'default'       => '//fonts.googleapis.com/css?family=Merriweather:300,300italic,700,700italic',            
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        'body_fonts',
        array(
            'label' => __( 'Body font', 'britt' ),
            'section' => 'britt_fonts',
            'type' => 'text',
            'priority' => 11
        )
    );

    //Body fonts family
    $wp_customize->add_setting(
        'body_font_family',
        array(
            'sanitize_callback' => 'britt_sanitize_text',
            'default' => 'font-family: \'Merriweather\', serif;',
        )
    );
    $wp_customize->add_control(
        'body_font_family',
        array(
            'label' => __( 'Body font family', 'britt' ),
            'section' => 'britt_fonts',
            'type' => 'text',
            'priority' => 12
        )
    );   
    //Headings fonts
    $wp_customize->add_setting(
        'headings_fonts',
        array(
            'default'       => '//fonts.googleapis.com/css?family=Playfair+Display:400,400italic,700,700italic',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        'headings_fonts',
        array(
            'label' => __( 'Headings font', 'britt' ),
            'section' => 'britt_fonts',
            'type' => 'text',
            'priority' => 14
        )
    );
    //Headings fonts family
    $wp_customize->add_setting(
        'headings_font_family',
        array(
            'sanitize_callback' => 'britt_sanitize_text',            
            'default' => 'font-family: \'Playfair Display\', serif;',
        )
    );
    $wp_customize->add_control(
        'headings_font_family',
        array(
            'label' => __( 'Headings font family', 'britt' ),
            'section' => 'britt_fonts',
            'type' => 'text',
            'priority' => 15
        )
    );

    // Site title
    $wp_customize->add_setting(
        'site_title_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '78',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'site_title_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'britt_fonts',
        'label'       => __('Site title', 'britt'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 80,
            'step'  => 1,
        ),
    ) ); 
    // Site description
    $wp_customize->add_setting(
        'site_desc_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '16',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'site_desc_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'britt_fonts',
        'label'       => __('Site description', 'britt'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 50,
            'step'  => 1,
        ),
    ) );         
    //H1 size
    $wp_customize->add_setting(
        'h1_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '36',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'h1_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'britt_fonts',
        'label'       => __('H1 font size', 'britt'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //H2 size
    $wp_customize->add_setting(
        'h2_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '30',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'h2_size', array(
        'type'        => 'number',
        'priority'    => 18,
        'section'     => 'britt_fonts',
        'label'       => __('H2 font size', 'britt'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );

    //H3 size
    $wp_customize->add_setting(
        'h3_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '24',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'h3_size', array(
        'type'        => 'number',
        'priority'    => 19,
        'section'     => 'britt_fonts',
        'label'       => __('H3 font size', 'britt'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //H4 size
    $wp_customize->add_setting(
        'h4_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '18',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'h4_size', array(
        'type'        => 'number',
        'priority'    => 20,
        'section'     => 'britt_fonts',
        'label'       => __('H4 font size', 'britt'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //H5 size
    $wp_customize->add_setting(
        'h5_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '14',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'h5_size', array(
        'type'        => 'number',
        'priority'    => 21,
        'section'     => 'britt_fonts',
        'label'       => __('H5 font size', 'britt'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //H6 size
    $wp_customize->add_setting(
        'h6_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '12',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'h6_size', array(
        'type'        => 'number',
        'priority'    => 22,
        'section'     => 'britt_fonts',
        'label'       => __('H6 font size', 'britt'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //Body
    $wp_customize->add_setting(
        'body_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '16',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'body_size', array(
        'type'        => 'number',
        'priority'    => 23,
        'section'     => 'britt_fonts',
        'label'       => __('Body font size', 'britt'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 24,
            'step'  => 1,
        ),
    ) );

}
add_action( 'customize_register', 'britt_customize_register' );


/**
* Sanitize
*/
//Featured images
function britt_sanitize_single_images( $input ) {
    if ( in_array( $input, array( 'in-post', 'above-post', 'none' ), true ) ) {
        return $input;
    }
}


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function britt_customize_preview_js() {
	wp_enqueue_script( 'britt_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20160509', true );
}
add_action( 'customize_preview_init', 'britt_customize_preview_js' );



//Checkboxes
function britt_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

//Integers
function britt_sanitize_int( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}

//Text
function britt_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

//Sticky widgets
function britt_sanitize_sticky_widgets( $input ) {
    if ( in_array( $input, array( 'on', 'off' ), true ) ) {
        return $input;
    }
}
