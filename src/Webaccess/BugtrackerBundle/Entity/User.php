<?php

namespace Webaccess\BugtrackerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Webaccess\BugtrackerBundle\Entity\User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Webaccess\BugtrackerBundle\Repository\UserRepository")
 */
class User implements UserInterface
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
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    protected $username;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @var string $firstName
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    protected $firstName;

    /**
     * @var string $lastName
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    protected $lastName;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    protected $email;

    /**
     * @var Company
     *
     * @ORM\ManyToOne(targetEntity="Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id", nullable=true)
     */
    protected $company;

    /**
     * @var integer $status
     *
     * @ORM\Column(name="status", type="integer")
     */
    protected $status;

    /**
    * @var integer $salt
     * @ORM\Column(type="string", length=32)
     */
    protected $salt;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users", cascade={"persist"})
     * @ORM\JoinTable(name="user_role",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     *
     * @var ArrayCollection $roles
     */
    protected $roles;

    /**
     * @ORM\ManyToMany(targetEntity="Project", inversedBy="users", cascade={"persist"})
     * @ORM\JoinTable(name="user_project",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id")}
     * )
     *
     * @var ArrayCollection $projects
     */
    protected $projects;

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
        $this->username = '';
        $this->password = '';
        $this->firstName = '';
        $this->lastName = '';
        $this->email = '';
        $this->company = NULL;
        $this->status = 1;
        $this->salt = md5(uniqid(null, true));
        $this->roles = new ArrayCollection();
        $this->projects = new ArrayCollection();
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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getCompleteName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Gets the user roles.
     *
     * @return ArrayCollection $roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Add roles
     *
     * @param Webaccess\BugtrackerBundle\Entity\Role $roles
     * @return User $user
     */
    public function addRole(\Webaccess\BugtrackerBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;
        return $this;
    }

    /**
     * Gets the user projects.
     *
     * @return ArrayCollection A Doctrine ArrayCollection
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Sets the user projects.
     *
     * @param ArrayCollection $projects
     * @return User $user
     */
    public function setProjects(ArrayCollection $projects)
    {
        $this->projects = $projects;
        return $this;
    }

    /**
     * Add projects
     *
     * @param Webaccess\BugtrackerBundle\Entity\Project $project
     * @return User
     */
    public function addProject(\Webaccess\BugtrackerBundle\Entity\Project $project)
    {
        $this->projects[] = $project;
    }

    /**
     * Erase credentials
     *
     * @return void
     */
    public function eraseCredentials()
    {
    }

    /**
     * Check if the user in parameter equals the user loaded
     *
     * @return boolean
     */
    public function equals(UserInterface $user)
    {
        return $this->username === $user->getUsername();
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
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
     * @return User
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

    public function serialize()
    {
        return serialize($this->username);
    }

    public function unserialize($data)
    {
        $this->username = unserialize($data);
    }
}
