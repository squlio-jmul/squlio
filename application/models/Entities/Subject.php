<?php

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;

require_once(APPPATH."models/Entities/EntitySuperClass.php");
require_once(APPPATH."models/Entities/School.php");
require_once(APPPATH."models/Entities/ClassroomGrade.php");

/**
 * Subject
 *
 * @Table(name="subject")
 * @Entity
 */
class Subject extends EntitySuperClass {
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
	 * @ManyToOne(targetEntity="School", inversedBy="subject", cascade={"persist"})
	 * @JoinColumn(name="school_id", referencedColumnName="id", nullable=false)
	 **/
	protected $school;

	/**
	 * @var integer
	 *
	 * @ManyToOne(targetEntity="ClassroomGrade", inversedBy="subject", cascade={"persist"})
	 * @JoinColumn(name="classroom_grade_id", referencedColumnName="id", nullable=false)
	 **/
	protected $classroom_grade;

	/**
	 * @var string
	 *
	 * @Column(name="title", type="string", nullable=false)
	 */
	protected $title;

	/**
	 * @var string
	 *
	 * @Column(name="description", type="string", nullable=false)
	 */
	protected $description;

	/**
	 * @var string
	 *
	 * @Column(name="additional_info", type="string", nullable=true)
	 */
	protected $additional_info;

	/**
	 * @var string
	 *
	 * @Column(name="url", type="string", nullable=true)
	 */
	protected $url;

	/**
	 * @var string
	 *
	 * @Column(name="img_url_path", type="string", nullable=true)
	 */
	protected $img_url_path;

	/**
	 * @var string
	 *
	 * @Column(name="video_url_path", type="string", nullable=true)
	 */
	protected $video_url_path;

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
			'classroom_grade_id' => $this->classroom_grade->__get('id'),
			'title' => $this->title,
			'description' => $this->description,
			'additional_info' => $this->additional_info,
			'url' => $this->url,
			'img_url_path' => $this->img_url_path,
			'video_url_path' => $this->video_url_path,
			'created_on' => $this->created_on,
			'last_updated' => $this->last_updated
		);
	}
}
