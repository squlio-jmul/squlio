<?php

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;

require_once(APPPATH."models/Entities/EntitySuperClass.php");
require_once(APPPATH."models/Entities/Classroom.php");
require_once(APPPATH."models/Entities/Teacher.php");

/**
 * ClassroomTeacher
 *
 * @Table(name="classroom_teacher")
 * @Entity
 */
class ClassroomTeacher extends EntitySuperClass {
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
	 * @OneToOne(targetEntity="Classroom", cascade={"persist"})
	 * @JoinColumn(name="classroom_id", referencedColumnName="id", nullable=false)
	 **/
	protected $classroom;

	/**
	 * @var integer
	 *
	 * @OneToOne(targetEntity="Teacher", cascade={"persist"})
	 * @JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false)
	 **/
	protected $teacher;

	/**
	 * @var boolean
	 *
	 * @Column(name="is_primary", type="boolean", nullable=false)
	 */
	protected $is_primary;

	public function __construct() {
	}

	public function getData() {
		return array(
			'id' => $this->id,
			'classroom_id' => $this->classroom->__get('id'),
			'classroom_name' => $this->classroom->__get('name'),
			'teacher_id' => $this->teacher->__get('id'),
			'teacher_first_name' => $this->teacher->__get('first_name'),
			'teacher_last_name' => $this->teacher->__get('last_name'),
			'is_primary' => $this->is_primary
		);
	}
}
