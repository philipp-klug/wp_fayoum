<?php

/**
 * SdrostClassPostType.php
 *
 * @author Stefanie Drost <contact@stefaniedrost.com>
 */
class SdrostClassPostType extends SdrostClassBasePostType
{
    const CLASS_BEGIN_COLUMN_KEY = 'sdrost_class_begin';
    const CLASS_END_COLUMN_KEY = 'sdrost_class_end';
    const CLASS_DAY_COLUMN_KEY = 'sdrost_class_day';
    const CLASS_NOTE_COLUMN_KEY = 'sdrost_class_note';
    const CLASS_TRAINER_COLUMN_KEY = 'sdrost_class_trainer';
    const CLASS_ADDRESS_COLUMN_KEY = 'sdrost_class_address';
    const CLASS_CLASS_COLUMN_KEY = 'sdrost_class_class';
    const CLASS_WEEKDAY_PRIORITY_COLUMN_KEY = 'sdrost_class_weekday_priority';

    /** @var array  */
    private $weekdayPriorities = [
        'Montag' => 0,
        'Dienstag' => 1,
        'Mittwoch' => 2,
        'Donnerstag' => 3,
        'Freitag' => 4,
        'Samstag' => 5,
        'Sonntag' => 6,
    ];

    public function create()
    {
        $supports = array ( 'title' );
        register_post_type(
            self::SDROST_CLASSES_POST_TYPE,
            array(
                'labels' => array(
                    'name' => 'Kurse',
                    'singular_name' => 'Kurs',
                    'add_new' => 'Neuer Kurs',
                    'add_new_item' => 'Kurs hinzufügen',
                    'edit_item' => 'Kurs bearbeiten',
                    'new_item' => 'Neuer Kurs',
                    'all_items' => 'Alle Kurse',
                    'view_item' => 'Kurse ansehen',
                    'search_items' => 'Kurse suchen',
                    'not_found' =>  'Keine Kurse gefunden',
                    'not_found_in_trash' => 'Keine gelöschten Kurse gefunden',
                    'parent_item_colon' => '',
                    'menu_name' => 'Kurse',
                ),
                'supports' => $supports,
                'exclude_from_search' => true,
                'rewrite' => array( 'slug' => 'classes' ),
                'public' => true,
                'menu_position' => 30,
                'has_archive' => false,
                'menu_icon' => 'dashicons-calendar-alt',
                'register_meta_box_cb' => array(SdrostClassPostType::class, 'addSdrostClassesBox' ),
            )
        );
    }


    public function setGridColumnsForSdrostClass($columns)
    {
        $date = $columns['date'];
        unset($columns['date']);
        $columns[self::CLASS_BEGIN_COLUMN_KEY] = 'Beginn';
        $columns[self::CLASS_END_COLUMN_KEY] = 'Ende';
        $columns[self::CLASS_DAY_COLUMN_KEY] = 'Tag';
        $columns[self::CLASS_TRAINER_COLUMN_KEY] = 'Trainer';
        $columns[self::CLASS_CLASS_COLUMN_KEY] = 'Kurs';
        $columns['date'] = $date;

        return $columns;
    }


    public function addSdrostClassesBox()
    {
        add_meta_box( 'sdrostClasses_box','Kurs Daten',array(SdrostClassPostType::class, 'createSdrostClassDataBox' ),
            self::SDROST_CLASSES_POST_TYPE,'normal','high' );
        remove_meta_box( 'wp-editor', self::SDROST_CLASSES_POST_TYPE, 'normal' );
    }


