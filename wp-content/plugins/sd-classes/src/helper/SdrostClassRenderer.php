<?php
/**
 * SdrostClassRenderernderer.php
 *
 * @author Stefanie Drost <contact@stefaniedrost.com>
 */
class SdrostClassRenderer
{

    /**
     * @param SdrostClass $class
     * @return string
     */
    public static function getClassWeekdayTableHtml(SdrostClass $class, $showLocation = true): string
    {
        $begin = $class->getBegin();
        $end = $class->getEnd();
        $classNote = ($class->getNote()) ? $class->getNote() .'<br/><br/>' : '';
        $place = $class->getPlace();
        $trainerString = '';
        $allTrainer = $class->getTrainer();
        foreach ($allTrainer as $key => $trainerData) {
            $trainerString .= $trainerData['name'] . ' & ';
        }
        $trainerString = $new_str = preg_replace('/& $/', '', $trainerString);

        if ($showLocation) {
            $address = $class->getAddress();
            $googleMapUrl = $class->getGoogleMapUrl();
            $googleLink = ($googleMapUrl) ? '<a title="Link zum Trainingsort ' . $place. '" href="' . $googleMapUrl. '" target="_blank" rel="noopener noreferrer">Map ansehen</a>' : '';
            $addressBox = self::getAddressBox($address, $googleLink);
        }
        else {
            $addressBox = '';
            $place = '';
        }

        return <<<EOT
<table class="classes-table">
    <tbody>
        <tr>
            <td>
                <div class="classesTime"><strong>$begin bis $end </strong></div></td>
            <td><strong>$place</strong></td>
        </tr>
        <tr class="content-row">
            <td>
            $classNote
            <strong>Trainer</strong><br/>
                $trainerString
            </td>
            <td>$addressBox</td>
        </tr>
    </tbody>
</table>
EOT;
    }

    private static function getAddressBox($address, $googleLink)
    {
        return <<<EOT
$address<br/><br/>$googleLink<br/><br/>
EOT;
    }

    /**
     * @param $day
     * @return string
     */
    public static function getEmptyClassWeekdayTableHtml($day): string
    {
        return <<<EOT
<div class="classesWeekDay">$day</div>
    <div class="classes-table-empty">
        <br class="none"><strong>-</strong><br class="none"><br class="none">
    </div>
EOT;
    }


    /**
     * @param $color
     * @return string
     */
    public static function getStyleHtml($color): string
    {
        return <<<EOT
<style>
.classesWeekDay{
    background-color: $color;
}
</style>
EOT;
    }

}