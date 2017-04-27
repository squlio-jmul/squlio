<?php

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;

require_once(APPPATH."models/Entities/EntitySuperClass.php");
require_once(APPPATH."models/Entities/School.php");
require_once(APPPATH."models/Entities/Classroom.php");

/**
 * Announcement
 *
 * @Table(name="announcement")
 * @Entity
 */
class Announcement extends EntitySuperClass {
	/**
	 * @var integer
	 *
	 * @Column(name="id", type="integer", nullable=false)
	 * @Id
	 * @GeneratedValue(strategy="IDENTITY")
	 */
	protected $id;

	/**
	 * @var integer
	 *
	 * @ManyToOne(targetEntity="School", inversedBy="announcement", cascade={"persist"})
	 * @JoinColumn(name="school_id", referencedColumnName="id", nullable=false)
	 **/
	protected $school;

	/**
	 * @var integer
	 *
	 * @ManyToOne(targetEntity="Classroom", inversedBy="announcement", cascade={"persist"})
	 * @JoinColumn(name="classroom_id", referencedColumnName="id", nullable=false)
	 **/
	protected $classroom;

	/**
	 * @var string
	 *
	 * @Column(name="title", type="string", nullable=false)
	 */
	protected $title;

	/**
	 * @var string
	 *
	 * @Column(name="content", type="string", nullable=false)
	 */
	protected $content;

	/**
	 * @var string
	 *
	 * @Column(name="type", type="string", nullable=false)
	 */
	protected $type;

	/**
	 * @var \DateTime
	 *
	 * @Column(name="start_date", type="datetime", nullable=false)
	 */
	protected $start_date;

	/**
	 * @var \DateTime
	 *
	 * @Column(name="end_date", type="datetime", nullable=false)
	 */
	protected $end_date;

	/**
	 * @var boolean
	 *
	 * @Column(name="announcement_read", type="boolean", nullable=false)
	 */
	protected $annnouncement_read;

	/**
	 * @var \DateTime
	 *
	 * @Column(name="created_on", type="datetime", nullable=false)
	 */
	protected $created_on;

	/**
	 * @var \DateTime
	 *
	 * @Column(name="last_updated", type="datetime", nullable=false)
	 */
	protected $last_updated;

	public function __construct() {
		$this->created_on = new \DateTime('now');
		$this->last_updated = new \DateTime('now');
	}

	public function getData() {
		return array(
			'id' => $this->id,
			'school_id' => $this->school->__get('id'),
			'classroom_id' => $this->classroom->__get('id'),
			'title' => $this->title,
			'content' => $this->content,
			'type' => $this->type,
			'start_date' => $this->start_date,
			'end_date' => $this->end_date,
			'announcement_read' => $this->announcement_read,
			'created_on' => $this->created_on,
			'last_updated' => $this->last_updated
		);
	}
}
