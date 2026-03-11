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
			101, 103, 121 => 'MKKBHUHB', // MBH Bank (legacy Budapest Bank / MKB / Takarékbank GIRO prefixes)
			102, 116 => 'GIBAHUHB', // Erste Bank Hungary
			104 => 'OKHBHUHB',
			106 => 'GRITHUHB',
			107 => 'CIBHHUHB',
			109 => 'BACXHUHB',
			117 => 'OTPVHUHB',
			120 => 'UBRTHUHB',
			162 => 'HBWEHUHB',
			default => '',
		};
	}
	
	private function swiftCodeToBankName(string $swift): string
	{
		return match ($swift) {
			'MKKBHUHB' => 'MBH Bank Nyrt.',
			'GIBAHUHB' => 'Erste Bank Hungary Zrt.',
			'OKHBHUHB' => 'K&H Bank Zrt.',
			'GRITHUHB' => 'Gránit Bank Nyrt.',
			'CIBHHUHB' => 'CIB Bank Zrt.',
			'BACXHUHB' => 'UniCredit Bank Hungary Zrt.',
			'OTPVHUHB' => 'OTP Bank Nyrt.',
			'UBRTHUHB' => 'Raiffeisen Bank Zrt.',
			'HBWEHUHB' => 'MagNet Bank Zrt.',
			default => '',
		};
	}
	
	private function swiftCodeToBankAddress(string $swift): string
	{
		return match ($swift) {
			'MKKBHUHB' => 'H-1056 Budapest, Váci utca 38.',
			'GIBAHUHB' => 'H-1138 Budapest, Népfürdő utca 24-26.',
			'OKHBHUHB' => 'H-1095 Budapest, Lechner Ödön fasor 9.',
			'GRITHUHB' => 'H-1095 Budapest, Lechner Ödön fasor 8.',
			'CIBHHUHB' => 'H-1027 Budapest, Medve utca 4-14.',
			'BACXHUHB' => 'H-1054 Budapest, Szabadság tér 5-6.',
			'OTPVHUHB' => 'H-1051 Budapest, Nádor utca 16.',
			'UBRTHUHB' => 'H-1133 Budapest, Váci út 116-118.',
			'HBWEHUHB' => 'H-1062 Budapest, Andrássy út 98.',
			default => '',
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
