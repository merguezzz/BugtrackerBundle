<?php

namespace Webaccess\BugtrackerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Webaccess\BugtrackerBundle\Entity\Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="Webaccess\BugtrackerBundle\Repository\ProjectRepository")
 */
class Project
{
	/**
	 * @var integer $id
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var string $name
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	protected $name;

	/**
	 * @var Company
	 *
	 * @ORM\ManyToOne(targetEntity="Company")
	 * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
	 */
	protected $company;

	/**
	 * @var integer $status
	 *
	 * @ORM\Column(name="status", type="integer")
	 */
	protected $status;

	/**
	 * @var \DateTime $createdAt
	 *
	 * @ORM\Column(name="created_at", type="datetime")
	 */
	protected $createdAt;

	/**
	 * @var \DateTime $updatedAt
	 *
	 * @ORM\Column(name="updated_at", type="datetime")
	 */
	protected $updatedAt;


	/**
	 * Constructor
	 *
	 * @return NULL
	 */
	public function __construct()
	{
		$this->name = '';
		$this->company = NULL;
		$this->status = 1;
		$this->createdAt = new \DateTime();
		$this->updatedAt = new \DateTime();
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
	 * Set name
	 *
	 * @param string $name
	 * @return Project
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set company
	 *
	 * @param \Company $company
	 * @return Project
	 */
	public function setCompany(\Webaccess\BugtrackerBundle\Entity\Company $company)
	{
		$this->company = $company;
		return $this;
	}

	/**
	 * Set createdAt
	 *
	 * @return Company
	 */
	public function getCompany()
	{
		return $this->company;
	}

	/**
	 * Set status
	 *
	 * @param integer $status
	 * @return Project
	 */
	public function setStatus($status)
	{
		$this->status = $status;
		return $this;
	}

	/**
	 * Get status
	 *
	 * @return integer
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * Set createdAt
	 *
	 * @param \DateTime $createdAt
	 * @return Project
	 */
	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;
		return $this;
	}

	/**
	 * Get createdAt
	 *
	 * @return \DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * Set updatedAt
	 *
	 * @param \DateTime $updatedAt
	 * @return Project
	 */
	public function setUpdatedAt($updatedAt)
	{
		$this->updatedAt = $updatedAt;
		return $this;
	}

	/**
	 * Get updatedAt
	 *
	 * @return \DateTime
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}
}
