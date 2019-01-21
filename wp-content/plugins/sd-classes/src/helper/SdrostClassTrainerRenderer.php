<?php
/**
 * SdrostClassTrainerRenderer.php
 *
 * @author Stefanie Drost <contact@stefaniedrost.com>
 */
class SdrostClassTrainerRenderer
{

    /**
     * @param SdrostClassTrainer $trainer
     * @return string
     */
    public static function getTrainerForm(SdrostClassTrainer $trainer): string
    {
        $firstName = $trainer->getFirstName();
        $lastName = $trainer->getLastName();


        return <<<EOT
<form method="post">
    <label for="sdrost_class_trainer_firstname_data">Vorname*:</label><br/>
    <input type='text' id='sdrost_class_trainer_firstname_data' value="$firstName" name='sdrost_class_trainer_firstname_data'>
    <br/><br/>

    <label for="sdrost_class_trainer_lastname_data">Nachname*:</label><br/>
    <input type='text' id='sdrost_class_trainer_lastname_data' value="$lastName" name='sdrost_class_trainer_lastname_data'>
    <br/><br/>
</form>
EOT;
    }

}