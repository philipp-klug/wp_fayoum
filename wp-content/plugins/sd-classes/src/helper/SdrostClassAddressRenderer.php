<?php
/**
 * SdrostClassAddressRenderer.php
 *
 * @author Stefanie Drost <contact@stefaniedrost.com>
 */
class SdrostClassAddressRenderer
{

    /**
     * @param SdrostClassAddress $address
     * @return string
     */
    public static function getAddressForm(SdrostClassAddress $address): string
    {
        $street = $address->getStreet();
        $zipCode = $address->getZipCode();
        $city = $address->getCity();
        $additional = $address->getAdditional();
        $district = $address->getDistrict();
        $googleMap = $address->getGoogleMap();


        return <<<EOT
<form method="post">
    <label for="sdrost_class_address_street_data">Straße*:</label><br/>
    <input type='text' id='sdrost_class_address_street_data' value="$street" name='sdrost_class_address_street_data'>
    <br/><br/>

    <label for="sdrost_class_address_zipcode_data">PLZ*:</label><br/>
    <input type='text' id='sdrost_class_address_zipcode_data' value="$zipCode" name='sdrost_class_address_zipcode_data'>
    <br/><br/>

    <label for="sdrost_class_address_city_data">Stadt*:</label><br/>
    <input type='text' id='sdrost_class_address_city_data' value="$city" name='sdrost_class_address_city_data'>
    <br/><br/>

    <label for="sdrost_class_address_additional_data">Zusatz Information:</label><br/>
    <input type='text' id='sdrost_class_address_additional_data' value="$additional" name='sdrost_class_address_additional_data'>
    <br/><br/>

    <label for="sdrost_class_address_district_data">Bezirk*:</label><br/>
    <input type='text' id='sdrost_class_address_district_data' value="$district" name='sdrost_class_address_district_data'>
    <br/><br/>

    <label for="sdrost_class_address_google_map_data">Google Map Link:</label><br/>
    <textarea rows="4" cols="50" id='sdrost_class_address_google_map_data' name='sdrost_class_address_google_map_data'>$googleMap</textarea>
    <br/><br/>
</form>
EOT;
    }

}