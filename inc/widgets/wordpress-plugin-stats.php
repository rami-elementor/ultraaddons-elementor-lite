<?php
namespace UltraAddons\Widget;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WordPress_Plugin_Stats extends Base{
    
    /**
     * Get your widget name
     *
     * Retrieve oEmbed widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string keywords
     */
    public function get_keywords() {
        return [ 'ultraaddons', 'stats', 'wp', 'plugin', 'wordpress' ];
    }
    
    
    /**
     * Register oEmbed widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {
        
               
    }
    
    /**
     * Render oEmbed widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        /**
         * Active Installation:
         * https://api.wordpress.org/stats/plugin/1.0/active-installs.php?slug={PLUGINSLUG}&limit=728
         */
        
        $settings           = $this->get_settings_for_display();
        $time_out = 10;
        $plugin_slug = 'ultraaddons-elementor-lite'; //woo-product-table
        $stats_url = 'https://api.wordpress.org/stats/plugin/1.0/?slug=' . $plugin_slug;
        $active_status = 'https://api.wordpress.org/stats/plugin/1.0/active-installs.php?slug=' . $plugin_slug . '&limit=728';
        $info_url = 'http://api.wordpress.org/plugins/info/1.0/' . $plugin_slug . '.json';
        $download_url = 'https://api.wordpress.org/stats/plugin/1.0/downloads.php?slug=' . $plugin_slug;
//        $remote = wp_remote_get( $download_url, array(
//                'timeout' => $time_out,//10,
//                'headers' => array(
//                        'Accept' => 'application/json'
//                ) )
//            );
//            var_dump($remote);
        
        $str = file_get_contents( $active_status );
        $json_active_stats = json_decode($str, true); // decode the JSON into an associative array
        // var_dump($json_active_stats);
        $total = 0;
        $pattern = "/[\+]/";
        foreach( $json_active_stats as $each){
           
            $number = preg_replace($pattern,'', $each);
            if($number > 70){
                $number = ceil($number / 100) * 100;
            }else{
                $number = ceil($number / 10) * 10;
            }
            
            $total += $number;
            var_dump($number);
        }
        var_dump($total);
        return;

        $str = file_get_contents( $stats_url );
        $json_status = json_decode($str, true); // decode the JSON into an associative array
        var_dump($json_status);
        
        
        $str = file_get_contents( $download_url );
        $json_download = json_decode($str, true); // decode the JSON into an associative array
        var_dump($json_download);
        
        $str = file_get_contents( $info_url );
        $json_info = $json = json_decode($str, true); // decode the JSON into an associative array
        var_dump($json_info);
        
        $transient_name = 'ua_wp_plugin_stats';
        $get_transient_json = get_transient( $transient_name );
        var_dump($get_transient_json);
        if( ! $get_transient_json ){
            $transient = set_transient( $transient_name, $json, 45);
        }
        
        
        
        ?>
<h2>Plugin Stats</h2>    
        <?php
    }
    

}