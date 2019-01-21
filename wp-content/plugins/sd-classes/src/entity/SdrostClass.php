<?php
/**
 * SdrostClass.php
 *
 * @author Stefanie Drost <contact@stefaniedrost.com>
 */
class SdrostClass
{
    /**
     * @var string
     */
    private $begin;
    private $place;
    private $end;
    private $googleMapUrl;
    private $day;
    private $address;
    private $note;

    /**
     * @var array
     */
    private $trainer = [];

    /**
     * @return string
     */
    public function getDay(): string
    {
        return $this->day;
    }

    /**
     * @param string $day
     * @return $this
     */
    public function setDay($day): SdrostClass
    {
        $this->day = $day;

        return $this;
    }

    /**
     * @return array
     */
    public function getTrainer(): array
    {
        return $this->trainer;
    }

    /**
     * @param array $trainer
     * @return $this
     */
    public function setTrainer(array $trainer): SdrostClass
    {
        $this->trainer = $trainer;

        return $this;
    }

    /**
     * @return string
     */
    public function getGoogleMapUrl(): string
    {
        return $this->googleMapUrl;
    }

    /**
     * @param string $googleMapUrl
     * @return $this
     */
    public function setGoogleMapUrl($googleMapUrl): SdrostClass
    {
        $this->googleMapUrl = $googleMapUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getBegin(): string
    {
        return $this->begin;
    }

    /**
     * @param string $begin
     * @return $this
     */
    public function setBegin($begin): SdrostClass
    {
        $this->begin = $begin;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param string $place
     * @return $this
     */
    public function setPlace($place): SdrostClass
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setAddress($address): SdrostClass
    {
        $this->address = $address;

        return $this;
    }


    /**
     * @param string $end
     * @return $this
     */
    public function setEnd($end): SdrostClass
    {
        $this->end = $end;

        return $this;
    }


    /**
     * @return string
     */
    public function getEnd(): string
    {
        return $this->end;
    }


    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }


    /**
     * @return string
     */
    public function getNote(): string
    {
        return $this->note;
    }


    /**
     * @param string $note
     * @return $this
     */
    public function setNote($note): SdrostClass
    {
        $this->note = $note;

        return $this;
    }
}