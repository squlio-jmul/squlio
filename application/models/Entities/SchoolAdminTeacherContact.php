<?php

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;

require_once(APPPATH."models/Entities/EntitySuperClass.php");
require_once(APPPATH."models/Entities/SchoolAdmin.php");
require_once(APPPATH."models/Entities/Teacher.php");

/**
 * SchoolAdminTeacherContact
 *
 * @Table(name="school_admin_teacher_contact")
 * @Entity
 */
class SchoolAdminTeacherContact extends EntitySuperClass {
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
	 * @ManyToOne(targetEntity="SchoolAdmin", inversedBy="school_admin_teacher_contact", cascade={"persist"})
	 * @JoinColumn(name="school_admin_id", referencedColumnName="id", nullable=false)
	 **/
	protected $school_admin;

	/**
	 * @var integer
	 *
	 * @ManyToOne(targetEntity="Teacher", inversedBy="school_admin_teacher_contact", cascade={"persist"})
	 * @JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false)
	 **/
	protected $teacher_id;

	/**
	 * @var string
	 *
	 * @Column(name="direction", type="string", nullable=false)
	 */
	protected $direction;

	/**
	 * @var string
	 *
	 * @Column(name="title", type="string", nullable=false)
	 */
	protected $title;

	/**
	 * @var string
	 *
	 * @Column(name="message", type="string", nullable=false)
	 */
	protected $message;

	/**
	 * @var boolean
	 *
	 * @Column(name="message_read", type="boolean", nullable=false)
	 */
	protected $message_read;

	/**
	 * @var \DateTime
	 *
	 * @Column(name="created_on", type="datetime", nullable=false)
	 */
	protected $created_on;

	public function __construct() {
		$this->created_on = new \DateTime('now');
	}

	public function getData() {
		return array(
			'id' => $this->id,
			'school_admin_id' => $this->school_admin->__get('id'),
			'teacher_id' => $this->teacher->__get('id'),
			'direction' => $this->direction,
			'title' => $this->title,
			'message' => $this->message,
			'message_read' => $this->message_read,
			'created_on' => $this->created_on
		);
	}
}
