<?php

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;

require_once(APPPATH."models/Entities/EntitySuperClass.php");

/**
 * AccountType
 *
 * @Table(name="account_type")
 * @Entity
 */
class AccountType extends EntitySuperClass {
	/**
	 * @var integer
	 *
	 * @Column(name="id", type="integer", nullable=false)
	 * @Id
	 * @GeneratedValue(strategy="IDENTITY")
	 */
	protected $id;

	/**
	 * @var string
	 *
	 * @Column(name="name", type="string", nullable=false)
	 */
	protected $name;

	/**
	 * @var string
	 *
	 * @Column(name="display_name", type="string", nullable=false)
	 */
	protected $display_name;

	/**
	 * @var integer
	 *
	 * @Column(name="num_principal", type="integer", nullable=false)
	 */
	protected $num_principal;

	/**
	 * @var integer
	 *
	 * @Column(name="num_school_admin", type="integer", nullable=false)
	 */
	protected $num_school_admin;

	/**
	 * @var integer
	 *
	 * @Column(name="num_teacher", type="integer", nullable=false)
	 */
	protected $num_teacher;

	/**
	 * @var integer
	 *
	 * @Column(name="num_classroom", type="integer", nullable=false)
	 */
	protected $num_classroom;

	/**
	 * @var integer
	 *
	 * @Column(name="num_guardian", type="integer", nullable=false)
	 */
	protected $num_guardian;

	/**
	 * @var integer
	 *
	 * @Column(name="num_student", type="integer", nullable=false)
	 */
	protected $num_student;

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
	}

	public function getData() {
		return array(
			'id' => $this->id,
			'name' => $this->name,
			'display_name' => $this->display_name,
			'num_principal' => $this->num_principal,
			'num_school_admin' => $this->num_school_admin,
			'num_teacher' => $this->num_teacher,
			'num_classroom' => $this->num_classroom,
			'num_guardian' => $this->num_guardian,
			'num_student' => $this->num_student,
			'active' => $this->active,
			'deleted' => $this->deleted,
			'created_on' => $this->created_on,
			'last_updated' => $this->last_updated
		);
	}
}
