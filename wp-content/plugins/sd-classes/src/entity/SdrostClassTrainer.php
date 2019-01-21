<?php
/**
 * SdrostClassTrainer.php
 *
 * @author Stefanie Drost <contact@stefaniedrost.com>
 */
class SdrostClassTrainer
{
    const TRAINER_FIRST_NAME = 'sdrost_class_trainer_firstname';
    const TRAINER_LAST_NAME = 'sdrost_class_trainer_lastname';

    /**
     * @var string
     */
    private $firstName;
    private $lastName;

    public function __construct($post)
    {
        $this->setFirstName(get_post_meta( $post->ID, self::TRAINER_FIRST_NAME . '_data', true ));
        $this->setLastName(get_post_meta( $post->ID, self::TRAINER_LAST_NAME . '_data', true ));
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

}