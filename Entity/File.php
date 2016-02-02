<?php

namespace ThinkBig\Bundle\ResourceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * File
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ThinkBig\Bundle\ResourceBundle\Entity\FileRepository")
 * @ORM\EntityListeners("\ThinkBig\Bundle\ResourceBundle\EventListener\FileListener")
 */
class File
{

    private $file;
    private $temp;

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
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=30)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(name="mimeType", type="string", length=30)
     */
    private $mimeType;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="context", type="string", length=255, nullable=true)
     */
    private $context;

    /**
     * @var uid
     *
     * @ORM\Column(name="guid", type="guid")
     */
    private $uid;

    /**
     * @ORM\OneToMany(targetEntity="ThinkBig\Bundle\ResourceBundle\Entity\Mapping", mappedBy="File", cascade={"remove"})
     **/
    private $Mappings;


    /**
     * @ORM\ManyToMany(targetEntity="Vinviter\UserBundle\Entity\User")
     * @ORM\JoinTable(name="file_favorites",
     *      joinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    private $Favorites;

    public function __construct() {

        $this->Mappings = new ArrayCollection();
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
     * Sets file.
     *
     * @param SplFileInfo $file
     */
    public function setFile(\SplFileInfo $file = null)
    {
        
        $this->file = $file;

    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set uid
     *
     * @param uid $uid
     * @return File
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid
     *
     * @return uid 
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return File
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set context
     *
     * @param string $context
     * @return File
     */
    public function setContext($context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Get context
     *
     * @return string 
     */
    public function getContext()
    {
        return $this->context;
    }


    /**
     * Gets the value of Mappings.
     *
     * @return mixed
     */
    public function getMappings()
    {
        return $this->Mappings;
    }

    public function hasMapping(Mapping $item) {

        if ($this->Mappings->contains($item)) {

            return true;

        }

        return false;

    }

    public function addMapping(Mapping $item) {

        if (!$this->hasMapping($item)) {

            $this->Mappings->add($item);

        }

    }

    public function removeMapping(Mapping $item) {

        if ($this->hasMapping($item)) {

            $this->Mappings->removeElement($item);

        }

    }


    /**
     * Gets the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param string $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the value of mimeType.
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Sets the value of mimeType.
     *
     * @param string $mimeType the mime type
     *
     * @return self
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Gets the value of extension.
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Sets the value of extension.
     *
     * @param string $extension the extension
     *
     * @return self
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Gets the value of size.
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Sets the value of size.
     *
     * @param string $size the size
     *
     * @return self
     */
    public function setSize($size)
    {
        $this->size = $size;

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
