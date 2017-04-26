<?php

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;

require_once(APPPATH."models/Entities/EntitySuperClass.php");
require_once(APPPATH."models/Entities/School.php");
require_once(APPPATH."models/Entities/Term.php");
require_once(APPPATH."models/Entities/Classroom.php");
require_once(APPPATH."models/Entities/Subject.php");

/**
 * Schedule
 *
 * @Table(name="schedule")
 * @Entity
 */
class Schedule extends EntitySuperClass {
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
	 * @ManyToOne(targetEntity="School", inversedBy="schedule", cascade={"persist"})
	 * @JoinColumn(name="school_id", referencedColumnName="id", nullable=false)
	 **/
	protected $school;

	/**
	 * @var integer
	 *
	 * @ManyToOne(targetEntity="Term", inversedBy="schedule", cascade={"persist"})
	 * @JoinColumn(name="term_id", referencedColumnName="id", nullable=false)
	 **/
	protected $term;

	/**
	 * @var integer
	 *
	 * @ManyToOne(targetEntity="Classroom", inversedBy="schedule", cascade={"persist"})
	 * @JoinColumn(name="classroom_id", referencedColumnName="id", nullable=false)
	 **/
	protected $classroom;

	/**
	 * @var integer
	 *
	 * @ManyToOne(targetEntity="Subject", inversedBy="schedule", cascade={"persist"})
	 * @JoinColumn(name="subject_id", referencedColumnName="id", nullable=false)
	 **/
	protected $subject;

	/**
	 * @var \DateTime
	 *
	 * @Column(name="date", type="datetime", nullable=false)
	 */
	protected $date;

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
			'term_id' => $this->term->__get('id'),
			'classroom_id' => $this->classroom->__get('id'),
			'subject_id' => $this->subject->__get('id'),
			'date' => $this->date,
			'created_on' => $this->created_on,
			'last_updated' => $this->last_updated
		);
	}
}
