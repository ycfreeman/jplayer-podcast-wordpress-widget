<?php
/**
 * @wordpress-plugin
 * Plugin Name: jPlayer Podcast Widget
 * Plugin URI: http://ycfreeman.com
 * Description: Widget that use jPlayer to play Podcast RSS playlists
 * Version: 1.0.3
 * Author: Freeman Man
 * Author URI: http://ycfreeman.com
 * Text Domain: jplayer-podcast
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: https://github.com/ycfreeman/jplayer-podcast-wordpress-widget
 *
 * @package   JPlayer_Podcast
 * @author    Freeman Man <freeman@ycfreeman.com>
 * @license   GPL-2.0+
 * @link      http://ycfreeman.com
 * @copyright 2016 ycfreeman.com
 *
 */

$swfPath = plugins_url("jplayer/jplayer/jquery.jplayer.swf", __FILE__);
$podcastParserPath = plugins_url("assets/podparser.php", __FILE__);

// Prevent direct file access
if (!defined('ABSPATH')) {
    exit;
}

class JPlayer_Podcast extends WP_Widget
{

    /**
     *
     * Unique identifier for your widget.
     *
     *
     * The variable name is used as the text domain when internationalizing strings
     * of text. Its value should match the Text Domain file header in the main
     * widget file.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $widget_slug = 'jplayer-podcast';

    /*--------------------------------------------------*/
    /* Constructor
    /*--------------------------------------------------*/

    /**
     * Specifies the classname and description, instantiates the widget,
     * loads localization files, and includes necessary stylesheets and JavaScript.
     */
    public function __construct()
    {


        // load plugin text domain
        add_action('init', array($this, 'widget_textdomain'));

        // Hooks fired when the Widget is activated and deactivated
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));

        parent::__construct(
            $this->get_widget_slug(),
            __('jPlayer Podcast', $this->get_widget_slug()),
            array(
                'classname' => $this->get_widget_slug() . '-class',
                'description' => __('Widget that use jPlayer to play Podcast RSS', $this->get_widget_slug())
            )
        );

        // Register admin styles and scripts
        add_action('admin_print_styles', array($this, 'register_admin_styles'));
        add_action('admin_enqueue_scripts', array($this, 'register_admin_scripts'));

        // Register site styles and scripts
        add_action('wp_enqueue_scripts', array($this, 'register_widget_styles'));
        add_action('wp_enqueue_scripts', array($this, 'register_widget_scripts'));

        // Refreshing the widget's cached output with each new post
        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));

    } // end constructor


    /**
     * Return the widget slug.
     *
     * @since    1.0.0
     *
     * @return    Plugin slug variable.
     */
    public function get_widget_slug()
    {
        return $this->widget_slug;
    }

    /*--------------------------------------------------*/
    /* Widget API Functions
    /*--------------------------------------------------*/

    /**
     * Outputs the content of the widget.
     *
     * @param array args  The array of form elements
     * @param array instance The current instance of the widget
     */
    public function widget($args, $instance)
    {
        // Check if there is a cached output
        $cache = wp_cache_get($this->get_widget_slug(), 'widget');

        if (!is_array($cache))
            $cache = array();

        if (!isset ($args['widget_id']))
            $args['widget_id'] = $this->id;

        $widgetId = $args['widget_id'];

        if (isset ($cache[$args['widget_id']]))
            return print $cache[$args['widget_id']];

        // go on with your widget logic, put everything into a string and …

        extract($args, EXTR_SKIP);

        $widget_string = $before_widget;

        /* Our variables from the widget settings. */
        $title = apply_filters('widget_title', $instance['title']);

        /* Display the widget title if one was input (before and after defined by themes). */
        if (!empty($title)) {
            $widget_string .= $before_title . $title . $after_title;
        }

        ob_start();
        include(plugin_dir_path(__FILE__) . 'views/widget.php');
        $widget_string .= ob_get_clean();
        $widget_string .= $after_widget;


        $cache[$args['widget_id']] = $widget_string;

        wp_cache_set($this->get_widget_slug(), $cache, 'widget');

        print $widget_string;

    } // end widget


    public function flush_widget_cache()
    {
        wp_cache_delete($this->get_widget_slug(), 'widget');
    }

    /**
     * Processes the widget's options to be saved.
     *
     * @param array new_instance The new instance of values to be generated via the update.
     * @param array old_instance The previous instance of values before the update.
     */
    public function update($new_instance, $old_instance)
    {

        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);
        $instance['url'] = strip_tags($new_instance['url']);
        $instance['count'] = strip_tags($new_instance['count']);
        $instance['autoplay'] = strip_tags($new_instance['autoplay']);
        $instance['corsenabled'] = strip_tags($new_instance['corsenabled']);


        return $instance;

    } // end widget

    /**
     * Generates the administration form for the widget.
     *
     * @param array instance The array of keys and values for the widget.
     */
    public function form($instance)
    {
        $defaults = array(
            'title' => '',
            'url' => '',
            'count' => 20,
            'autoplay' => 1,
            'corsenabled' => 0
        );

        $instance = wp_parse_args(
            (array)$instance, $defaults
        );

        // Display the admin form
        include(plugin_dir_path(__FILE__) . 'views/admin.php');

    } // end form

    /*--------------------------------------------------*/
    /* Public Functions
    /*--------------------------------------------------*/

    /**
     * Loads the Widget's text domain for localization and translation.
     */
    public function widget_textdomain()
    {

        load_plugin_textdomain($this->get_widget_slug(), false, plugin_dir_path(__FILE__) . 'lang/');

    } // end widget_textdomain

    /**
     * Fired when the plugin is activated.
     *
     * @param  boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
     */
    public function activate($network_wide)
    {

    } // end activate

    /**
     * Fired when the plugin is deactivated.
     *
     * @param boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
     */
    public function deactivate($network_wide)
    {

    } // end deactivate

    /**
     * Registers and enqueues admin-specific styles.
     */
    public function register_admin_styles()
    {

        wp_enqueue_style($this->get_widget_slug() . '-admin-styles', plugins_url('css/admin.css', __FILE__));

    } // end register_admin_styles

    /**
     * Registers and enqueues admin-specific JavaScript.
     */
    public function register_admin_scripts()
    {

        wp_enqueue_script($this->get_widget_slug() . '-admin-script', plugins_url('js/admin.js', __FILE__), array('jquery'));

    } // end register_admin_scripts

    /**
     * Registers and enqueues widget-specific styles.
     */
    public function register_widget_styles()
    {

        wp_enqueue_style($this->get_widget_slug() . '-widget-styles', plugins_url('css/widget.css', __FILE__));
        wp_enqueue_style($this->get_widget_slug() . "-widget-styles-theme-font",
            plugins_url("jplayer/skin/pixels/css/themicons.css", __FILE__));
        wp_enqueue_style($this->get_widget_slug() . "-widget-styles-theme",
            plugins_url("jplayer/skin/pixels/css/style.css", __FILE__));


    } // end register_widget_styles

    /**
     * Registers and enqueues widget-specific scripts.
     */
    public function register_widget_scripts()
    {
        wp_enqueue_script($this->get_widget_slug() . '-script-jplayer', plugins_url('jplayer/jplayer/jquery.jplayer.min.js', __FILE__), array('jquery'));
        wp_enqueue_script($this->get_widget_slug() . '-script-jplayer-playlist', plugins_url('jplayer/add-on/jplayer.playlist.min.js', __FILE__), array('jquery'));

    } // end register_widget_scripts

} // end class

add_action('widgets_init', create_function('', 'register_widget("JPlayer_Podcast");'));
