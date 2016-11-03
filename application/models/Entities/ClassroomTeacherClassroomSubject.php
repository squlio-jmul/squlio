<?php

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;

require_once(APPPATH."models/Entities/EntitySuperClass.php");
require_once(APPPATH."models/Entities/Classroom.php");
require_once(APPPATH."models/Entities/Teacher.php");
require_once(APPPATH."models/Entities/ClassroomSubject.php");

/**
 * ClassroomTeacherClassroomSubject
 *
 * @Table(name="classroom_teacher_classroom_subject")
 * @Entity
 */
class ClassroomTeacherClassroomSubject extends EntitySuperClass {
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
	 * @var integer
	 *
	 * @OneToOne(targetEntity="ClassroomSubject", cascade={"persist"})
	 * @JoinColumn(name="classroom_subject_id", referencedColumnName="id", nullable=false)
	 **/
	protected $classroom_subject;

	public function __construct() {
	}

	public function getData() {
		return array(
			'id' => $this->id,
			'classroom_id' => $this->classroom->__get('id'),
			'teacher_id' => $this->teacher->__get('id'),
			'classroom_subject_id' => $this->classroom_subject->__get('id')
		);
	}
}
