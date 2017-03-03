<?php

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;

require_once(APPPATH."models/Entities/EntitySuperClass.php");
require_once(APPPATH."models/Entities/School.php");
require_once(APPPATH."models/Entities/Term.php");
require_once(APPPATH."models/Entities/Classroom.php");
require_once(APPPATH."models/Entities/ClassroomSubject.php");

/**
 * Syllabus
 *
 * @Table(name="syllabus")
 * @Entity
 */
class Syllabus extends EntitySuperClass {
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
	 * @ManyToOne(targetEntity="School", inversedBy="syllabus", cascade={"persist"})
	 * @JoinColumn(name="school_id", referencedColumnName="id", nullable=false)
	 **/
	protected $school;

	/**
	 * @var integer
	 *
	 * @ManyToOne(targetEntity="Term", inversedBy="syllabus", cascade={"persist"})
	 * @JoinColumn(name="term_id", referencedColumnName="id", nullable=false)
	 **/
	protected $term;

	/**
	 * @var integer
	 *
	 * @ManyToOne(targetEntity="Classroom", inversedBy="syllabus", cascade={"persist"})
	 * @JoinColumn(name="classroom_id", referencedColumnName="id", nullable=false)
	 **/
	protected $classroom;

	/**
	 * @var integer
	 *
	 * @ManyToOne(targetEntity="ClassroomSubject", inversedBy="syllabus", cascade={"persist"})
	 * @JoinColumn(name="classroom_subject_id", referencedColumnName="id", nullable=false)
	 **/
	protected $classroom_subject;

	/**
	 * @var string
	 *
	 * @Column(name="title", type="string", nullable=false)
	 */
	protected $title;

	/**
	 * @var string
	 *
	 * @Column(name="description", type="string", nullable=false)
	 */
	protected $description;

	/**
	 * @var string
	 *
	 * @Column(name="date", type="string", nullable=false)
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
			'classroom_subject_id' => $this->classroom_subject->__get('id'),
			'title' => $this->title,
			'description' => $this->description,
			'date' => $this->date,
			'created_on' => $this->created_on,
			'last_updated' => $this->last_updated
		);
	}
}
