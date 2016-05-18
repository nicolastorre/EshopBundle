<?php
// src/Nicolas/EshopBundle/Entity/Product.php
namespace Nicolas\EshopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Nicolas\EshopBundle\Repository\ProductRepository") @ORM\Table(name="products")
 * @UniqueEntity("slug")
 **/
class Product
{
	/**
	 * published product
	 */
	CONST PUBLISHED_PRODUCT = 1;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 **/
	private $id;

	/**
	 * slug
	 *
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 * @Assert\NotBlank()
	 */
	private $slug;

	/**
	 * Article title.
	 *
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 * @Assert\NotBlank()
	 */
	private $title;
        
	/**
	 * Article description.
	 *
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 * @Assert\NotBlank()
	 */
	private $description;

	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 * @Assert\NotBlank()
	 */
	private $publishedDate;

	/**
	 * @var user
	 * @ORM\ManyToOne(targetEntity="Nicolas\BlogBundle\Entity\BeUser")
	 */
	private $user;

	/**
	 * @ORM\OneToOne(targetEntity="Nicolas\BlogBundle\Entity\Image", cascade={"persist","remove"})
	 */
	private $image;

	/**
	 * Article content.
	 *
	 * @var string
	 * @ORM\Column(type="text")
	 * @Assert\NotBlank()
	 */
	private $content;

	/**
	 * @var int
	 * @ORM\Column(type="smallint")
	 * @Assert\NotBlank()
	 */
	private $published;

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

        
	/**
	 * @return string
	 */
	public function getSlug()
	{
		return $this->slug;
	}

	/**
	 * @param string $slug
	 */
	public function setSlug($slug)
	{
		$this->slug = $slug;
	}
        
	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}
        
        /**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @return int
	 */
	public function getPublishedDate()
	{
		return $this->publishedDate;
	}

	/**
	 * @param int $publishedDate
	 */
	public function setPublishedDate($publishedDate)
	{
		$this->publishedDate = $publishedDate;
	}

	/**
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * @param string $content
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}

	/**
	 * @return int
	 */
	public function getPublished()
	{
		return $this->published;
	}

	/**
	 * @param int $published
	 */
	public function setPublished($published)
	{
		$this->published = $published;
	}

	/**
	 * @return user
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * @param user $user
	 */
	public function setUser($user)
	{
		$this->user = $user;
	}

	/**
	 * @return mixed
	 */
	public function getImage()
	{
		return $this->image;
	}

	/**
	 * @param mixed $image
	 */
	public function setImage($image)
	{
		$this->image = $image;
	}

}