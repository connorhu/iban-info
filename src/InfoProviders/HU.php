<?php

namespace Iban\Info\InfoProviders;

use Iban\Info\InfoProviderInterface;
use Iban\Info\InfoMeta;
use Iban\Validation\Iban;

final class HU implements InfoProviderInterface
{
	public function __construct(private readonly Iban $iban)
	{
	}
	
	private function bankIdToSwiftCode(int $code): string
	{
		return match ($code) {
			104 => 'OKHBHUHB',
		};
	}
	
	private function swiftCodeToBankName(string $swift): string
	{
		return match ($swift) {
			'OKHBHUHB' => 'K&H Bank Zrt.',
		};
	}
	
	private function swiftCodeToBankAddress(string $swift): string
	{
		return match ($swift) {
			'OKHBHUHB' => 'H-1095 Budapest, Lechner Ödön fasor 9.',
		};
	}
	
	public function getInfo(): InfoMeta
	{
		$info = new InfoMeta();
		
		$bankId = (int) $this->iban->bbanBankIdentifier();
		
		$info->swiftCode = $this->bankIdToSwiftCode($bankId);
		$info->bankName = $this->swiftCodeToBankName($info->swiftCode);
		$info->bankAddress = $this->swiftCodeToBankAddress($info->swiftCode);
		
		return $info;
	}
}