    public function createSdrostClassDataBox($post)
    {
        global $post;

        wp_enqueue_style( 'bootstrap-min-css', plugins_url( '/assets/css/bootstrap.min.css', SDROST_CLASSES_ASSETS_DIR));
        wp_enqueue_style( 'github-min-css', plugins_url( '/assets/css/github.min.css', SDROST_CLASSES_ASSETS_DIR));
        wp_enqueue_style( 'clockpicker-css', plugins_url( '/assets/css/jquery-clockpicker.min.css', SDROST_CLASSES_ASSETS_DIR));
        wp_enqueue_style( 'bootstrap-clockpicker-css', plugins_url( '/assets/css/bootstrap-clockpicker.min.css', SDROST_CLASSES_ASSETS_DIR));
        wp_enqueue_style( 'sdrost-classes-admin-css', plugins_url( '/assets/css/sdrost_classes_admin.css', SDROST_CLASSES_ASSETS_DIR));

        wp_enqueue_script( 'bootstrap-min-js', plugins_url( '/assets/js/bootstrap.min.js', SDROST_CLASSES_ASSETS_DIR ));
        wp_enqueue_script( 'clockpicker-js', plugins_url( '/assets/js/jquery-clockpicker.min.js', SDROST_CLASSES_ASSETS_DIR ));
        wp_enqueue_script( 'sdrost-classes-js', plugins_url( '/assets/js/sdrost-classes.js', SDROST_CLASSES_ASSETS_DIR ));

        //wp_enqueue_media( 'sdrost-classes-js', plugins_url( '/assets/img/add.png', SDROST_CLASSES_ASSETS_DIR ));

        $pageTitles = self::getPageTitles();
        $trainers = self::getTrainers();
        $addresses = self::getAddresses();

        self::createWpOnceFields([
            self::CLASS_BEGIN_COLUMN_KEY,
            self::CLASS_END_COLUMN_KEY,
            self::CLASS_NOTE_COLUMN_KEY,
            self::CLASS_ADDRESS_COLUMN_KEY,
            self::CLASS_TRAINER_COLUMN_KEY,
            self::CLASS_DAY_COLUMN_KEY,
            self::CLASS_CLASS_COLUMN_KEY,
            self::CLASS_WEEKDAY_PRIORITY_COLUMN_KEY
        ]);

        $begin = get_post_meta( $post->ID, 'sdrost_class_begin_data', true );
        $end = get_post_meta( $post->ID, 'sdrost_class_end_data', true );
        $note = get_post_meta( $post->ID, self::CLASS_NOTE_COLUMN_KEY . '_data', true );
        $address = get_post_meta( $post->ID, self::CLASS_ADDRESS_COLUMN_KEY . '_data', true );
        $trainerData = get_post_meta( $post->ID, self::CLASS_TRAINER_COLUMN_KEY . '_data', true );
        $day = get_post_meta( $post->ID, self::CLASS_DAY_COLUMN_KEY . '_data', true );
        $class = get_post_meta( $post->ID, self::CLASS_CLASS_COLUMN_KEY . '_data', true );
        $weekdayPriority = get_post_meta( $post->ID, 'sdrost_class_weekday_priority_data', true );

        ?>
        <form method="post" class="sdrost-classes-form">
            <label for="sdrost_class_day">Wochentag:</label><br/>
            <select name="sdrost_class_day_data" id='sdrost_class_day_data'>
                <option value="Montag" <?php if($day == 'Montag') echo 'selected'?> >Montag</option>
                <option value="Dienstag" <?php if($day == 'Dienstag') echo 'selected'?> >Dienstag</option>
                <option value="Mittwoch" <?php if($day == 'Mittwoch') echo 'selected'?> >Mittwoch</option>
                <option value="Donnerstag" <?php if($day == 'Donnerstag') echo 'selected'?> >Donnerstag</option>
                <option value="Freitag" <?php if($day == 'Freitag') echo 'selected'?> >Freitag</option>
                <option value="Samstag" <?php if($day == 'Samstag') echo 'selected'?> >Samstag</option>
                <option value="Sonntag" <?php if($day == 'Sonntag') echo 'selected'?> >Sonntag</option>
            </select><br/><br/>

            <label for="sdrost_class_begin">Kursbeginn:</label><br/>
            <div class="input-group clockpicker">
                <input type="text" id='sdrost_class_begin_data' name='sdrost_class_begin_data' class="form-control" value="<?php echo $begin; ?>">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div><br/>

            <label for="sdrost_class_begin">Kursende:</label><br/>
            <div class="input-group clockpicker">
                <input type="text" id='sdrost_class_end_data' name='sdrost_class_end_data' class="form-control" value="<?php echo $end; ?>">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div><br/>

            <label for="sdrost_class_note">Kursnotiz:</label><br/>
            <input type='text' id='sdrost_class_note_data' value="<?php echo $note; ?>" name='sdrost_class_note_data'><br/><br/>

            <label for="sdrost_class_address_data">Addresse:</label><br/>
            <select name="sdrost_class_address_data" id='sdrost_class_address_data'>
                <?php
                foreach ($addresses as $addressId => $addressData) {
                    echo '<option value="' . $addressId . '"';
                    if($addressId == $address) echo ' selected';
                    echo '>' . $addressData . '</option>';
                }
                ?>
            </select><br/><br/>

            <label for="sdrost_class_type">Kurs</label><br/>
            <select name="sdrost_class_class_data" id="sdrost_class_class_data">
                <?php
                foreach ($pageTitles as $classData) {
                    echo '<option value="' . $classData . '"';
                    if($classData == $class) echo ' selected';
                    echo '>' . $classData . '</option>';
                }
                ?>
            </select><br/><br/>

            <label for="sdrost_class_trainer">Trainer:</label><br/>

            <?php if (empty($trainerData)) { ?>
            <div class="sdrost_class_trainer_fieldset">
                <select id="sdrost_class_trainer_data" name="sdrost_class_trainer_data[]" >
                    <?php
                    foreach ($trainers as $key => $trainerTitle) {
                        echo '<option value="' . $key . '"';
                        if($classData == $class) echo ' selected';
                        echo '>' . $trainerTitle . '</option>';
                    }
                    ?>
                </select>
                <button type="button" class="add-button"></button>
            </div>
            <?php } else {
                foreach ($trainerData as $trainer) { ?>
                    <div class="sdrost_class_trainer_fieldset">
                        <select id="sdrost_class_trainer_data" name="sdrost_class_trainer_data[]" >
                            <?php
                            foreach ($trainers as $key => $trainerTitle) {

                                echo '<option value="' . $key . '"';
                                if($key == $trainer) echo ' selected';
                                echo '>' . $trainerTitle . '</option>';
                            }
                            ?>
                        </select>
                        <button type="button" class="add-button"></button>
                    </div>
                <?php }
             } ?>

            <input type='hidden' id='sdrost_class_weekday_priority_data' value="<?php echo $weekdayPriority; ?>" name='sdrost_class_weekday_priority_data'>
        </form>
        <?php
    }


