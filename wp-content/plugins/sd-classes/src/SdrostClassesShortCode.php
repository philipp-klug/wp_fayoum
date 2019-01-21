<?php

/**
 * SdrostClassesShortCode.php
 *
 * @author Stefanie Drost <contact@stefaniedrost.com>
 */
class SdrostClassesShortCode
{

    public function getSdrostClassesShortCode($attributes)
    {
        wp_enqueue_style( 'sdrost-classes-css', plugins_url( '/assets/css/sdrost_classes.css', SDROST_CLASSES_ASSETS_DIR));
        // Attributes
        extract(shortcode_atts(array( 'class' => 1), $attributes));

        $shortWeekDayOption = esc_attr( get_option( 'sdrost_classes_shortcode_short_weekday') );
        $showWeekendOption = esc_attr( get_option( 'sdrost_classes_shortcode_show_weekend') );
        $groupByLocation = esc_attr( get_option( 'sdrost_classes_shortcode_sort_by_location') );
        $maxDays = 7;

        if (boolval($groupByLocation)) {
            $classesDataArray = SdrostClassPostType::getClassesByClassType($class, true);
        }
        else {
            $classesDataArray = SdrostClassPostType::getClassesByClassType($class);
        }

        if (!boolval($showWeekendOption)) {
            $maxDays = 5;
        }


        $markup = '';
        $markup .= SdrostClassRenderer::getStyleHtml(get_option( 'sdrost_classes_shortcode_color'));
        for ($i = 0; $i < $maxDays; $i++) {
            $currentPlace = '';

            if (!isset($classesDataArray[$i])) {
                $day = $this->getDayByIndex($i, $shortWeekDayOption);
                $markup .= SdrostClassRenderer::getEmptyClassWeekdayTableHtml($day);
            }
            else {
                $markup .= '<div class="classesWeekDay">' . $this->getDayByData($classesDataArray[$i][0], $shortWeekDayOption) . '</div><br/>';

                foreach ($classesDataArray[$i] as $data) {
                    if ($groupByLocation && $currentPlace != $data['place']) {
                        $showPlace = true;
                    }
                    elseif($groupByLocation && $currentPlace == $data['place']) {
                        $showPlace = false;
                    }
                    else {
                        $showPlace = true;
                    }

                    $classObject = new SdrostClass();
                    $day = $this->getDayByData($data, $shortWeekDayOption);

                    $classObject->setDay($day)
                        ->setBegin($data['begin'])
                        ->setEnd($data['end'])
                        ->setNote($data['note'])
                        ->setPlace($data['place'])
                        ->setAddress($data['address'])
                        ->setTrainer($data['trainer'])
                        ->setGoogleMapUrl($data['googleMap']);

                    $currentPlace = $data['place'];

                    $markup .= SdrostClassRenderer::getClassWeekdayTableHtml($classObject, $showPlace);
                }
            }
        }

        return $markup;
    }


    private function getDayByIndex($dayIndex, $shortWeekDayOption)
    {
        $longDayTable = ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonnabend'];
        $shortDayTable = ['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'];

        if ($shortWeekDayOption) {
            return $shortDayTable[$dayIndex];
        }

        return $longDayTable[$dayIndex];
    }


    private function getDayByData($data, $shortWeekDayOption)
    {
        if ($shortWeekDayOption) {
            return substr($data['day'], 0, 2);
        }

        return $data['day'];
    }
}