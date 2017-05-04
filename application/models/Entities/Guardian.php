<?php

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;

require_once(APPPATH."models/Entities/EntitySuperClass.php");
require_once(APPPATH."models/Entities/Login.php");
require_once(APPPATH."models/Entities/School.php");

/**
 * Guardian
 *
 * @Table(name="guardian")
 * @Entity
 */
class Guardian extends EntitySuperClass {
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
	 * @OneToOne(targetEntity="Login", cascade={"persist", "remove"})
	 * @JoinColumn(name="login_id", referencedColumnName="id")
	 */
	protected $login;

	/**
	 * @var integer
	 *
	 * @ManyToOne(targetEntity="School", inversedBy="guardian", cascade={"persist"})
	 * @JoinColumn(name="school_id", referencedColumnName="id", nullable=false)
	 **/
	protected $school;

	/**
	 * @var string
	 *
	 * @Column(name="first_name", type="string", nullable=false)
	 */
	protected $first_name;

	/**
	 * @var string
	 *
	 * @Column(name="last_name", type="string", nullable=false)
	 */
	protected $last_name;

	/**
	 * @var string
	 *
	 * @Column(name="type", type="string", nullable=false)
	 */
	protected $type;

	/**
	 * @var string
	 *
	 * @Column(name="phone", type="string", nullable=false)
	 */
	protected $phone;

	/**
	 * @var boolean
	 *
	 * @Column(name="app_connected", type="boolean", nullable=false)
	 */
	protected $app_connected;

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
			'login_id' => $this->login->__get('id'),
			'school_id' => $this->school->__get('id'),
			'active' => $this->login->__get('active'),
			'email' => $this->login->__get('email'),
			'token' => $this->login->__get('token'),
			'first_name' => $this->first_name,
			'last_name' => $this->last_name,
			'type' => $this->type,
			'phone' => $this->phone,
			'app_connected' => $this->app_connected,
			'created_on' => $this->created_on,
			'last_updated' => $this->last_updated
		);
	}
}
