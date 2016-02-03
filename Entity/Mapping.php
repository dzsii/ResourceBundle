<?php

namespace ThinkBig\Bundle\ResourceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Vinviter\UserBundle\Entity\User;

/**
 * Mapping
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Mapping
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="objectClass", type="string", length=255)
     */
    private $objectClass;

    /**
     * @var integer
     *
     * @ORM\Column(name="objectId", type="integer")
     */
    private $objectId;

    /**
     * @var string
     *
     * @ORM\Column(name="mapping", type="string", length=255, nullable=true)
     */
    private $mapping;

    /**
     * @ORM\ManyToOne(targetEntity="ThinkBig\Bundle\ResourceBundle\Entity\File", inversedBy="Mappings")
     **/
    private $File;

    /**
     * @ORM\ManyToOne(targetEntity="ThinkBig\Bundle\ResourceBundle\Model\UserInterface")
     **/
    private $Owner;


    /**
     * @ORM\ManyToMany(targetEntity="ThinkBig\Bundle\ResourceBundle\Model\UserInterface")
     * @ORM\JoinTable(name="mapping_favorites",
     *      joinColumns={@ORM\JoinColumn(name="mapping_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    private $Favorites;

    public function __construct() {

        $this->Favorites = new ArrayCollection();
    
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set objectClass
     *
     * @param string $objectClass
     * @return Mapping
     */
    public function setObjectClass($objectClass)
    {
        $this->objectClass = $objectClass;

        return $this;
    }

    /**
     * Get objectClass
     *
     * @return string 
     */
    public function getObjectClass()
    {
        return $this->objectClass;
    }

    /**
     * Set objectId
     *
     * @param integer $objectId
     * @return Mapping
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;

        return $this;
    }

    /**
     * Get objectId
     *
     * @return integer 
     */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * Gets the value of mapping.
     *
     * @return string
     */
    public function getMapping()
    {
        return $this->mapping;
    }

    /**
     * Sets the value of mapping.
     *
     * @param string $mapping the mapping
     *
     * @return self
     */
    public function setMapping($mapping)
    {
        $this->mapping = $mapping;

        return $this;
    }


    /**
     * Gets the value of File.
     *
     * @return mixed
     */
    public function getFile()
    {
        return $this->File;
    }

    /**
     * Sets the value of File.
     *
     * @param mixed $File the file
     *
     * @return self
     */
    public function setFile($File)
    {
        $this->File = $File;

        return $this;
    }

    /**
     * Gets the value of File.
     *
     * @return mixed
     */
    public function getOwner()
    {
        return $this->Owner;
    }

    /**
     * Sets the value of Owner.
     *
     * @param mixed $Owner the owner
     *
     * @return self
     */
    public function setOwner(User $owner)
    {
        $this->Owner = $owner;

        return $this;
    }

    /**
     * Gets the value of Favorites.
     *
     * @return mixed
     */
    public function getFavorites()
    {
        return $this->Favorites;
    }

    public function hasFavorite($item) {

        if ($this->Favorites->contains($item)) {

            return true;

        }

        return false;

    }

    public function addFavorite($item) {

        if (!$this->hasFavorite($item)) {

            $this->Favorites->add($item);

        }

    }

    public function removeFavorite($item) {

        if ($this->hasFavorite($item)) {

            $this->Favorites->removeElement($item);

        }

    }


}
