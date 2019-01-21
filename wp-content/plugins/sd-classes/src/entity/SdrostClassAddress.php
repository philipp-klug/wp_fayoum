<?php
/**
 * SdrostClassAddress.php
 *
 * @author Stefanie Drost <contact@stefaniedrost.com>
 */
class SdrostClassAddress
{
    const ADDRESS_STREET_COLUMN_KEY = 'sdrost_class_address_street';
    const ADDRESS_ZIP_COLUMN_KEY = 'sdrost_class_address_zipcode';
    const ADDRESS_CITY_COLUMN_KEY = 'sdrost_class_address_city';
    const ADDRESS_DISTRICT_COLUMN_KEY = 'sdrost_class_address_district';
    const ADDRESS_ADDITIONAL_COLUMN_KEY = 'sdrost_class_address_additional';
    const ADDRESS_GOOGLE_MAP_COLUMN_KEY = 'sdrost_class_address_google_map';

    /**
     * @var string
     */
    private $street;
    private $zipCode;
    private $city;
    private $district;
    private $additional;
    private $googleMap;

    public function __construct($post)
    {
        $this->setStreet(get_post_meta( $post->ID, self::ADDRESS_STREET_COLUMN_KEY . '_data', true ));
        $this->setZipCode(get_post_meta( $post->ID, self::ADDRESS_ZIP_COLUMN_KEY . '_data', true ));
        $this->setCity(get_post_meta( $post->ID, self::ADDRESS_CITY_COLUMN_KEY . '_data', true ));
        $this->setDistrict(get_post_meta( $post->ID, self::ADDRESS_DISTRICT_COLUMN_KEY . '_data', true ));
        $this->setAdditional(get_post_meta( $post->ID, self::ADDRESS_ADDITIONAL_COLUMN_KEY . '_data', true ));
        $this->setGoogleMap(get_post_meta( $post->ID, self::ADDRESS_GOOGLE_MAP_COLUMN_KEY . '_data', true ));
    }


    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     * @return $this
     */
    public function setStreet($street): SdrostClassAddress
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     * @return $this
     */
    public function setZipCode($zipCode): SdrostClassAddress
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity($city): SdrostClassAddress
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getDistrict(): string
    {
        return $this->district;
    }

    /**
     * @param string $district
     * @return $this
     */
    public function setDistrict($district): SdrostClassAddress
    {
        $this->district = $district;

        return $this;
    }

    /**
     * @return string
     */
    public function getAdditional(): string
    {
        return $this->additional;
    }

    /**
     * @param string $additional
     * @return $this
     */
    public function setAdditional($additional): SdrostClassAddress
    {
        $this->additional = $additional;

        return $this;
    }

    /**
     * @return string
     */
    public function getGoogleMap(): string
    {
        return $this->googleMap;
    }

    /**
     * @param string $googleMap
     * @return $this
     */
    public function setGoogleMap($googleMap): SdrostClassAddress
    {
        $this->googleMap = $googleMap;

        return $this;
    }


}