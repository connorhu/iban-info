<?php

namespace Iban\Info;

use Iban\Validation\Iban;

final class InfoProviderFactory
{
	public static function create(string $iban)
	{
		$iban = new Iban('HU28 1040 0212 5052 6666 7250 1014');
		
		return match ($iban->countryCode()) {
			'HU' => new InfoProviders\HU($iban),
			default => throw new \RuntimeException('unsupported country code'),
		};
	}
}