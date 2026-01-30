<?php

namespace Iban\Info;

use Iban\Validation\Iban;

final class InfoProviderFactory
{
	public static function create(string $iban)
	{
		$iban = new Iban($iban);
		
		return match ($iban->countryCode()) {
			'HU' => new InfoProviders\HU($iban),
			default => throw new \RuntimeException('unsupported country code'),
		};
	}
}