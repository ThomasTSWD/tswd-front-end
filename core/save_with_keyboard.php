<?php
if (is_admin() && ! function_exists('save_with_keyboard_enqueue')) {
    function save_with_keyboard_enqueue() {
        // Register the script
        wp_register_script('swk_js', plugin_dir_url(__FILE__) . '/dist/saveWithKeyboard' . (WP_DEBUG ? '' : '.min') . '.js', array('jquery'), '3.0.2');

        // Localize the script with new data
        $translationArray = array(
            'tooltipText' => __( 'Press $SHORTCUT$ to click', 'save-with-keyboard' )
        );
        wp_localize_script('swk_js', 'SaveWithKeyboard', $translationArray);

        // Enqueued script with localized data.
        wp_enqueue_script('swk_js');
    }

    add_action('admin_enqueue_scripts', 'save_with_keyboard_enqueue');
}
?>