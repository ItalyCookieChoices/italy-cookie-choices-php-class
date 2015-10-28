<?php
/**
 * Class Name: Italy Cookie Choices
 * Class URI: https://plus.google.com/u/0/communities/109254048492234113886
 * Description: Minimal code to make sure your website repect the Italian coockie law
 * Version: 2.0.0
 * Author: Andrea Cardinale
 * Author URI: https://plus.google.com/u/0/communities/109254048492234113886
 * Text Domain: italy-cookie-choices
 * License: GPLv2 or later
 *
 * @package Italy Cookie Choices
 * @since 1.0.0
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


/**
 * Example = F:\xampp\htdocs\italystrap\wp-content\plugins\italystrap-extended\italystrap.php
 */
if ( !defined( 'ITALY_COOKIE_CHOICES_FILE' ) )
    define('ITALY_COOKIE_CHOICES_FILE', __FILE__ );

/**
 * Example = F:\xampp\htdocs\italystrap\wp-content\plugins\italy-cookie-choices
 */
if ( !defined( 'ITALY_COOKIE_CHOICES_DIRNAME' ) )
    define('ITALY_COOKIE_CHOICES_DIRNAME', dirname( ITALY_COOKIE_CHOICES_FILE ));

if ( !defined( 'ICC_DEBUG' ) )
    define('ICC_DEBUG',true);

/**
 * 
 */
