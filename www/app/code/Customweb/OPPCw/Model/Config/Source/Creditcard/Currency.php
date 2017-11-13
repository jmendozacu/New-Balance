<?php
/**
 * You are allowed to use this API in your web application.
 *
 * Copyright (C) 2016 by customweb GmbH
 *
 * This program is licenced under the customweb software licence. With the
 * purchase or the installation of the software in your application you
 * accept the licence agreement. The allowed usage is outlined in the
 * customweb software licence which can be found under
 * http://www.sellxed.com/en/software-license-agreement
 *
 * Any modification or distribution is strictly forbidden. The license
 * grants you the installation in one application. For multiuse you will need
 * to purchase further licences at http://www.sellxed.com/shop.
 *
 * See the customweb software licence agreement for more details.
 *
 *
 * @category	Customweb
 * @package		Customweb_OPPCw
 * 
 */

namespace Customweb\OPPCw\Model\Config\Source\Creditcard;

class Currency implements \Magento\Framework\Option\ArrayInterface
{
	/**
	 * @return array
	 */
	public function toOptionArray()
	{
		return [
			['value' => 'AED', 'label' => __('United Arab Emirates dirham (AED)')],
			['value' => 'ALL', 'label' => __('Albanian lek (ALL)')],
			['value' => 'AMD', 'label' => __('Armenian dram (AMD)')],
			['value' => 'ANG', 'label' => __('Netherlands Antillean guilder (ANG)')],
			['value' => 'AOA', 'label' => __('Angolan kwanza (AOA)')],
			['value' => 'ARS', 'label' => __('Argentine peso (ARS)')],
			['value' => 'AUD', 'label' => __('Australian dollar (AUD)')],
			['value' => 'AWG', 'label' => __('Aruban florin (AWG)')],
			['value' => 'BAM', 'label' => __('Bosnia and Herzegovina convertible mark (BAM)')],
			['value' => 'BBD', 'label' => __('Barbados dollar (BBD)')],
			['value' => 'BDT', 'label' => __('Bangladeshi taka (BDT)')],
			['value' => 'BGN', 'label' => __('Bulgarian lev (BGN)')],
			['value' => 'BHD', 'label' => __('Bahraini dinar (BHD)')],
			['value' => 'BIF', 'label' => __('Burundian franc (BIF)')],
			['value' => 'BMD', 'label' => __('Bermudian dollar (BMD)')],
			['value' => 'BND', 'label' => __('Brunei dollar (BND)')],
			['value' => 'BOB', 'label' => __('Boliviano (BOB)')],
			['value' => 'BRL', 'label' => __('Brazilian real (BRL)')],
			['value' => 'BSD', 'label' => __('Bahamian dollar (BSD)')],
			['value' => 'BTN', 'label' => __('Bhutanese ngultrum (BTN)')],
			['value' => 'BWP', 'label' => __('Botswana pula (BWP)')],
			['value' => 'BYR', 'label' => __('Belarusian ruble (BYR)')],
			['value' => 'BZD', 'label' => __('Belize dollar (BZD)')],
			['value' => 'CAD', 'label' => __('Canadian dollar (CAD)')],
			['value' => 'CDF', 'label' => __('Congolese franc (CDF)')],
			['value' => 'CHF', 'label' => __('Swiss franc (CHF)')],
			['value' => 'CLP', 'label' => __('Chilean peso (CLP)')],
			['value' => 'CNY', 'label' => __('Chinese yuan (CNY)')],
			['value' => 'COP', 'label' => __('Colombian peso (COP)')],
			['value' => 'CRC', 'label' => __('Costa Rican colon (CRC)')],
			['value' => 'CUP', 'label' => __('Cuban peso (CUP)')],
			['value' => 'CVE', 'label' => __('Cape Verde escudo (CVE)')],
			['value' => 'CZK', 'label' => __('Czech koruna (CZK)')],
			['value' => 'DJF', 'label' => __('Djiboutian franc (DJF)')],
			['value' => 'DKK', 'label' => __('Danish krone (DKK)')],
			['value' => 'DOP', 'label' => __('Dominican peso (DOP)')],
			['value' => 'DZD', 'label' => __('Algerian dinar (DZD)')],
			['value' => 'EGP', 'label' => __('Egyptian pound (EGP)')],
			['value' => 'ERN', 'label' => __('Eritrean nakfa (ERN)')],
			['value' => 'ETB', 'label' => __('Ethiopian birr (ETB)')],
			['value' => 'EUR', 'label' => __('Euro (EUR)')],
			['value' => 'FJD', 'label' => __('Fiji dollar (FJD)')],
			['value' => 'FKP', 'label' => __('Falkland Islands pound (FKP)')],
			['value' => 'GBP', 'label' => __('Pound sterling (GBP)')],
			['value' => 'GEL', 'label' => __('Georgian lari (GEL)')],
			['value' => 'GIP', 'label' => __('Gibraltar pound (GIP)')],
			['value' => 'GMD', 'label' => __('Gambian dalasi (GMD)')],
			['value' => 'GNF', 'label' => __('Guinean franc (GNF)')],
			['value' => 'GTQ', 'label' => __('Guatemalan quetzal (GTQ)')],
			['value' => 'GYD', 'label' => __('Guyanese dollar (GYD)')],
			['value' => 'HKD', 'label' => __('Hong Kong dollar (HKD)')],
			['value' => 'HNL', 'label' => __('Honduran lempira (HNL)')],
			['value' => 'HRK', 'label' => __('Croatian kuna (HRK)')],
			['value' => 'HTG', 'label' => __('Haitian gourde (HTG)')],
			['value' => 'HUF', 'label' => __('Hungarian forint (HUF)')],
			['value' => 'IDR', 'label' => __('Indonesian rupiah (IDR)')],
			['value' => 'ILS', 'label' => __('Israeli new shekel (ILS)')],
			['value' => 'INR', 'label' => __('Indian rupee (INR)')],
			['value' => 'IQD', 'label' => __('Iraqi dinar (IQD)')],
			['value' => 'IRR', 'label' => __('Iranian rial (IRR)')],
			['value' => 'ISK', 'label' => __('Icelandic króna (ISK)')],
			['value' => 'JMD', 'label' => __('Jamaican dollar (JMD)')],
			['value' => 'JOD', 'label' => __('Jordanian dinar (JOD)')],
			['value' => 'JPY', 'label' => __('Japanese yen (JPY)')],
			['value' => 'KES', 'label' => __('Kenyan shilling (KES)')],
			['value' => 'KGS', 'label' => __('Kyrgyzstani som (KGS)')],
			['value' => 'KHR', 'label' => __('Cambodian riel (KHR)')],
			['value' => 'KMF', 'label' => __('Comoro franc (KMF)')],
			['value' => 'KPW', 'label' => __('North Korean won (KPW)')],
			['value' => 'KRW', 'label' => __('South Korean won (KRW)')],
			['value' => 'KWD', 'label' => __('Kuwaiti dinar (KWD)')],
			['value' => 'KYD', 'label' => __('Cayman Islands dollar (KYD)')],
			['value' => 'KZT', 'label' => __('Kazakhstani tenge (KZT)')],
			['value' => 'LAK', 'label' => __('Lao kip (LAK)')],
			['value' => 'LBP', 'label' => __('Lebanese pound (LBP)')],
			['value' => 'LKR', 'label' => __('Sri Lankan rupee (LKR)')],
			['value' => 'LRD', 'label' => __('Liberian dollar (LRD)')],
			['value' => 'LSL', 'label' => __('Lesotho loti (LSL)')],
			['value' => 'LTL', 'label' => __('Lithuanian litas (LTL)')],
			['value' => 'LVL', 'label' => __('Latvian lats (LVL)')],
			['value' => 'LYD', 'label' => __('Libyan dinar (LYD)')],
			['value' => 'MAD', 'label' => __('Moroccan dirham (MAD)')],
			['value' => 'MDL', 'label' => __('Moldovan leu (MDL)')],
			['value' => 'MGA', 'label' => __('Malagasy ariary (MGA)')],
			['value' => 'MKD', 'label' => __('Macedonian denar (MKD)')],
			['value' => 'MMK', 'label' => __('Myanma kyat (MMK)')],
			['value' => 'MNT', 'label' => __('Mongolian tugrik (MNT)')],
			['value' => 'MOP', 'label' => __('Macanese pataca (MOP)')],
			['value' => 'MRO', 'label' => __('Mauritanian ouguiya (MRO)')],
			['value' => 'MUR', 'label' => __('Mauritian rupee (MUR)')],
			['value' => 'MVR', 'label' => __('Maldivian rufiyaa (MVR)')],
			['value' => 'MWK', 'label' => __('Malawian kwacha (MWK)')],
			['value' => 'MXN', 'label' => __('Mexican peso (MXN)')],
			['value' => 'MYR', 'label' => __('Malaysian ringgit (MYR)')],
			['value' => 'NAD', 'label' => __('Namibian dollar (NAD)')],
			['value' => 'NGN', 'label' => __('Nigerian naira (NGN)')],
			['value' => 'NIO', 'label' => __('Nicaraguan córdoba (NIO)')],
			['value' => 'NOK', 'label' => __('Norwegian krone (NOK)')],
			['value' => 'NPR', 'label' => __('Nepalese rupee (NPR)')],
			['value' => 'NZD', 'label' => __('New Zealand dollar (NZD)')],
			['value' => 'OMR', 'label' => __('Omani rial (OMR)')],
			['value' => 'PAB', 'label' => __('Panamanian balboa (PAB)')],
			['value' => 'PEN', 'label' => __('Peruvian nuevo sol (PEN)')],
			['value' => 'PGK', 'label' => __('Papua New Guinean kina (PGK)')],
			['value' => 'PHP', 'label' => __('Philippine peso (PHP)')],
			['value' => 'PKR', 'label' => __('Pakistani rupee (PKR)')],
			['value' => 'PLN', 'label' => __('Polish złoty (PLN)')],
			['value' => 'PYG', 'label' => __('Paraguayan guaraní (PYG)')],
			['value' => 'QAR', 'label' => __('Qatari riyal (QAR)')],
			['value' => 'RON', 'label' => __('Romanian new leu (RON)')],
			['value' => 'RUB', 'label' => __('Russian rouble (RUB)')],
			['value' => 'RWF', 'label' => __('Rwandan franc (RWF)')],
			['value' => 'SAR', 'label' => __('Saudi riyal (SAR)')],
			['value' => 'SBD', 'label' => __('Solomon Islands dollar (SBD)')],
			['value' => 'SCR', 'label' => __('Seychelles rupee (SCR)')],
			['value' => 'SEK', 'label' => __('Swedish krona (SEK)')],
			['value' => 'SGD', 'label' => __('Singapore dollar (SGD)')],
			['value' => 'SHP', 'label' => __('Saint Helena pound (SHP)')],
			['value' => 'SLL', 'label' => __('Sierra Leonean leone (SLL)')],
			['value' => 'SOS', 'label' => __('Somali shilling (SOS)')],
			['value' => 'SRD', 'label' => __('Surinamese dollar (SRD)')],
			['value' => 'STD', 'label' => __('São Tomé and Príncipe dobra (STD)')],
			['value' => 'SYP', 'label' => __('Syrian pound (SYP)')],
			['value' => 'SZL', 'label' => __('Swazi lilangeni (SZL)')],
			['value' => 'THB', 'label' => __('Thai baht (THB)')],
			['value' => 'TJS', 'label' => __('Tajikistani somoni (TJS)')],
			['value' => 'TND', 'label' => __('Tunisian dinar (TND)')],
			['value' => 'TOP', 'label' => __('Tongan paʻanga (TOP)')],
			['value' => 'TRY', 'label' => __('Turkish lira (TRY)')],
			['value' => 'TTD', 'label' => __('Trinidad and Tobago dollar (TTD)')],
			['value' => 'TWD', 'label' => __('New Taiwan dollar (TWD)')],
			['value' => 'TZS', 'label' => __('Tanzanian shilling (TZS)')],
			['value' => 'UAH', 'label' => __('Ukrainian hryvnia (UAH)')],
			['value' => 'UGX', 'label' => __('Ugandan shilling (UGX)')],
			['value' => 'USD', 'label' => __('United States dollar (USD)')],
			['value' => 'UYU', 'label' => __('Uruguayan peso (UYU)')],
			['value' => 'UZS', 'label' => __('Uzbekistan som (UZS)')],
			['value' => 'VEF', 'label' => __('Venezuelan bolívar fuerte (VEF)')],
			['value' => 'VND', 'label' => __('Vietnamese dong (VND)')],
			['value' => 'VUV', 'label' => __('Vanuatu vatu (VUV)')],
			['value' => 'WST', 'label' => __('Samoan tala (WST)')],
			['value' => 'XAF', 'label' => __('CFA franc BEAC (XAF)')],
			['value' => 'XCD', 'label' => __('East Caribbean dollar (XCD)')],
			['value' => 'XDR', 'label' => __('Special drawing rights (XDR)')],
			['value' => 'XOF', 'label' => __('CFA franc BCEAO (XOF)')],
			['value' => 'XPF', 'label' => __('CFP franc (XPF)')],
			['value' => 'YER', 'label' => __('Yemeni rial (YER)')],
			['value' => 'ZAR', 'label' => __('South African rand (ZAR)')],
		];
	}
}
