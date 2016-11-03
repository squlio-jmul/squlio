<?php

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;

require_once(APPPATH."models/Entities/EntitySuperClass.php");
require_once(APPPATH."models/Entities/School.php");

/**
 * Term
 *
 * @Table(name="term")
 * @Entity
 */
class Term extends EntitySuperClass {
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
	 * @ManyToOne(targetEntity="School", inversedBy="term", cascade={"persist"})
	 * @JoinColumn(name="school_id", referencedColumnName="id", nullable=false)
	 **/
	protected $school;

	/**
	 * @var string
	 *
	 * @Column(name="name", type="string", nullable=false)
	 */
	protected $name;

	/**
	 * @var \DateTime
	 *
	 * @Column(name="start_date", type="datetime", nullable=false)
	 */
	protected $start_date;

	/**
	 * @var \DateTime
	 *
	 * @Column(name="end_date", type="datetime", nullable=false)
	 */
	protected $end_date;

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
			'school_id' => $this->school->__get('id'),
			'name' => $this->name,
			'start_date' => $this->start_date,
			'end_date' => $this->end_date,
			'created_on' => $this->created_on,
			'last_updated' => $this->last_updated
		);
	}
}
