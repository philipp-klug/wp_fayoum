<?php
/**
 * SdrostClassesOptionPage.php
 *
 * @author Stefanie Drost <contact@stefaniedrost.com>
 */
class SdrostClassesOptionPage
{

    const SDROST_DEFAULT_COLOR = '#960f1e';
    const SDROST_DEFAULT_SHORT_WEEKDAY = 1;
    const SDROST_DEFAULT_SHOW_WEEKEND = 1;
    const SDROST_DEFAULT_SORT_BY_LOCATION = 0;

    public function registerSdrostClassesSettings()
    {
        add_option( 'sdrost_classes_shortcode_color', self::SDROST_DEFAULT_COLOR);
        add_option( 'sdrost_classes_shortcode_short_weekday', self::SDROST_DEFAULT_SHORT_WEEKDAY);
        add_option( 'sdrost_classes_shortcode_show_weekend', self::SDROST_DEFAULT_SHOW_WEEKEND);
        add_option( 'sdrost_classes_shortcode_sort_by_location', self::SDROST_DEFAULT_SORT_BY_LOCATION);

        register_setting( 'sdrost_classes_options_group', 'sdrost_classes_shortcode_color', 'sdrost_classes_callback' );
        register_setting( 'sdrost_classes_options_group', 'sdrost_classes_shortcode_short_weekday', 'sdrost_classes_callback' );
        register_setting( 'sdrost_classes_options_group', 'sdrost_classes_shortcode_show_weekend', 'sdrost_classes_callback' );
        register_setting( 'sdrost_classes_options_group', 'sdrost_classes_shortcode_sort_by_location', 'sdrost_classes_callback' );
    }


    public function registerSdrostClassesOptionPage()
    {
        add_options_page(SDROST_CLASSES_PLUGIN_NAME . ' Settings', SDROST_CLASSES_PLUGIN_NAME, 'manage_options', 'sdrost_classes', array( new SdrostClassesOptionPage(), 'getSdrostClassesOptionsPage'));
    }


    public function getSdrostClassesOptionsPage()
    {
        ?>
        <div class="wrap">
            <h1>SDrost Classes Einstellungen</h1>
            <form method="post" action="options.php">
                <?php settings_fields( 'sdrost_classes_options_group' ); ?>
                <table class="form-table">
                    <tbody>
                    <tr>
                        <th scope="row">
                            <label for="sdrost_classes_shortcode_color">Farbe für Kursübersicht</label>
                        </th>
                        <td>
                            <input type="text" id="sdrost_classes_shortcode_color" name="sdrost_classes_shortcode_color" class="color-field"
                                   value="<?php echo esc_attr( get_option( 'sdrost_classes_shortcode_color' ) );  ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="sdrost_classes_shortcode_short_weekday">Wochentage abkürzen</label>
                        </th>
                        <td>
                            <input type="checkbox" id="sdrost_classes_shortcode_short_weekday" name="sdrost_classes_shortcode_short_weekday"
                                   value="1" <?php if (get_option( 'sdrost_classes_shortcode_short_weekday' ) ) echo 'checked'  ?> />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="sdrost_classes_shortcode_short_weekday">Wochenende anzeigen</label>
                        </th>
                        <td>
                            <input type="checkbox" id="sdrost_classes_shortcode_show_weekend" name="sdrost_classes_shortcode_show_weekend"
                                   value="1" <?php if (get_option( 'sdrost_classes_shortcode_show_weekend' ) ) echo 'checked'  ?> />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="sdrost_classes_shortcode_sort_by_location">Termine nach Ort gruppieren</label>
                        </th>
                        <td>
                            <input type="checkbox" id="sdrost_classes_shortcode_sort_by_location" name="sdrost_classes_shortcode_sort_by_location"
                                   value="1" <?php if (get_option( 'sdrost_classes_shortcode_sort_by_location' ) ) echo 'checked'  ?> />
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }


    public static function delete()
    {
        delete_option( 'sdrost_classes_shortcode_color' );
        delete_option( 'sdrost_classes_shortcode_short_weekday' );
        delete_option( 'sdrost_classes_shortcode_show_weekend' );
        delete_option( 'sdrost_classes_shortcode_sort_by_location' );
        unregister_setting( 'sdrost_classes_options_group', 'sdrost_classes_shortcode_color', 'sdrost_classes_callback' );
        unregister_setting( 'sdrost_classes_options_group', 'sdrost_classes_shortcode_short_weekday', 'sdrost_classes_callback' );
        unregister_setting( 'sdrost_classes_options_group', 'sdrost_classes_shortcode_show_weekend', 'sdrost_classes_callback' );
        unregister_setting( 'sdrost_classes_options_group', 'sdrost_classes_shortcode_sort_by_location', 'sdrost_classes_callback' );
    }

}