if ( !class_exists( 'Italy_Cookie_Choices' ) ){

    class Italy_Cookie_Choices{

        /**
         * Definition of variables containing the configuration
         * to be applied to the various function calls wordpress
         */
        //protected $capability = 'manage_options';

        /**
         * Global variables and default values
         * @var array
         */
        protected $default_options = array();

        /**
         * Option
         * @var array
         */
        private $options = array();

        /**
         * Default Cookie name
         * @var string
         */
        private $cookieName = 'displayCookieConsent';

        /**
         * Default cookie value
         * @var string
         */
        private $cookieVal = 'y';

        /**
         * Pattern for searching embed code in content and widget
         * @var string
         */
        private $pattern = '#<iframe.*?\/iframe>|<embed.*?>|<script.*?\/script>#is';

        /**
         * Snippet for replacements
         * @var string
         */
        private $valore = '';

        /**
         * Array with embed found
         * @var array
         */
        public $js_array = array();

        public $bufferChanged = false;

        /**
         * [__construct description]
         */
        public function __construct(){

            //Add config option to exclude any path?
            //if exclude path

                $this->options = require(ITALY_COOKIE_CHOICES_DIRNAME.DIRECTORY_SEPARATOR.'config.php');

                /*
                 * Set cookie if the user agree navigating through the pages of the site
                 */
                $secondView = false;
                if(
                    // if is an HTML request (alternative methods???)
                    (strpos($_SERVER["HTTP_ACCEPT"],'html') !== false) &&
                    //if the page isn't privacy page
                    ($_SERVER['REQUEST_URI']!=$this->options['slug']) && 
                    //if HTTP_REFERER is set
                    (isset($_SERVER['HTTP_REFERER'])) && 
                    //if isn't refresh
                    (parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH)!=$_SERVER['REQUEST_URI']) &&
                    //if referrer is not privacy page (to be evaluated)
                    (parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH)!=$this->options['slug']) && 
                    //if the cookie is not already set
                    (!isset( $_COOKIE[ $this->options['cookie_name'] ] )) && 
                    //if the referer is in the same domain
                    (parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST)==$_SERVER['HTTP_HOST']) &&
                    //if the secondView option is set
                    ($this->options['secondView'])
                ) {
                    setcookie($this->options['cookie_name'], $this->options['cookie_value'], time()+(3600*24*365), '/');
                    $secondView = true;
                }

                if ( !isset( $_COOKIE[ $this->options['cookie_name'] ] ) && !$secondView ){

                    /**
                     * Background color for banner
                     * @var string
                     */
                    $banner_bg = ( isset( $this->options['banner_bg'] ) ) ? $this->options['banner_bg'] : '' ;

                    /**
                     * Color for text
                     * @var string
                     */
                    $banner_text_color = ( isset( $this->options['banner_text_color'] ) ) ? $this->options['banner_text_color'] : '' ;

                    /**
                     * Text for banner
                     * @var string
                     */
                    $text = ( isset( $this->options['text'] ) ) ? $this->options['text']    : '' ;

                    /**
                     * Text for buttom
                     * @var [type]
                     */
                    $button_text = ( isset( $this->options['button_text'] ) ) ? $this->options['button_text'] : '' ;

                    /**
                     * Checkbox custom scripts block
                     * @var bol
                     */
                    $custom_script_block = ( isset( $this->options['custom_script_block'] ) ) ? $this->options['custom_script_block'] : '' ;

                    /**
                     * Text to put inside locked post and widget contents
                     * including the button text
                     * @var string
                     */
                    $content_message_text = ( isset( $this->options['content_message_text'] ) ) ? $this->options['content_message_text']    : '' ;

                    /**
                     * Text for button in locked content and widget
                     * @var string
                     */
                    $content_message_button_text = ( isset( $this->options['content_message_button_text'] ) ) ? $this->options['content_message_button_text'] : '' ;

                    /**
                     * Replacement for regex
                     * @var string
                     */
                    $this->valore = '<div class="el"><div style="padding:10px;margin-bottom: 18px;color:'.$this->esc_attr( $banner_text_color ).';background-color:' . $this->esc_attr( $banner_bg ) . ';text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">' . $this->esc_attr( $content_message_text ) . '&nbsp;&nbsp;<button onclick="cookieChoices.removeCookieConsent()" style="color: '.$this->esc_attr( $banner_text_color ).';padding: 3px;font-size: 12px;line-height: 12px;text-decoration: none;text-transform: uppercase;margin:0;display: inline-block;font-weight: normal; text-align: center;  vertical-align: middle;  cursor: pointer;  border: 1px solid ' . $this->esc_attr( $banner_text_color ) . ';background: rgba(255, 255, 255, 0.03);">' . $this->esc_attr( $content_message_button_text ) . '</button></div><cookie></div>';

                    ob_start(array($this, 'block'));

                //}
            }
        }

        private function in_array_match($value, $array) {
            foreach($array as $k=>$v) {
                if(preg_match('#'.$v.'#is', $value)) {
                    return true;
                }
            }
            return false;
        }

        public function block($buffer, $phase) {

            /**
             * Checkbox for third part cookie in all page (except head and footer)
             * @var bol
             */
            $block_body = ( isset( $this->options['block_body'] ) ) ? $this->options['block_body'] : '' ;

            $block_body_scripts_exclude = ( isset( $this->options['block_body_scripts_exclude'] ) ) ? $this->options['block_body_scripts_exclude'] : '' ;
            $block_head_scripts_include = ( isset( $this->options['block_head_scripts_include'] ) ) ? $this->options['block_head_scripts_include'] : '' ;

            $buffer_old = $buffer;

            if ( preg_match('#(.*)(<head.*\/head>)(.*)(<body.*)(<\/body>)(.*)#is', $buffer_old, $matches) )
            {
                $pre_head = $matches[1];
                $head = $matches[2];
                $pre_body = $matches[3];
                $body = $matches[4];
                $end_body = $matches[5];
                $after_body = $matches[6];

                if ( $block_body ) {
                    preg_match_all( $this->pattern, $body, $body_matches);
                    if ( !empty( $body_matches[0] ) ) {
                        foreach($body_matches[0] AS $k => $v) {
                            if(!$this->in_array_match(trim($v), $block_body_scripts_exclude)) {
                                $body = preg_replace('#'.preg_quote(trim($v), '#').'#is', $this->valore, $body);
                                $this->js_array[] = trim($v);
                            }
                        }
                    }
                }

                foreach($block_head_scripts_include AS $single_script) {
                    preg_match_all('#'.str_replace("/", "\/", trim($single_script)).'#is', $head, $matches);
                    if(!empty($matches[0])) {
                        foreach($matches[0] AS $v) {
                            $head = str_replace(trim($v), "<!-- removed head from Italy Cookie Choices PHP Class -->", $head);
                            $this->js_array[] = trim($single_script);
                        }
                    }
                }

                $buffer = $pre_head.$head.$pre_body.$body.$this->print_script_inline().$end_body.$after_body;
            }
            return $buffer;
        }

        /**
         * Print script inline before </body>
         * @return string Print script inline
         * @link https://www.cookiechoices.org/
         */
        public function print_script_inline(){

            // $this->options = get_option( 'italy_cookie_choices' );

            /**
             * If is not active exit
             */
            if ( !isset( $this->options['active'] ) )
                return;

            /**
             * Select what kind of banner to display
             */
            if ( $this->options['banner'] === 1 || !empty( $this->options['slug'] ) ){

                $banner = 'Bar'; 
                $bPos = 'top:0';

            } elseif ( $this->options['banner'] === 2 ) {

                $banner = 'Dialog';
                $bPos = 'top:0';

            } elseif ( $this->options['banner'] === 3 ) {

                $banner = 'Bar'; 
                $bPos = 'bottom:0';

            } else {

                $banner = '';
                $bPos = 'top:0';

            }

            /**
             * Accept on scroll
             * @var bol
             */
            $scroll = ( isset( $this->options['scroll'] ) ) ? $this->options['scroll'] : '' ;

            /**
             * Reload on accept
             * @var bol
             */
            $reload = ( isset( $this->options['reload'] ) ) ? $this->options['reload'] : '' ;

            /**
             * Snippet for display banner
             * @uses json_encode Funzione usate per il testo del messaggio.
             *                   Ricordarsi che aggiunge già
             *                   le doppie virgolette "" alla stringa
             * @var string
             */
            $banner = 'document.addEventListener("DOMContentLoaded", function(event) {cookieChoices.showCookieConsent' . $banner . '(' . $this->wp_json_encode( $this->options['text'] ) . ', "' . $this->esc_js( $this->options['button_text'] ) . '", "' . $this->esc_js( $this->options['anchor_text'] ) . '", "' . ( $this->options['url'] ) . '");});';

            /**
             * ADVANCED OPTIONS
             */
            /**
             * Cookie name
             * @var string
             */
            $cookie_name = ( isset( $this->options['cookie_name'] ) ) ? $this->options['cookie_name'] : $this->cookieName ;

            /**
             * Cookie value
             * @var string/bolean
             */
            $cookie_value = ( isset( $this->options['cookie_value'] ) ) ? $this->options['cookie_value'] : $this->cookieVal ;

            /**
             * Se l'optione è selezionata aggiunge un margine per non nascondere il contenuto dalla top bar
             * @var string
             */
            $style = '<style>.icc{margin-top:36px}</style>';
            
            /**
             * Js_Template vlue
             * @var string
             */
            $js_template = ( isset( $this->options['js_template'] ) ) ? $this->options['js_template'] : '' ;
        
            /**
             * If is set html_margin checkbox in admin panel then add margin-top to HTML tag
             * @var bol
             */
            $htmlM = ( isset( $this->options['html_margin'] ) ) ? $this->options['html_margin'] : '' ;

            /**
             * If set open policy page in new browser tab
             * @var bol
             */
            $target = ( isset( $this->options['target'] ) ) ? $this->options['target'] : '' ;

            /**
             * Colore dello sfondo della dialog/topbar
             * @var string
             */
            $banner_bg = ( isset( $this->options['banner_bg'] ) ) ? $this->esc_attr( $this->options['banner_bg'] ) : '' ;

            /**
             * Colore del font della dialog/topbar
             * @var string
             */
            $banner_text_color = ( isset( $this->options['banner_text_color'] ) ) ? $this->esc_attr( $this->options['banner_text_color'] ) : '' ;

            /**
             * Declarations of JS variables and set parameters
             * var elPos = Gestisce la Posizione banner nella funzione _createHeaderElement
             * var infoClass = aggiunge una classe personalizzata per il link info
             * var closeClass = aggiunge una classe personalizzata per il link di accettazione
             * var htmlM = Aggiunge un margine a HTML per la top bar
             * var coNA = cookie name
             * var coVA = cookie val
             * var rel = Setto il reload per la pagina all'accettazione
             * var tar = Target -blank
             * var bgB = Colore del background della topbar/dialog
             * var btcB = Colore del font della topbar/dialog
             * @var string
             */
            $jsVariables = 'var coNA="' . $cookie_name . '",coVA="' . $cookie_value . '";scroll="' . $scroll . '",elPos="fixed",infoClass="",closeClass="",htmlM="' . $htmlM . '",rel="' . $reload . '",tar="' . $target . '",bgB="' . $banner_bg . '",btcB="' . $banner_text_color . '",bPos="' . $bPos . '",jsArr = ' . $this->wp_json_encode( $this->js_array ) . ';';

            /**
             * Noscript snippet in case browser has JavaScript disabled
             * @var string
             */
            $noscript = '<noscript><style>html{margin-top:35px}</style><div id="cookieChoiceInfo" style="position:absolute;width:100%;margin:0px;left:0px;top:0px;padding:4px;z-index:9999;text-align:center;background-color:rgb(238, 238, 238);"><span>' . $this->wp_json_encode( $this->options['text'] ) . '</span><a href="' . ( $this->options['url'] ) . '" target="_blank" style="margin-left:8px;">' . $this->esc_js( $this->options['anchor_text'] ) . '</a><a id="cookieChoiceDismiss" href="#" style="margin-left:24px;display:none;">' . $this->esc_js( $this->options['button_text'] ) . '</a></div></div></noscript>';

            /**
             * Select wich file to use in debug mode
             * @var string
             */
            $fileJS = ( ICC_DEBUG ) ? '/js/'.$js_template.'/cookiechoices.js' : '/js/'.$js_template.'/cookiechoices.php' ;

            $output_html = '<!-- Italy Cookie Choices -->' . $style . '<script>' . $jsVariables . file_get_contents( ITALY_COOKIE_CHOICES_DIRNAME . $fileJS ) .  $banner . '</script>' . $noscript;

            return $output_html;

        }

        public function wp_json_encode( $data, $options = 0, $depth = 512 ) {
            /*
             * json_encode() has had extra params added over the years.
             * $options was added in 5.3, and $depth in 5.5.
             * We need to make sure we call it with the correct arguments.
             */
            if ( version_compare( PHP_VERSION, '5.5', '>=' ) ) {
                $args = array( $data, $options, $depth );
            } elseif ( version_compare( PHP_VERSION, '5.3', '>=' ) ) {
                $args = array( $data, $options );
            } else {
                $args = array( $data );
            }
         
            $json = call_user_func_array( 'json_encode', $args );
         
            // If json_encode() was successful, no need to do more sanity checking.
            // ... unless we're in an old version of PHP, and json_encode() returned
            // a string containing 'null'. Then we need to do more sanity checking.
            if ( false !== $json && ( version_compare( PHP_VERSION, '5.5', '>=' ) || false === strpos( $json, 'null' ) ) )  {
                return $json;
            }
         
            return call_user_func_array( 'json_encode', $args );
        }

        private function esc_attr($text) {
            $text=str_replace('"','\"',$text);
            return $text;
        }

        private function esc_js($text) {
            $text = preg_replace( '/&#(x)?0*(?(1)27|39);?/i', "'", stripslashes( $text ) );
            $text = str_replace( "\r", '', $text );
            $text = str_replace( "\n", '\\n', addslashes( $text ) );
            return $text;
        }

        private function esc_url($text) {
            return urlencode($text);
        }

    }// class
}//endif

new Italy_Cookie_Choices;
