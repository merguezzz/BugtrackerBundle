<?php

namespace Webaccess\BugtrackerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Webaccess\BugtrackerBundle\Entity\TicketState
 *
 * @ORM\Table(name="ticket_state")
 * @ORM\Entity(repositoryClass="Webaccess\BugtrackerBundle\Repository\TicketStateRepository")
 */
class TicketState
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
     * @var text $content
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    protected $content;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Ticket", inversedBy="states")
     * @ORM\JoinColumn(name="ticket_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $ticket;

    /**
     * @var User $authorUser
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $authorUser;

    /**
     * @var User $allocatedUser
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="allocated_user_id", referencedColumnName="id")
     */
    protected $allocatedUser;

    /**
     * @var integer $type
     *
     * @ORM\Column(name="type", type="integer")
     */
    protected $type;

    /**
     * @var integer $status
     *
     * @ORM\Column(name="status", type="integer")
     */
    protected $status;

   /**
     * @var integer $priority
     *
     * @ORM\Column(name="priority", type="integer")
     */
    protected $priority;


    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->createdAt = new \Datetime('now');
        $this->content = '';
        $this->authorUser = NULL;
        $this->allocatedUser = NULL;
        $this->status = 1;
        $this->priority = 1;
        $this->type = 1;
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
     * Set content
     *
     * @param text $content
     * @return TicketState
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get content
     *
     * @return text
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set type
     *
     * @param $type
     * @return TicketState
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return ticket_type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set status
     *
     * @param $status
     * @return TicketState
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return ticket_status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set priority
     *
     * @param $priority
     * @return TicketState
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * Get priority
     *
     * @return priority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     * @return TicketState
     */
    public function setCreatedAt($dhCreated)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set ticket
     *
     * @param ticket $ticket
     * @return TicketState
     */
    public function setTicket(\Webaccess\BugtrackerBundle\Entity\Ticket $ticket)
    {
        $this->ticket = $ticket;
        return $this;
    }

    /**
     * Get ticket
     *
     * @return ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * Set authorUser
     *
     * @param User $authorUser
     * @return TicketState
     */
    public function setAuthorUser(\Webaccess\BugtrackerBundle\Entity\User $authorUser)
    {
        $this->authorUser = $authorUser;
        return $this;
    }

    /**
     * Get authorUser
     *
     * @return authorUser
     */
    public function getAuthorUser()
    {
        return $this->authorUser;
    }

    /**
     * Set allocatedUser
     *
     * @param User $allocatedUser
     * @return TicketState
     */
    public function setAllocatedUser(\Webaccess\BugtrackerBundle\Entity\User $allocatedUser)
    {
        $this->allocatedUser = $allocatedUser;
        return $this;
    }

    /**
     * Get allocatedUser
     *
     * @return allocatedUser
     */
    public function getAllocatedUser()
    {
        return $this->allocatedUser;
    }
}
