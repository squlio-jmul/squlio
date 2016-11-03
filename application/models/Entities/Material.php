<?php

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;

require_once(APPPATH."models/Entities/EntitySuperClass.php");
require_once(APPPATH."models/Entities/School.php");
require_once(APPPATH."models/Entities/ClassroomSubject.php");

/**
 * Material
 *
 * @Table(name="material")
 * @Entity
 */
class Material extends EntitySuperClass {
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
	 * @ManyToOne(targetEntity="School", inversedBy="material", cascade={"persist"})
	 * @JoinColumn(name="school_id", referencedColumnName="id", nullable=false)
	 **/
	protected $school;

	/**
	 * @var integer
	 *
	 * @ManyToOne(targetEntity="ClassroomSubject", inversedBy="material", cascade={"persist"})
	 * @JoinColumn(name="classroom_subject_id", referencedColumnName="id", nullable=false)
	 **/
	protected $classroom_subject;

	/**
	 * @var string
	 *
	 * @Column(name="title", type="string", nullable=false)
	 */
	protected $title;

	/**
	 * @var string
	 *
	 * @Column(name="content", type="string", nullable=false)
	 */
	protected $content;

	/**
	 * @var string
	 *
	 * @Column(name="img_url_path", type="string", nullable=true)
	 */
	protected $img_url_path;

	/**
	 * @var string
	 *
	 * @Column(name="url", type="string", nullable=true)
	 */
	protected $url;

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
			'classroom_subject_id' => $this->classroom_subject->__get('id'),
			'title' => $this->title,
			'content' => $this->content,
			'img_url_path' => $this->img_url_path,
			'url' => $this->url,
			'created_on' => $this->created_on,
			'last_updated' => $this->last_updated
		);
	}
}
