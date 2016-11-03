<?php

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;

require_once(APPPATH."models/Entities/EntitySuperClass.php");
require_once(APPPATH."models/Entities/Syllabus.php");
require_once(APPPATH."models/Entities/Material.php");

/**
 * SyllabusMaterial
 *
 * @Table(name="syllabus_material")
 * @Entity
 */
class SyllabusMaterial extends EntitySuperClass {
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
	 * @OneToOne(targetEntity="Syllabus", cascade={"persist"})
	 * @JoinColumn(name="syllabus_id", referencedColumnName="id", nullable=false)
	 **/
	protected $syllabus;

	/**
	 * @var integer
	 *
	 * @OneToOne(targetEntity="Material", cascade={"persist"})
	 * @JoinColumn(name="material_id", referencedColumnName="id", nullable=false)
	 **/
	protected $material;

	public function __construct() {
	}

	public function getData() {
		return array(
			'id' => $this->id,
			'syllabus_id' => $this->syllabus->__get('id'),
			'material_id' => $this->material->__get('id')
		);
	}
}
