<?php
namespace AppBundle\Domain\Api\Responder;

class SimpleResponder
{
	private static $data = null;

	public static function setData($data){
		static::$data = $data;
	}

	public static function respond()
	{
		return static::$data;
	}
}