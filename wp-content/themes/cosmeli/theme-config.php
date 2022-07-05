<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('gon_theme_config')) {

    class gon_theme_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (true == Redux_Helpers::isTheme(__FILE__)) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => esc_html__('Section via hook', 'cosmeli'),
                'desc' => wp_kses(__('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'cosmeli'), array('p' => array())),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
			);

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (($sample_patterns_file = readdir($sample_patterns_dir)) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(esc_html__('Customize &#8220;%s&#8221;', 'cosmeli'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview', 'cosmeli'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview', 'cosmeli'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(esc_html__('By %s', 'cosmeli'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(esc_html__('Version %s', 'cosmeli'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . esc_html__('Tags', 'cosmeli') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . wp_kses(__('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'cosmeli'), array('a' => array('href' => array(),'title' => array()))) . '</p>', esc_html__('http://codex.wordpress.org/Child_Themes', 'cosmeli'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(get_template_directory() . '/info-html.html')) {
                Redux_Functions::initWpFilesystem();
                
                global $wp_filesystem;

                $sampleHTML = $wp_filesystem->get_contents(get_template_directory() . '/info-html.html');
            }
	
            // General
            $this->sections[] = array(
                'title'     => esc_html__('General', 'cosmeli'),
                'desc'      => esc_html__('General theme options', 'cosmeli'),
                'icon'      => 'el-icon-cog',
                'fields'    => array(

                    array(
                        'id'        => 'logo_main',
                        'type'      => 'media',
                        'title'     => esc_html__('Logo', 'cosmeli'),
                        'compiler'  => 'true',
                        'mode'      => false,
                        'desc'      => esc_html__('Upload logo here.', 'cosmeli'),
					),
					array(
                        'id'        => 'logo_text',
                        'type'      => 'text',
                        'title'     => esc_html__('Logo Text', 'cosmeli'),
                        'default'   => ''
					),
					array(
                        'id'        => 'logo_erorr',
                        'type'      => 'media',
                        'title'     => esc_html__('Logo for error 404 page', 'cosmeli'),
                        'compiler'  => 'true',
                        'mode'      => false,
					),
					
					array(
                        'id'        => 'gon_loading',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show Loading Page', 'cosmeli'),
						'default'   => false,
					),
				),
			);
			// Background
            $this->sections[] = array(
                'title'     => esc_html__('Background', 'cosmeli'),
                'desc'      => esc_html__('Use this section to upload background images, select background color', 'cosmeli'),
                'icon'      => 'el-icon-picture',
                'fields'    => array(
					
					array(
                        'id'        => 'background_opt',
                        'type'      => 'background',
                        'output'    => array('body'),
                        'title'     => esc_html__('Body Background', 'cosmeli'),
                        'subtitle'  => esc_html__('Body background with image, color. Only work with box layout', 'cosmeli'),
						'default'   => '#f5f5f5',
					),
					array(
                        'id'        => 'breadcrumb_background',
                        'type'      => 'media',
                        'title'     => esc_html__('Background breadcrumb', 'cosmeli'),
                        'compiler'  => 'true',
                        'mode'      => false,
                        'desc'      => esc_html__('Upload logo here.', 'cosmeli'),
					),
				),
			);
			// Colors
            $this->sections[] = array(
                'title'     => esc_html__('Colors', 'cosmeli'),
                'desc'      => esc_html__('Colors options', 'cosmeli'),
                'icon'      => 'el-icon-tint',
				'fields'    	=> array(
					array(
                        'id'        	=> 'primary_color',
                        'type'      	=> 'color',
                        'title'     	=> esc_html__('Primary Color', 'cosmeli'),
                        'subtitle'  	=> esc_html__('Pick a color for primary color (default: #c9a654).', 'cosmeli'),
						'transparent' 	=> false,
                        'default'   	=> '#c9a654',
                        'validate'  	=> 'color',
					),
					array(
                        'id'        	=> 'rate_color',
                        'type'      	=> 'color',
                        //'output'    	=> array(),
                        'title'     	=> esc_html__('Rating Star Color', 'cosmeli'),
                        'subtitle'  	=> esc_html__('Pick a color for star of rating (default: #111111).', 'cosmeli'),
						'transparent' 	=> false,
                        'default'  		=> '#111111',
                        'validate'  	=> 'color',
					),
					array(
                        'id'        	=> 'price_color',
                        'type'      	=> 'color',
                        //'output'    	=> array(),
                        'title'     	=> esc_html__('Price Color', 'cosmeli'),
                        'subtitle'  	=> esc_html__('Pick a color for Price Color (default: #c9a654).', 'cosmeli'),
						'transparent' 	=> false,
                        'default'  		=> '#c9a654',
                        'validate'  	=> 'color',
					),
				),
			);
			
			//Header
			$this->sections[] = array(
                'title'     => esc_html__('Header', 'cosmeli'),
                'desc'      => esc_html__('Header options', 'cosmeli'),
                'icon'      => 'el-icon-tasks',
                'fields'    => array(
					array(
                        'id'        => 'header_layout',
                        'type'      => 'image_select',
                        'title'     => esc_html__('Header Layout', 'cosmeli'),
						'subtitle' => esc_html__( 'Please choose header layout', 'cosmeli'),

                        //Must provide key => value pairs for select options
                        'options'   => array(
							'layout-1' => array(
                                'alt' => esc_html__( 'Header Style 1', 'cosmeli' ),
                                'img' => get_template_directory_uri() . '/images/header/header-1.jpg',
                            ),
                            'layout-2' => array(
                                'alt' => esc_html__( 'Header Style 2', 'cosmeli' ),
                                'img' => get_template_directory_uri() . '/images/header/header-2.jpg',
                            ),
							'layout-3' => array(
                                'alt' => esc_html__( 'Header Style 3', 'cosmeli' ),
                                'img' => get_template_directory_uri() . '/images/header/header-3.jpg',
                            ),
							'layout-4' => array(
                                'alt' => esc_html__( 'Header Style 4', 'cosmeli' ),
                                'img' => get_template_directory_uri() . '/images/header/header-4.jpg',
                            ),
                        ),
                        'default'   => 'layout-2'
                    ),
					array(
                        'id'        => 'mini_cart_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Mini Cart Title', 'cosmeli'),
                        'default'   => 'Cart'
					),
					array(
                        'id'        => 'title_mobile_menu',
                        'type'      => 'text',
                        'title'     => esc_html__('Title Mobile Menu', 'cosmeli'),
                        'default'   => 'Menu'
					),
					array(
                        'id'        => 'header_contact',
                        'type'      => 'text',
                        'title'     => esc_html__('Contact', 'cosmeli'),
                        'default'   => 'Email: support@demo.com'
					),
					array(
                        'id'        => 'header_hotline',
                        'type'      => 'text',
                        'title'     => esc_html__('Hotline', 'cosmeli'),
                        'default'   => 'Hotline: +012 345 6789'
					),
					array(
                        'id'        => 'category_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Category Title', 'cosmeli'),
                        'default'   => 'Category'
					),
				),
			);
			$this->sections[] = array(
				'icon'       => 'el-icon-website',
				'title'      => esc_html__('Header Social Icons', 'cosmeli'),
				'subsection' => true,
				'fields'     => array(
					array(
                        'id'        => 'header_social_show',
                        'type'      => 'switch',
                        'title'     => esc_html__('Header Show Social', 'cosmeli'),
						'default'   => true,
                    ),
					array(
						'id'       => 'hdsocial_icons',
						'type'     => 'sortable',
						'title'    => esc_html__('Header social Icons', 'cosmeli'),
						'subtitle' => esc_html__('Enter social links', 'cosmeli'),
						'desc'     => esc_html__('Drag/drop to re-arrange. (Facebook, Twitter, Instagram, Pinterest, Google Plus, Linkedin, Dribbble, RSS)', 'cosmeli'),
						'mode'     => 'text',
						'options'  => array(
							'facebook'    => '',
							'twitter'     => '',
							'instagram'   => '',
							'pinterest'   => '',
							'google-plus' => '',
							'linkedin'    => '',
							'dribbble'    => '',
							'rss'         => '',
						),
						'default' => array(
						    'facebook'    => 'https://www.facebook.com/',
							'twitter'     => 'https://twitter.com/',
							'instagram'   => '#',
							'pinterest'   => '#',
							'google-plus' => '',
							'linkedin'    => '',
							'dribbble'    => '',
							'rss'         => '#',
						),
					),
				)
			);
			
			//Footer
			$this->sections[] = array(
                'title'     => esc_html__('Footer', 'cosmeli'),
                'desc'      => esc_html__('Footer options', 'cosmeli'),
                'icon'      => 'el-icon-tasks',
                'fields'    => array(
					array(
                        'id'        => 'copyright_show',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show Copyright', 'cosmeli'),
						'default'   => true,
					),
					array(
                        'id'        => 'copyright-notice',
                        'type'      => 'textarea',
                        'title'     => esc_html__('Copyright Notice', 'cosmeli'),
                        'default'   => 'Copyright 2018 Designed by {GonThemes}. Powered by WordPress.'
					),
					array(
                        'id'        => 'copyright-link',
                        'type'      => 'text',
                        'title'     => esc_html__('Copyright Link', 'cosmeli'),
                        'default'   => 'http://gonthemes.info',
						'placeholder'  => 'http://',
					),
					array(
                        'id'        => 'footer_payment',
                        'type'      => 'media',
                        'title'     => esc_html__('Image Payment', 'cosmeli'),
                        'compiler'  => 'true',
                        'mode'      => false,
                        'desc'      => esc_html__('Upload logo here.', 'cosmeli'),
					),
				),
			);
			$this->sections[] = array(
				'icon'       => 'el-icon-website',
				'title'      => esc_html__('Footer Social Icons', 'cosmeli'),
				'subsection' => true,
				'fields'     => array(
					array(
                        'id'        => 'footer_social_show',
                        'type'      => 'switch',
                        'title'     => esc_html__('Footer Show Social', 'cosmeli'),
						'default'   => true,
                    ),
					array(
						'id'       => 'ftsocial_icons',
						'type'     => 'sortable',
						'title'    => esc_html__('Footer social Icons', 'cosmeli'),
						'subtitle' => esc_html__('Enter social links', 'cosmeli'),
						'desc'     => esc_html__('Drag/drop to re-arrange. (Facebook, Twitter, Instagram, Pinterest, Google Plus, Linkedin, Dribbble, RSS)', 'cosmeli'),
						'mode'     => 'text',
						'options'  => array(
							'facebook'    => '',
							'twitter'     => '',
							'instagram'   => '',
							'pinterest'   => '',
							'google-plus' => '',
							'linkedin'    => '',
							'dribbble'    => '',
							'rss'         => '',
						),
						'default' => array(
						    'facebook'    => 'https://www.facebook.com/',
							'twitter'     => 'https://twitter.com/',
							'instagram'   => '#',
							'pinterest'   => '#',
							'google-plus' => '',
							'linkedin'    => '',
							'dribbble'    => '#',
							'rss'         => '',
						),
					),
				)
			);
			$this->sections[] = array(
				'icon'       => 'el-icon-website',
				'title'      => esc_html__( 'Popup Newsletter', 'cosmeli' ),
				'subsection' => true,
				'fields'     => array(
					array(
                        'id'        => 'newsletter_show',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show Newsletter', 'cosmeli'),
						'default'   => false,
					),
					array(
                        'id'        => 'newsletter_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Newsletter title', 'cosmeli'),
                        'default'   => 'Get In Touch'
                    ),
					array(
						'id'       => 'newsletter_form',
						'type'     => 'text',
						'title'    => esc_html__('Newsletter form ID', 'cosmeli'),
						'subtitle' => esc_html__('The form ID of MailPoet plugin.', 'cosmeli'),
						'validate' => 'numeric',
						'msg'      => 'Please enter a form ID',
						'default'  => '1'
					),
				)
			);
			
			//Fonts
			$this->sections[] = array(
                'title'     => esc_html__('Fonts', 'cosmeli'),
                'desc'      => esc_html__('Fonts options', 'cosmeli'),
                'icon'      => 'el-icon-font',
                'fields'    => array(

                    array(
                        'id'            	=> 'bodyfont',
                        'type'          	=> 'typography',
                        'title'         	=> esc_html__('Body font', 'cosmeli'),
                        //'compiler'      	=> true,  // Use if you want to hook in your own CSS compiler
                        'google'        	=> true,    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   	=> true,    // Select a backup non-google font in addition to a google font
                        //'font-style'    	=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'       	=> false, // Only appears if google is true and subsets not set to false
                        //'font-size'     	=> false,
                        //'line-height'   	=> false,
                        //'word-spacing'  	=> true,  // Defaults to false
                        //'letter-spacing'	=> true,  // Defaults to false
                        //'color'         	=> false,
                        //'preview'       	=> false, // Disable the previewer
                        'all_styles'    	=> true,    // Enable all Google Font style/weight variations to be added to the page
                        'output'        	=> array('body'), // An array of CSS selectors to apply this font style to dynamically
                        //'compiler'      	=> array('h2.site-description-compiler'), // An array of CSS selectors to apply this font style to dynamically
                        'units'         	=> 'px', // Defaults to px
                        'subtitle'      	=> esc_html__('Main body font.', 'cosmeli'),
						'update-weekly'     => true,
                        'default'       	=> array(
                            'color'         => '#111111',
                            'font-weight'   => '400',
							'font-family'   => 'Josefin Sans',
                            'google'        => true,
                            'font-size'     => '14px',
                            'line-height'   => '22px'),
					),
					array(
                        'id'            	=> 'headingfont',
                        'type'          	=> 'typography',
                        'title'         	=> esc_html__('Heading font (h1, h2, h3, h4, h5, h6)', 'cosmeli'),
                        //'compiler'      	=> true,  // Use if you want to hook in your own CSS compiler
                        'google'        	=> true,    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   	=> true,    // Select a backup non-google font in addition to a google font
                        //'font-style'    	=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'       	=> false, // Only appears if google is true and subsets not set to false
                        'font-size'     	=> false,
                        'line-height'   	=> false,
                        //'word-spacing'  	=> true,  // Defaults to false
                        //'letter-spacing'	=> true,  // Defaults to false
                        //'color'         	=> false,
                        //'preview'       	=> false, // Disable the previewer
                        'all_styles'    	=> true,    // Enable all Google Font style/weight variations to be added to the page
                        'output'        	=> array('h1, h2, h3, h4, h5, h6'), // An array of CSS selectors to apply this font style to dynamically
                        //'compiler'      	=> array('h2.site-description-compiler'), // An array of CSS selectors to apply this font style to dynamically
                        'units'         	=> 'px', // Defaults to px
                        'subtitle'      	=> esc_html__('Heading font.', 'cosmeli'),
                        'default'       	=> array(
                            'color'         => '#222222',
                            'font-weight'   => '700',
							'font-family'   => 'Poppins',
                            'google'        => true,
						),
					),
				),
			);
			
			// Layout
            $this->sections[] = array(
                'title'     => esc_html__('Layout', 'cosmeli'),
                'icon'      => 'el-icon-align-justify',
                'fields'    => array(
					array(
						'id'       => 'page_style',
						'subtitle' => esc_html__('Select layout style: Box or Full Width', 'cosmeli'),
						'type'     => 'select',
						'multi'    => false,
						'title'    => esc_html__('Layout Style', 'cosmeli'),
						'options'  => array(
							'full' => 'Full Width',
							'box'  => 'Box'
						),
						'default'  => 'full'
					),
					array(
                        'id'        => 'enable_sswitcher',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show Style Switcher', 'cosmeli'),
						'subtitle'  => esc_html__('The style switcher is only for preview on front-end', 'cosmeli'),
						'default'   => false,
					),
				),
			);
			
			// Sidebar
			$this->sections[] = array(
                'title'     => esc_html__('Sidebar', 'cosmeli'),
                'desc'      => esc_html__('Sidebar options', 'cosmeli'),
                'icon'      => 'el-icon-list',
                'fields'    => array(
					array(
						'id'       	=> 'sidebar_shop',
						'type'     	=> 'radio',
						'title'    	=> esc_html__('Main Sidebar Shop', 'cosmeli'),
						'subtitle'      => esc_html__('Sidebar on category page', 'cosmeli'),
						'options'  	=> array(
							'left' 	=> 'Left',
							'right' => 'Right'),
						'default'  	=> 'left'
					),
					array(
						'id'       	=> 'sidebar_product',
						'type'     	=> 'radio',
						'title'    	=> esc_html__('Product Sidebar Position', 'cosmeli'),
						'subtitle'      => esc_html__('Sidebar on product page', 'cosmeli'),
						'options'  	=> array(
							'left' 	=> 'Left',
							'right' => 'Right'),
						'default'  	=> 'right'
					),
					array(
						'id'       	=> 'sidebarse_pos',
						'type'     	=> 'radio',
						'title'    	=> esc_html__('Secondary Sidebar Position', 'cosmeli'),
						'subtitle'  => esc_html__('Sidebar on pages', 'cosmeli'),
						'options'  	=> array(
							'left' 	=> 'Left',
							'right' => 'Right'),
						'default'  	=> 'left'
					),
					array(
						'id'       	=> 'sidebarblog_pos',
						'type'     	=> 'radio',
						'title'    	=> esc_html__('Blog Sidebar Position', 'cosmeli'),
						'subtitle'  => esc_html__('Sidebar on Blog pages', 'cosmeli'),
						'options'  	=> array(
							'left' 	=> 'Left',
							'right' => 'Right',
							'none' => 'None'),
						'default'  	=> 'right'
					),
				),
			);
			
			// Blog
            $this->sections[] = array(
                'title'     => esc_html__('Blog', 'cosmeli'),
                'desc'      => esc_html__('Use this section to select options for blog', 'cosmeli'),
                'icon'      => 'el-icon-edit',
                'fields'    => array(
					array(
                        'id'        => 'enable_blog_date',
                        'type'      => 'switch',
                        'title'     => esc_html__('Date Blog', 'cosmeli'),
						'subtitle'  => esc_html__('Show/Hide position date blog', 'cosmeli'),
						'default'   => true,
					),
					array(
                        'id'        => 'enable_single_social',
                        'type'      => 'switch',
                        'title'     => esc_html__('Social Single Post', 'cosmeli'),
						'subtitle'  => esc_html__('Show/Hide position social single post', 'cosmeli'),
						'default'   => true,
					),
					array(
                        'id'        => 'enable_single_author',
                        'type'      => 'switch',
                        'title'     => esc_html__('Author Single Post', 'cosmeli'),
						'subtitle'  => esc_html__('Show/Hide position author single post', 'cosmeli'),
						'default'   => true,
					),
				),
			);
		  
			// Product
			$this->sections[] = array(
                'title'     => esc_html__('Product', 'cosmeli'),
                'desc'      => esc_html__('Use this section to select options for product', 'cosmeli'),
                'icon'      => 'el-icon-shopping-cart',
                'fields'    => array(
					array(
						'id'       	=> 'layout_product',
						'type'     	=> 'radio',
						'title'    	=> esc_html__('Category View Layout', 'cosmeli'),
						'subtitle'      => esc_html__('View layout on category page', 'cosmeli'),
						'options'  	=> array(
							'gridview' 	=> 'Grid View',
							'listview' => 'List View'),
						'default'  	=> 'gridview'
					),
					array(
						'id'       => 'second_image',
						'type'     => 'switch',
						'title'    => esc_html__('Use secondary product image', 'cosmeli'),
						'default'  => false,
					),
					array(
						'id'       => 'quick_view',
						'type'     => 'switch',
						'title'    => esc_html__('Use quick view product', 'cosmeli'),
						'default'  => true,
					),	
					array(
						'id'       	=> 'sale_label',
						'type'     	=> 'radio',
						'title'    	=> esc_html__('Sale Label Settings', 'cosmeli'),
						'subtitle'      => esc_html__('Config Sale Label Settings', 'cosmeli'),
						'options'  	=> array(
							'Sale' 						=> esc_html__('Sale', 'cosmeli'),
							'{percent-diff}%' 	=> esc_html__('{percent-diff}%', 'cosmeli'),
							'${price-diff}' 	=> esc_html__('${price-diff}', 'cosmeli'),
							'custom' 				=> esc_html__('Custom (use field below)', 'cosmeli'),
						),
						'default'  	=> 'custom'
					),
					array(
                        'id'        => 'sale_label_custom',
                        'type'      => 'text',
                        'title'     => esc_html__('Custom Format Label', 'cosmeli'),
                        'desc'     => esc_html__('{price-diff} inserts the dollar amount off, {percent-diff} inserts the percent reduction (rounded).', 'cosmeli'),
                        'default'   => wp_kses(__('Sale <span>{percent-diff}%</span>', 'cosmeli'), array('span' => array())),
					),		
					array(
                        'id'        => 'featured_label_custom',
                        'type'      => 'text',
                        'title'     => esc_html__('Custom Featured Label', 'cosmeli'),
                        'desc'     => esc_html__('Text Custom Featured Label ', 'cosmeli'),
                        'default'   => 'Hot'
					),
					array(
                        'id'        => 'cat_banner_img',
                        'type'      => 'media',
                        'title'     => esc_html__('Banner Header Category', 'cosmeli'),
                        'compiler'  => 'true',
                        'mode'      => false,
                        'desc'      => esc_html__('Upload banner category here.', 'cosmeli'),
					),
					array(
                        'id'        => 'cat_banner_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Banner Header Title', 'cosmeli'),
                        'default'   => 'My Shop'
					),
					
					array(
                        'id'        => 'cat_banner_description',
                        'type'      => 'text',
                        'title'     => esc_html__('Banner Header Description', 'cosmeli'),
                        'default'   => 'Lorem ipsum dolor sit amet, consectetur elit. Ad assumenda fuga illo laudantium magni sed temporibus sed temporibus fuga illo laudantium.'
					),
					array(
						'id'        	=> 'product_per_page',
						'type'      	=> 'slider',
						'title'     	=> esc_html__('Products per page', 'cosmeli'),
						'subtitle'  	=> esc_html__('Amount of products per page on category page', 'cosmeli'),
						"default"   	=> 9,
						"min"       	=> 3,
						"step"      	=> 1,
						"max"       	=> 48,
						'display_value' => 'text'
					),
					array(
                        'id'        => 'product_columns',
                        'type'      => 'select',
                        'title'     => esc_html__('Product Columns', 'cosmeli'),
						'subtitle'      => esc_html__('Amount of products on row', 'cosmeli'),
                        'options'   => array(
                            '2' => '2 columns',
							'3' => '3 columns',
							'4' => '4 columns',
                      ),
                        'default'   => '3'
					),
					
					array(
                        'id'        => 'related_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Related products title', 'cosmeli'),
                        'default'   => 'Related Products'
					),
					array(
						'id'        	=> 'related_amount',
						'type'      	=> 'slider',
						'title'     	=> esc_html__('Number of related products', 'cosmeli'),
						"default"   	=> 6,
						"min"       	=> 3,
						"step"      	=> 1,
						"max"       	=> 16,
						'display_value' => 'text'
					),
					array(
                        'id'        => 'upsells_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Upsell products title', 'cosmeli'),
                        'default'   => 'Upsell Products'
					),
					
					array(
                        'id'        => 'crosssells_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Cross Sells title', 'cosmeli'),
                        'default'   => 'Cross Sells'
					),
					
					array(
						'id'		=>'share_head_code',
						'type' 		=> 'textarea',
						'title' 	=> esc_html__('ShareThis/AddThis head tag', 'cosmeli'), 
						'desc' 		=> esc_html__('Paste your ShareThis or AddThis head tag here', 'cosmeli'),
						'default' 	=> '',
					),
					array(
						'id'		=>'share_code',
						'type' 		=> 'textarea',
						'title' 	=> esc_html__('ShareThis/AddThis code', 'cosmeli'), 
						'desc' 		=> esc_html__('Paste your ShareThis or AddThis code here', 'cosmeli'),
						'default' 	=> ''
					),
				),
			);
			
			// Less Compiler
            $this->sections[] = array(
                'title'     => esc_html__('Less Compiler', 'cosmeli'),
                'desc'      => esc_html__('Turn on this option to apply all theme options. Turn of when you have finished changing theme options and your site is ready.', 'cosmeli'),
                'icon'      => 'el-icon-wrench',
                'fields'    => array(
					array(
                        'id'        => 'enable_less',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Less Compiler', 'cosmeli'),
						'default'   => true,
					),
				),
			);
			
            $theme_info  = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . wp_kses(__('<strong>Theme URL:</strong> ', 'cosmeli'), array('strong' => array())) . '<a href="' . $this->theme->get('ThemeURI') . '">' . $this->theme->get('ThemeURI') . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . wp_kses(__('<strong>Author:</strong> ', 'cosmeli'), array('strong' => array())) . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . wp_kses(__('<strong>Version:</strong> ', 'cosmeli'), array('strong' => array())) . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
            $tabs 		 = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . wp_kses(__('<strong>Tags:</strong> ', 'cosmeli'), array('strong' => array())) . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

            $this->sections[] = array(
                'icon'              => 'el-icon-list-alt',
                'title'             => esc_html__('Customizer Only', 'cosmeli'),
                'desc'              => wp_kses(__('<p class="description">This Section should be visible only in Customizer</p>', 'cosmeli'), array('p' => array('class' => array()))),
                'customizer_only'   => true,
                'fields'    => array(
                    array(
                        'id'        => 'opt-customizer-only',
                        'type'      => 'select',
                        'title'     => esc_html__('Customizer Only Option', 'cosmeli'),
                        'subtitle'  => esc_html__('The subtitle is NOT visible in customizer', 'cosmeli'),
                        'desc'      => esc_html__('The field desc is NOT visible in customizer.', 'cosmeli'),
                        'customizer_only'   => true,

                        //Must provide key => value pairs for select options
                        'options'   => array(
                            '1' => 'Opt 1',
                            '2' => 'Opt 2',
                            '3' => 'Opt 3'
						),
                        'default'   => '2'
					),
				)
			);            
            
            $this->sections[] = array(
                'title'     => esc_html__('Import / Export', 'cosmeli'),
                'desc'      => esc_html__('Import and Export your Redux Framework settings from file, text or URL.', 'cosmeli'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
					),
				),
			);

            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => esc_html__('Theme Information', 'cosmeli'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
					)
				),
			);
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => esc_html__('Theme Information 1', 'cosmeli'),
                'content'   => wp_kses(__('<p>This is the tab content, HTML is allowed.</p>', 'cosmeli'), array('p' => array()))
			);

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => esc_html__('Theme Information 2', 'cosmeli'),
                'content'   => wp_kses(__('<p>This is the tab content, HTML is allowed.</p>', 'cosmeli'), array('p' => array()))
			);

            // Set the help sidebar
            $this->args['help_sidebar'] = wp_kses(__('<p>This is the sidebar content, HTML is allowed.</p>', 'cosmeli'), array('p' => array()));
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'gon_options',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => esc_html__('Theme Options', 'cosmeli'),
                'page_title'        => esc_html__('Theme Options', 'cosmeli'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' 	=> '', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => true,                    // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'          => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'       => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
					),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
					),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
						),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
						),
					),
				)
			);


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el-icon-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
			);
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
			);
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
			);
            $this->args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el-icon-linkedin'
			);

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                
            } else {
                
            }
        }

    }
    
    global $reduxConfig;
    $reduxConfig = new gon_theme_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
