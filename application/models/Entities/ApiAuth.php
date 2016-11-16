<?php

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;

require_once(APPPATH."models/Entities/EntitySuperClass.php");

/**
 * ApiAuth
 *
 * @Table(name="api_auth")
 * @Entity
 */
class ApiAuth extends EntitySuperClass {
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
	 * @Column(name="consumer", type="string", nullable=false)
	 */
	protected $consumer;

	/**
	 * @var string
	 *
	 * @Column(name="token", type="string", nullable=false)
	 */
	protected $token;

	/**
	 * @var string
	 *
	 * @Column(name="password", type="string", nullable=false)
	 */
	protected $password;

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
			'consumer' => $this->consumer,
			'token' => $this->token,
			'password' => $this->password,
			'created_on' => $this->created_on,
			'last_updated' => $this->last_updated
		);
	}
}
