<?php
/**
 * @package Resource
 * @subpackage Entity
 */
namespace DrinkApp\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="location")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"winery" = "Winery", "brewery" = "Brewery", "distillery" = "Distillery"})
 *
 * @package Resource
 * @subpackage Entity
 */
class Location
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $latitude;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $longitude;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $modified;

    function get_id()
    {
        return $this->id;
    }

    function get_name()
    {
        return $this->name;
    }

    function set_name($name)
    {
        $this->name = $name;
    }

    function get_lat()
    {
        return $this->lat;
    }

    function set_lat($lat)
    {
        $this->lat = $lat;
    }

    function get_long()
    {
        return $this->long;
    }

    function set_long($long)
    {
        $this->long = $long;
    }

    function get_created()
    {
        return $this->created;
    }

    function get_modified()
    {
        return $this->modified;
    }
}