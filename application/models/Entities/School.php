<?php

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;

require_once(APPPATH."models/Entities/EntitySuperClass.php");
require_once(APPPATH."models/Entities/AccountType.php");

/**
 * School
 *
 * @Table(name="school")
 * @Entity
 */
class School extends EntitySuperClass {
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
	 * @ManyToOne(targetEntity="AccountType", inversedBy="school", cascade={"persist"})
	 * @JoinColumn(name="account_type_id", referencedColumnName="id", nullable=false)
	 **/
	protected $account_type;

	/**
	 * @var string
	 *
	 * @Column(name="name", type="string", nullable=false)
	 */
	protected $name;

	/**
	 * @var string
	 *
	 * @Column(name="address_1", type="string", nullable=false)
	 */
	protected $address_1;

	/**
	 * @var string
	 *
	 * @Column(name="address_2", type="string", nullable=true)
	 */
	protected $address_2;

	/**
	 * @var string
	 *
	 * @Column(name="city", type="string", nullable=false)
	 */
	protected $city;

	/**
	 * @var string
	 *
	 * @Column(name="state", type="string", nullable=false)
	 */
	protected $state;

	/**
	 * @var integer
	 *
	 * @Column(name="zipcode", type="integer", nullable=false)
	 */
	protected $zipcode;

	/**
	 * @var string
	 *
	 * @Column(name="country", type="string", nullable=false)
	 */
	protected $country;

	/**
	 * @var string
	 *
	 * @Column(name="phone_1", type="string", nullable=false)
	 */
	protected $phone_1;

	/**
	 * @var string
	 *
	 * @Column(name="phone_2", type="string", nullable=true)
	 */
	protected $phone_2;

	/**
	 * @var string
	 *
	 * @Column(name="branch", type="string", nullable=true)
	 */
	protected $branch;

	/**
	 * @var string
	 *
	 * @Column(name="email", type="string", nullable=true)
	 */
	protected $email;

	/**
	 * @var string
	 *
	 * @Column(name="url", type="string", nullable=true)
	 */
	protected $url;

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
	}

	public function getData() {
		return array(
			'id' => $this->id,
			'account_type_id' => $this->account_type->__get('id'),
			'name' => $this->name,
			'address_1' => $this->address_1,
			'address_2' => $this->address_2,
			'city' => $this->city,
			'state' => $this->state,
			'zipcode' => $this->zipcode,
			'country' => $this->country,
			'phone_1' => $this->phone_1,
			'phone_2' => $this->phone_2,
			'branch' => $this->branch,
			'email' => $this->email,
			'url' => $this->url,
			'code' => $this->code,
			'active' => $this->active,
			'deleted' => $this->deleted,
			'created_on' => $this->created_on,
			'last_updated' => $this->last_updated
		);
	}
}
