<?php

namespace Entities;

class EntitySuperClass
{
	public function __construct() {}

		public function setData($propertyArr)
		{
			foreach(array_keys($propertyArr) as $key){
				if($key != 'id'){
					$this->__set($key, $propertyArr[$key]);
				}
			}
		}

	public function __get($property)
	{
		return $this->$property;
	}

	public function __set($property, $value)
	{
		if($property != 'id'){
			$this->$property = $value;
		}
	}

	public function getFormattedObject($property)
	{
		if($this->$property instanceof \Doctrine\Common\Collections\Collection){
			$arr = array();
			foreach($this->$property as $index => $obj){
				if ($obj) {
					$arr[] = $obj->getData();
				}
			}
			return $arr;
		}else{
			if ($prop = $this->$property) {
				return $prop->getData();
			} else {
				return array();
			}
		}
	}
}
