<?php

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;

require_once(APPPATH."models/Entities/EntitySuperClass.php");
require_once(APPPATH."models/Entities/School.php");
require_once(APPPATH."models/Entities/ClassroomGrade.php");
require_once(APPPATH."models/Entities/ClassroomTeacher.php");
require_once(APPPATH."models/Entities/Student.php");

/**
 * Classroom
 *
 * @Table(name="classroom")
 * @Entity
 */
class Classroom extends EntitySuperClass {
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
	 * @ManyToOne(targetEntity="School", inversedBy="classroom", cascade={"persist"})
	 * @JoinColumn(name="school_id", referencedColumnName="id", nullable=false)
	 **/
	protected $school;

	/**
	 * @var integer
	 *
	 * @ManyToOne(targetEntity="ClassroomGrade", inversedBy="classroom", cascade={"persist"})
	 * @JoinColumn(name="classroom_grade_id", referencedColumnName="id", nullable=false)
	 **/
	protected $classroom_grade;

	/**
	 * @var string
	 *
	 * @Column(name="name", type="string", nullable=false)
	 */
	protected $name;

	/**
	 * @var string
	 *
	 * @Column(name="photo_url", type="string", nullable=true)
	 */
	protected $photo_url;

	/**
	 * @var boolean
	 *
	 * @Column(name="active", type="boolean", nullable=false)
	 */
	protected $active;

	/**
	 * @var boolean
	 *
	 * @Column(name="deleted", type="boolean", nullable=false)
	 */
	protected $deleted;

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

	/**
	 * @var ClassroomTeacher
	 *
	 * @OneToMany(targetEntity="ClassroomTeacher", mappedBy="classroom", cascade={"persist", "remove"})
	 */
	protected $classroom_teacher;

	/**
	 * @var Student
	 *
	 * @OneToMany(targetEntity="Student", mappedBy="classroom", cascade={"persist", "remove"})
	 */
	protected $student;

	public function __construct() {
		$this->created_on = new \DateTime('now');
		$this->last_updated = new \DateTime('now');
	}

	public function getData() {
		return array(
			'id' => $this->id,
			'school_id' => $this->school->__get('id'),
			'classroom_grade_id' => $this->classroom_grade->__get('id'),
			'name' => $this->name,
			'photo_url' => $this->photo_url,
			'active' => $this->active,
			'deleted' => $this->deleted,
			'created_on' => $this->created_on,
			'last_updated' => $this->last_updated
		);
	}
}
