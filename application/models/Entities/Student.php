<?php

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;

require_once(APPPATH."models/Entities/EntitySuperClass.php");
require_once(APPPATH."models/Entities/School.php");
require_once(APPPATH."models/Entities/Classroom.php");
require_once(APPPATH."models/Entities/ClassroomGrade.php");

/**
 * Student
 *
 * @Table(name="student")
 * @Entity
 */
class Student extends EntitySuperClass {
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
	 * @ManyToOne(targetEntity="School", inversedBy="student", cascade={"persist"})
	 * @JoinColumn(name="school_id", referencedColumnName="id", nullable=false)
	 **/
	protected $school;

	/**
	 * @var integer
	 *
	 * @ManyToOne(targetEntity="ClassroomGrade", inversedBy="student", cascade={"persist"})
	 * @JoinColumn(name="classroom_grade_id", referencedColumnName="id", nullable=false)
	 **/
	protected $classroom_grade;

	/**
	 * @var integer
	 *
	 * @ManyToOne(targetEntity="Classroom", inversedBy="student", cascade={"persist"})
	 * @JoinColumn(name="classroom_id", referencedColumnName="id", nullable=true)
	 **/
	protected $classroom;

	/**
	 * @var string
	 *
	 * @Column(name="first_name", type="string", nullable=true)
	 */
	protected $first_name;

	/**
	 * @var string
	 *
	 * @Column(name="last_name", type="string", nullable=true)
	 */
	protected $last_name;

	/**
	 * @var string
	 *
	 * @Column(name="gender", type="string", nullable=false)
	 */
	protected $gender;

	/**
	 * @var \DateTime
	 *
	 * @Column(name="birthday", type="datetime", nullable=false)
	 */
	protected $birthday;

	/**
	 * @var string
	 *
	 * @Column(name="photo_url", type="string", nullable=true)
	 */
	protected $photo_url;

	/**
	 * @var string
	 *
	 * @Column(name="code", type="string", nullable=false)
	 */
	protected $code;

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

	public function __construct() {
		$this->created_on = new \DateTime('now');
		$this->last_updated = new \DateTime('now');
		$this->birthday = new \DateTime;
	}

	public function getData() {
		return array(
			'id' => $this->id,
			'school_id' => $this->school->__get('id'),
			'classroom_grade_id' => $this->classroom_grade->__get('id'),
			'classroom_id' => ($this->classroom) ? $this->classroom->__get('id') : null,
			'first_name' => $this->first_name,
			'last_name' => $this->last_name,
			'gender' => $this->gender,
			'birthday' => $this->birthday,
			'photo_url' => $this->photo_url,
			'code' => $this->code,
			'active' => $this->active,
			'deleted' => $this->deleted,
			'created_on' => $this->created_on,
			'last_updated' => $this->last_updated
		);
	}
}
