<?php
/**
  Plugin Name: jQuery Notebook
  Plugin URI: http://bineetchaubey.com
  Author: Bineet Kumar Chaubey
  Author URI: http://bineetchaubey.com
  Version: 1.0
  Description: Publish post of a categories in a Notebook style using jquery
  Lincence: GPL2 or later
 */

/*  Copyright 2011-2015  Bineet Kumar Chaubey  (email : bineet08 at gmail)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

define('PLUGINPATH', plugins_url('jquery-notebook', dirname(__FILE__)));

/**
 *  making a class wpbineetdigitalbook
 */
if (!class_exists("wpbineetdigitalbook")) {

    class wpbineetdigitalbook {

        var $adminDigitalBookSettingOption = "mypluginsetting";
        var $hoveroption = array('true', 'false');
        var $keyboardoption = array('true', 'false');
        var $coveroption = array('true', 'false');
        var $overlaysoption = array('true', 'false');
        var $shadowoption = array('true', 'false');
        var $pageselectinoption = array('true', 'false');
        var $chapterselection = array('true', 'false');

        
/**
 * Digital book initial setting
 *
 * @return array $wpdgtbk_Option  all  admin panel option
 */
        function getAdmindigitalBookOption() {
            $wpdgtbk_Option = array(
                'wpdgtbk-height' => 500,
                'wpdgtbk-width' => 800,
                'wpdgtbk-style' => 'default.css',
                'wpdgtbk-keyboard' => 'false',
                'wpdgtbk-hover' => 'false',
                'wpdgtbk-overlays' => 'false',
                'wpdgtbk-cover' => 'false',
                'wpdgtbk-shadow' => 'false',
                'wpdgtbk-pageselection' => 'false',
                'wpdgtbk-chapterselection' => 'false'
            );
            $adminDigitalBookOption = get_option($this->adminDigitalBookSettingOption);
            if (!empty($adminDigitalBookOption)) {
                foreach ($adminDigitalBookOption as $key => $values) {
                    $wpdgtbk_Option[$key] = $values;
                }
            }
            update_option($this->adminDigitalBookSettingOption, $wpdgtbk_Option);
            return $wpdgtbk_Option;
        }

        function init() {
            $this->getAdmindigitalBookOption();
        }

        /**
         * This function use to print admin option page
         */

        function wp_digital_printpage() {
            /*
             *  get save option  value from  databse
             */
            $wpdgtbk_Option = $this->getAdmindigitalBookOption();
            /**
             *  save  all  admin  option  when admin update setting record
             */
            if (isset($_POST['wpdgtbk-setting'])) {
                $wpdgtbk_Option['wpdgtbk-width'] = $_POST['wpdgtbk-width'];
                $wpdgtbk_Option['wpdgtbk-height'] = $_POST['wpdgtbk-height'];
                $wpdgtbk_Option['wpdgtbk-style'] = $_POST['wpdgtbk-style'];
                $wpdgtbk_Option['wpdgtbk-overlays'] = $_POST['wpdgtbk-overlays'];
                $wpdgtbk_Option['wpdgtbk-hover'] = $_POST['wpdgtbk-hover'];
                $wpdgtbk_Option['wpdgtbk-keyboard'] = $_POST['wpdgtbk-keyboard'];
                $wpdgtbk_Option['wpdgtbk-cover'] = $_POST['wpdgtbk-cover'];
                $wpdgtbk_Option['wpdgtbk-shadow'] = $_POST['wpdgtbk-shadow'];
                $wpdgtbk_Option['wpdgtbk-pageselection'] = $_POST['wpdgtbk-pageselection'];
                $wpdgtbk_Option['wpdgtbk-chapterselection'] = $_POST['wpdgtbk-chapterselection'];
                update_option($this->adminDigitalBookSettingOption, $wpdgtbk_Option);
            }
            $wpdgtbk_Option = get_option($this->adminDigitalBookSettingOption);
           
            /**
             *   admin   backend  form
             */
            echo '<div id="wrap" claas="warp">';
            echo '<div id="wpbkc-section" claas="warp">';
            _e('<h2>Digital Book Setting  Option</h2>', 'Digital Book');

            echo '<form name="book-form" action=" " method="post">';
            _e('<p><strong>Enter Digital Book Width</strong></p>', 'Digital Book');
            echo '<label for="wpdgtbk-width">Book Width</label>';
            echo '<input type="text" name="wpdgtbk-width" value="' . $wpdgtbk_Option['wpdgtbk-width'] . '"/>' . "\n\r";
            echo 'jQuery Notebook have fix layout so insure that you have custom css and images before change jQuery Notebook width';
            echo "</br>";
            _e('<p><strong>Enter Digital Book Height</strong></p>', 'Digital Book');
            echo '<label for="wpdgtbk-height" >Book Height</label>';
            echo '<input type="text" name="wpdgtbk-height" value="' . $wpdgtbk_Option['wpdgtbk-height'] . '">' . "\n\r";
            echo 'jQuery Notebook have fix layout so insure that you have custom css and images before change jQuery Notebook height';
            echo "</br>";
            _e('<p><strong>Select  Digital Book style</strong></p>', 'Digital Book');
            echo'<label for="wpdgtbk-style">Book Style</label>';
            echo $this->filesInDir(ABSPATH . 'wp-content/plugins/jquery-notebook/css', $wpdgtbk_Option['wpdgtbk-style']) . "\n\r";
            echo "</br>";
            echo "<hr/>";
?>
<?php echo '<label for="wpdgtbk-shadow" >Book Shadow</label>'; ?>
        <select name="wpdgtbk-shadow">
<?php foreach ($this->shadowoption as $key => $value): ?>
                <option value="<?php echo $value; ?>"  <?php echo ($wpdgtbk_Option['wpdgtbk-shadow'] == $value) ? 'selected="selected"' : ''; ?>><?php echo $value; ?></option>
<?php endforeach; ?>
                </select>
<?php echo "</br>"; ?>

<?php echo '<label for="wpdgtbk-overlays" >Book Overlays</label>'; ?>
            <select name="wpdgtbk-overlays">
<?php foreach ($this->overlaysoption as $key => $value): ?>
                    <option value="<?php echo $value; ?>"  <?php echo ($wpdgtbk_Option['wpdgtbk-overlays'] == $value) ? 'selected="selected"' : ''; ?>><?php echo $value; ?></option>
<?php endforeach; ?>
                    </select>
<?php echo "</br>"; ?>

<?php echo '<label for="wpdgtbk-hover" >Book hover</label>'; ?>
                <select name="wpdgtbk-hover">
<?php foreach ($this->hoveroption as $key => $value): ?>
                        <option value="<?php echo $value; ?>"  <?php echo ($wpdgtbk_Option['wpdgtbk-hover'] == $value) ? 'selected="selected"' : ''; ?>><?php echo $value; ?></option>
<?php endforeach; ?>
                        </select>
<?php echo "</br>"; ?>

<?php echo '<label for="wpdgtbk-" >Book keyboard</label>'; ?>
                    <select name="wpdgtbk-keyboard">
<?php foreach ($this->keyboardoption as $key => $value): ?>
                            <option value="<?php echo $value; ?>"  <?php echo ($wpdgtbk_Option['wpdgtbk-keyboard'] == $value) ? 'selected="selected"' : ''; ?>><?php echo $value; ?></option>
<?php endforeach; ?>
                            </select>
<?php echo "</br>"; ?>

<?php echo '<label for="wpdgtbk-cover" >Book Cover</label>'; ?>
                        <select name="wpdgtbk-cover">
<?php foreach ($this->coveroption as $key => $value): ?>
                                <option value="<?php echo $value;
                                ; ?>" <?php echo ($wpdgtbk_Option['wpdgtbk-cover'] == $value) ? 'selected="selected"' : ''; ?>><?php echo $value; ?></option>
<?php endforeach; ?>
                                </select>
    <?php echo "</br>"; ?>

    <?php echo '<label for="wpdgtbk-pageselection" >Book Page selection </label>'; ?>
                            <select name="wpdgtbk-pageselection">
<?php foreach ($this->pageselectinoption as $key => $value): ?>
                                        <option value="<?php echo $value; ?>" <?php echo ($wpdgtbk_Option['wpdgtbk-pageselection'] == $value) ? 'selected="selected"' : ''; ?>><?php echo $value; ?></option>
<?php endforeach; ?>
                                    </select>
    <?php echo "</br>"; ?>

    <?php echo '<label for="wpdgtbk-chapterselection" >Book Chapter Selection </label>'; ?>
                                <select name="wpdgtbk-chapterselection">
<?php foreach ($this->chapterselection as $key => $value): ?>
                                            <option value="<?php echo $value; ?>" <?php echo ($wpdgtbk_Option['wpdgtbk-chapterselection'] == $value) ? 'selected="selected"' : ''; ?>><?php echo $value; ?></option>
<?php endforeach; ?>
                                        </select>
<?php echo "</br>"; ?>

<?php
                                        echo '<p  class="submit"><input type="submit" class="Book-submit" value="save-setting" name="wpdgtbk-setting"/></p>';
                                        echo '</form>';
                                        echo "</div>";
                                        echo "</div>";
                                    }

                                    /*
                                     * list all file   from a dirctory .
                                     *
                                     * @param    path of directry
                                     * @param    current selected directry
                                     * @return   list of all stylesheet file in html select tag
                                     */

                                    function filesInDir($tdir, $chstyle) {
                                        $dirs = scandir($tdir);
                                        // echo "-->".$chstyle;
                                        $style = '<select name="wpdgtbk-style">';
                                        foreach ($dirs as $file) {
                                            if (($file == '.') || ($file == '..')) {
                                                
                                            } elseif (is_dir($tdir . '/' . $file)) {
                                                filesInDir($tdir . '/' . $file);
                                            } else {
                                                $sel = ($chstyle == $file) ? "selected='selected'" : "";
                                                $style .= '<option value="' . $file . '"' . $sel . '>' . $file . '</option>';
                                            }
                                        }
                                        $style .='</select>';
                                        return $style;
                                    }

                                    function bkcdk_print_admin() {

                                        echo "<link  href=\"" . PLUGINPATH . "/wpbkc-admin-css.css\"  type=\"text/css\" rel=\"stylesheet\"/>";
                                    }

                                    /**
                                     *   attached  all  required  css and js file in front end page head section
                                     *   @return    print required  css and js file in font end section
                                     */

                                    function wp_book_jsfile() {
                                        $styleoption = get_option($this->adminDigitalBookSettingOption);
                                        $currentstyle = $styleoption['wpdgtbk-style'];
                                        echo "<link  href=\"" . PLUGINPATH . "/css/$currentstyle\"  type=\"text/css\" rel=\"stylesheet\"/>";                                  
                                        wp_enqueue_script('jQueryEase', PLUGINPATH . '/booklet/jquery.easing.1.3.js', array('jquery'), '2.0', false);
                                        wp_enqueue_script('jQuerybooklet', PLUGINPATH . '/booklet/jquery.booklet.1.1.0.min.js', array('jquery'), '3.0', false);
                                        wp_enqueue_style('jQuerystyle', PLUGINPATH . '/booklet/jquery.booklet.1.1.0.css', '', '1.0', false);                           
                                        wp_enqueue_script('notebookCufon', PLUGINPATH . '/cufon/cufon-yui.js', '', 1.0, false);
                                        wp_enqueue_script('notebookfontFirst', PLUGINPATH . '/cufon/chunkFive_400.font.js', '', 1.0, false);
                                        wp_enqueue_script('notebookfontSecond', PLUGINPATH . '/cufon/Note_this_400.font.js', '', 1.0, false);
                                        wp_enqueue_style('googlefont', 'http://fonts.googleapis.com/css?family=Overlock:400,700,400italic,700italic,900,900italic|Fugaz+One');
                                    }

                                    function wp_book_cufonOption() {
                                        $script = "<script type='text/javascript'>
			 Cufon.replace('.book_wrapper h1,.book_wrapper h2,.book_wrapper p,.book_wrapper .b-counter');
			 Cufon.replace('.book_wrapper a', {hover:true});
			 Cufon.replace('.title', {textShadow: '1px 1px #C59471', fontFamily:'ChunkFive'});
			 Cufon.replace('.reference a', {textShadow: '1px 1px #C59471', fontFamily:'ChunkFive'});
			 Cufon.replace('.loading', {textShadow: '1px 1px #000', fontFamily:'ChunkFive'});
		   </script>";
                                        echo $script;
                                    }
                                     /** end  wp_book_jsfile function **/
                                    /**
                                     * Display  all post form category
                                     *                                    
                                     * @param int $atts
                                     * @param string $content
                                     */

                                    function wp_book_create($atts, $content = null) {
                                        extract(shortcode_atts(array('cat' => '1'), $atts));
                                        $book_post = new WP_Query('cat=' . $cat . 'post_per_page=-1');
                                        echo '<div class="book_wrapper">';                                      
                                        echo '<a id="next_page_button"></a>' . "\n";
                                        echo '<a id="prev_page_button"></a>' . "\n";
                                        echo '<div id="loading" class="loading">Loading pages...</div>' . "\n";
                                        echo '<div id="mybook" style="display:none;">' . "\n";
                                        echo '<div class="b-load">' . "\n";

                                        if ($book_post->have_posts()) : while ($book_post->have_posts()) : $book_post->the_post();
                                                echo '<div>' . "\n";                         
                                                echo '<h2>';
                                                the_title();
                                                echo '</h2>';
                                                the_content();
                                                echo'</div>' . "\n";

                                            endwhile;
                                        else :
                                            echo '<div> Sorry no content</div>';
                                        endif;
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '<div>';
                                        echo '<span class="reference">';
                                        echo '<a href="http://bineetchaubey.com">Wordpress Magic</a>';
                                        echo '</span>';
                                        echo '</div>';
                                    }

                                    function wp_book_jsoption() {
                                        $jsOption = $this->getAdmindigitalBookOption();
?>   
                                        <script type="text/javascript">
                                            jQuery(function() {
                                                var $mybook 		= jQuery('#mybook');
                                                var $bttn_next		= jQuery('#next_page_button');
                                                var $bttn_prev		= jQuery('#prev_page_button');
                                                var $loading		= jQuery('#loading');                                               
                                                var loaded			= 0;                                              
                                                $loading.hide();
                                                $bttn_next.show();
                                                $bttn_prev.show();                                              
                                                $mybook.show().booklet({
                                                    name:               null,                            // name of the booklet to display in the document title bar
                                                    width:              800,                             // container width
                                                    height:             500,                             // container height
                                                    speed:              600,                             // speed of the transition between pages
                                                    direction:          'LTR',                           // direction of the overall content organization, default LTR, left to right, can be RTL for languages which read right to left
                                                    startingPage:       0,                               // index of the first page to be displayed
                                                    easing:             'easeInOutQuad',                 // easing method for complete transition
                                                    easeIn:             'easeInQuad',                    // easing method for first half of transition
                                                    easeOut:            'easeOutQuad',                   // easing method for second half of transition

                                                    closed:             true,                           // start with the book "closed", will add empty pages to beginning and end of book
                                                    closedFrontTitle:   null,                            // used with "closed", "menu" and "pageSelector", determines title of blank starting page
                                                    closedFrontChapter: null,                            // used with "closed", "menu" and "chapterSelector", determines chapter name of blank starting page
                                                    closedBackTitle:    null,                            // used with "closed", "menu" and "pageSelector", determines chapter name of blank ending page
                                                    closedBackChapter:  null,                            // used with "closed", "menu" and "chapterSelector", determines chapter name of blank ending page
                                                    covers:             <?php echo $jsOption['wpdgtbk-cover']; ?>, // used with  "closed", makes first and last pages into covers, without page numbers (if enabled)

                                                    pagePadding:        10,                              // padding for each page wrapper
                                                    pageNumbers:        true,                            // display page numbers on each page

                                                    hovers:             <?php echo $jsOption['wpdgtbk-hover']; ?>, // enables preview pageturn hover animation, shows a small preview of previous or next page on hover
                                                    overlays:           <?php echo $jsOption['wpdgtbk-overlays']; ?>, // enables navigation using a page sized overlay, when enabled links inside the content will not be clickable
                                                    tabs:               false,                           // adds tabs along the top of the pages
                                                    tabWidth:           60,                              // set the width of the tabs
                                                    tabHeight:          20,                              // set the height of the tabs
                                                    arrows:             false,                           // adds arrows overlayed over the book edges
                                                    cursor:             'pointer',                       // cursor css setting for side bar areas

                                                    hash:               false,                           // enables navigation using a hash string, ex: #/page/1 for page 1, will affect all booklets with 'hash' enabled
                                                    keyboard:           <?php echo $jsOption['wpdgtbk-keyboard']; ?>, // enables navigation with arrow keys (left: previous, right: next)
                                                    next:               $bttn_next,          			// selector for element to use as click trigger for next page
                                                    prev:               $bttn_prev,          			// selector for element to use as click trigger for previous page

                                                    menu:               null,                            // selector for element to use as the menu area, required for 'pageSelector'
                                                    pageSelector:     <?php echo $jsOption['wpdgtbk-pageselection']; ?>, // enables navigation with a dropdown menu of pages, requires 'menu'
                                                    chapterSelector:   <?php echo $jsOption['wpdgtbk-chapterselection']; ?>,// enables navigation with a dropdown menu of chapters, determined by the "rel" attribute, requires 'menu'

                                                    shadows:            true,                            // display shadows on page animations
                                                    shadowTopFwdWidth:  166,                             // shadow width for top forward anim
                                                    shadowTopBackWidth: 166,                             // shadow width for top back anim
                                                    shadowBtmWidth:     50,                              // shadow width for bottom shadow

                                                    before:             function(){},                    // callback invoked before each page turn animation
                                                    after:              function(){}

                                                });


                                            });
                                        </script>

<?php
                                    }
                                }                              
                            }   /** end  class exists  condition wp book **/


                            if (class_exists("wpbineetdigitalbook")) {
                                $wpDigitaBook = new wpbineetdigitalbook();
                            }
                            if (!function_exists('wpdigitalbookpluginsetting')) {
                                function wpdigitalbookpluginsetting() {
                                    global $wpDigitaBook;
                                    if (function_exists('add_options_page')) {
                                        add_options_page('wordpres jQuery Notebook', 'jQuery Notebook', 9, basename(__FILE__), array(&$wpDigitaBook, 'wp_digital_printpage'));
                                    }
                                }
                            }

                            if (isset($wpDigitaBook)) {
                                add_action('admin_menu', 'wpdigitalbookpluginsetting');
                                add_action('activate_digitalbook/digital-book.php', array(&$wpDigitaBook, 'init'));
                                add_action('init', array(&$wpDigitaBook, 'wp_book_jsfile'));
                                add_shortcode('jqnotebook', array(&$wpDigitaBook, 'wp_book_create'));
                                add_action('wp_footer', array(&$wpDigitaBook, 'wp_book_jsoption'));
                                add_action('admin_head', array(&$wpDigitaBook, 'bkcdk_print_admin'));
                            }
?>