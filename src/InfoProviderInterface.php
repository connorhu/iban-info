<?php

namespace Iban\Info;

interface InfoProviderInterface
{
	public function getInfo(): InfoMeta;
}