    public function saveSdrostClassesMeta($post_id, $post)
    {
        // Return if the user doesn't have edit permissions.
        if (!current_user_can( 'edit_post', $post_id)) {
            return $post_id;
        }

        $valid = self::verifyPostData([
            self::CLASS_BEGIN_COLUMN_KEY,
            self::CLASS_END_COLUMN_KEY,
            self::CLASS_NOTE_COLUMN_KEY,
            self::CLASS_DAY_COLUMN_KEY,
            self::CLASS_ADDRESS_COLUMN_KEY,
            self::CLASS_CLASS_COLUMN_KEY,
            self::CLASS_TRAINER_COLUMN_KEY,
            self::CLASS_WEEKDAY_PRIORITY_COLUMN_KEY
        ]);

        if (!$valid) {
            return $post_id;
        }

        // Now that we're authenticated, time to save the data.
        // This sanitizes the data from the field and saves it into an array $events_meta.
        $classesMeta = self::fillMetaDataByPostValues([
            self::CLASS_BEGIN_COLUMN_KEY . '_data',
            self::CLASS_END_COLUMN_KEY . '_data',
            self::CLASS_NOTE_COLUMN_KEY . '_data',
            self::CLASS_DAY_COLUMN_KEY . '_data',
            self::CLASS_ADDRESS_COLUMN_KEY . '_data',
            self::CLASS_CLASS_COLUMN_KEY . '_data',
        ]);
        $classesMeta['sdrost_class_weekday_priority_data'] = $this->weekdayPriorities[$_POST['sdrost_class_day_data']];

        $trainers = $_POST[self::CLASS_TRAINER_COLUMN_KEY . '_data'];
        $trainerData = [];
        foreach ($trainers as $id) {
            $trainerData[] = SdrostClassBasePostType::getTrainerById($id);
        }

        $classesMeta[self::CLASS_TRAINER_COLUMN_KEY . '_data'] = $trainerData;

        return self::savePostWithMeta($post_id, $post, $classesMeta);
    }


    public static function deletePosts()
    {
        $args = array (
            'post_type' => self::SDROST_CLASSES_POST_TYPE,
            'nopaging' => true
        );
        $query = new WP_Query ($args);
        while ($query->have_posts ()) {
            $query->the_post ();
            $id = get_the_ID ();
            wp_delete_post ($id, true);
        }
        wp_reset_postdata ();
    }
}