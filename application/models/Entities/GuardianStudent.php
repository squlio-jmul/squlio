<?php

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;

require_once(APPPATH."models/Entities/EntitySuperClass.php");
require_once(APPPATH."models/Entities/Guardian.php");
require_once(APPPATH."models/Entities/Student.php");

/**
 * GuardianStudent
 *
 * @Table(name="guardian_student")
 * @Entity
 */
class GuardianStudent extends EntitySuperClass {
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
	 * @OneToOne(targetEntity="Guardian", cascade={"persist"})
	 * @JoinColumn(name="guardian_id", referencedColumnName="id", nullable=false)
	 **/
	protected $guardian;

	/**
	 * @var integer
	 *
	 * @OneToOne(targetEntity="Student", cascade={"persist"})
	 * @JoinColumn(name="student_id", referencedColumnName="id", nullable=false)
	 **/
	protected $student;

	public function __construct() {
	}

	public function getData() {
		return array(
			'id' => $this->id,
			'guardian_id' => $this->guardian->__get('id'),
			'student_id' => $this->student->__get('id')
		);
	}
}
