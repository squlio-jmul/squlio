<?php

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;

require_once(APPPATH."models/Entities/EntitySuperClass.php");

/**
 * Login
 *
 * @Table(name="login")
 * @Entity
 */
class Login extends EntitySuperClass {
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
	 * @Column(name="email", type="string", nullable=false)
	 */
	protected $email;

	/**
	 * @var string
	 *
	 * @Column(name="password", type="string", nullable=false)
	 */
	protected $password;

	/**
	 * @var string
	 *
	 * @Column(name="type", type="string", nullable=false)
	 */
	protected $type;

	/**
	 * @var string
	 *
	 * @Column(name="token", type="string", nullable=false)
	 */
	protected $token;

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
	 * @var boolean
	 *
	 * @Column(name="reset_password", type="boolean", nullable=false)
	 */
	protected $reset_password;

	/**
	 * @var \DateTime
	 *
	 * @Column(name="last_login", type="datetime", nullable=true)
	 */
	protected $last_login;

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
			'email' => $this->email,
			'password' => $this->password,
			'type' => $this->type,
			'token' => $this->token,
			'active' => $this->active,
			'deleted' => $this->deleted,
			'reset_password' => $this->reset_password,
			'last_login' => $this->last_login,
			'created_on' => $this->created_on,
			'last_updated' => $this->last_updated
		);
	}
}
