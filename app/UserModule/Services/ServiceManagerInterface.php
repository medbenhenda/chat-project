<?php
/**
 * Created by PhpStorm.
 * Project: chat-project
 * User: m.benhenda
 * Date: 16/02/2018
 * Time: 22:10
 */

namespace Chat\UserModule\Services;


interface ServiceManagerInterface
{
	public function load($id);

	public function findAll();

}