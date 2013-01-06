<?php

namespace Webaccess\BugtrackerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Webaccess\BugtrackerBundle\Entity\Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="Webaccess\BugtrackerBundle\Repository\TicketRepository")
 */
class Ticket
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
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var Project $project
     *
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;

    /**
     * @var ArrayCokkection $states
     *
     * @ORM\OneToMany(targetEntity="TicketState", mappedBy="ticket", cascade={"remove"})
     */
    protected $states;

    /**
     * @var Project $project
     *
     * @ORM\ManyToOne(targetEntity="TicketState", cascade={"remove"})
     * @ORM\JoinColumn(name="current_state_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $currentState;

    /**
     * @var text $files
     *
     * @ORM\Column(name="files", type="text", nullable=true)
     */
    protected $files;


    /**
     * Constructor
     *
     * @return NULL
     */
    public function __construct()
    {
        $this->states = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Ticket
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set project
     *
     * @param project $project
     * @return Ticket
     */
    public function setProject(\Webaccess\BugtrackerBundle\Entity\Project $project)
    {
        $this->project = $project;
        return $this;
    }

    /**
     * Get project
     *
     * @return project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set states
     *
     * @param states $states
     */
    public function setStates($states)
    {
        foreach ($states as $state) {
            $this->addState($state);
            $state->setTicket($this);
        }

        $this->states = $states;
    }

    /**
     * Get states
     *
     * @return states
     */
    public function getStates()
    {
        return $this->states;
    }

    /**
     * Add state
     *
     * @param Webaccess\BugtrackerBundle\Entity\TicketState $state
     */
    public function addState(\Webaccess\BugtrackerBundle\Entity\TicketState $state)
    {
        if (!$this->states->contains($state)) {
            $this->states->add($state);
        }
    }

    /**
     * Remove state
     *
     * @param Webaccess\BugtrackerBundle\Entity\TicketState $state
     */
    public function removeState(\Webaccess\BugtrackerBundle\Entity\TicketState $state)
    {
        if ($this->states->contains($state)) {
            $this->states->delete($state);
        }
    }

    /**
     * Get currentState
     *
     * @return TicketState
     */
    public function getCurrentState()
    {
        return $this->currentState;
    }

    /**
     * Set current_state
     *
     * @param TicketState $currentState
     * @return Ticket
     */
    public function setCurrentState(\Webaccess\BugtrackerBundle\Entity\TicketState $currentState)
    {
        $this->currentState = $currentState;
        return $this;
    }

    /**
     * Set files
     *
     * @param text $files
     * @return Ticket
     */
    public function setFiles($files)
    {
        $this->files = $files;
        return $this;
    }

    /**
     * Get files
     *
     * @return text
     */
    public function getFiles()
    {
        return $this->files;
    }
}
