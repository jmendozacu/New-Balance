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

class Country implements \Magento\Framework\Option\ArrayInterface
{
	/**
	 * @return array
	 */
	public function toOptionArray()
	{
		return [
			['value' => 'AD', 'label' => __('Andorra')],
			['value' => 'AE', 'label' => __('United Arab Emirates')],
			['value' => 'AF', 'label' => __('Afghanistan')],
			['value' => 'AG', 'label' => __('Antigua & Barbuda')],
			['value' => 'AI', 'label' => __('Anguilla')],
			['value' => 'AL', 'label' => __('Albania')],
			['value' => 'AM', 'label' => __('Armenia')],
			['value' => 'AN', 'label' => __('Netherlands Antilles')],
			['value' => 'AO', 'label' => __('Angola')],
			['value' => 'AQ', 'label' => __('Antarctica')],
			['value' => 'AR', 'label' => __('Argentina')],
			['value' => 'AS', 'label' => __('American Samoa')],
			['value' => 'AT', 'label' => __('Austria')],
			['value' => 'AU', 'label' => __('Australia')],
			['value' => 'AW', 'label' => __('Aruba')],
			['value' => 'AX', 'label' => __('Aland Islands')],
			['value' => 'AZ', 'label' => __('Azerbaijan')],
			['value' => 'BA', 'label' => __('Bosnia & Herzegovina')],
			['value' => 'BB', 'label' => __('Barbados')],
			['value' => 'BD', 'label' => __('Bangladesh')],
			['value' => 'BE', 'label' => __('Belgium')],
			['value' => 'BF', 'label' => __('Burkina Faso')],
			['value' => 'BG', 'label' => __('Bulgaria')],
			['value' => 'BH', 'label' => __('Bahrain')],
			['value' => 'BI', 'label' => __('Burundi')],
			['value' => 'BJ', 'label' => __('Benin')],
			['value' => 'BM', 'label' => __('Bermuda')],
			['value' => 'BN', 'label' => __('Brunei Darussalam')],
			['value' => 'BO', 'label' => __('Bolivia')],
			['value' => 'BR', 'label' => __('Brazil')],
			['value' => 'BS', 'label' => __('Bahamas')],
			['value' => 'BT', 'label' => __('Bhutan')],
			['value' => 'BV', 'label' => __('Bouvet Island')],
			['value' => 'BW', 'label' => __('Botswana')],
			['value' => 'BY', 'label' => __('Belarus')],
			['value' => 'BZ', 'label' => __('Belize')],
			['value' => 'CA', 'label' => __('Canada')],
			['value' => 'CC', 'label' => __('Cocos (Keeling) Islands')],
			['value' => 'CD', 'label' => __('Zaire')],
			['value' => 'CF', 'label' => __('Central African Republic')],
			['value' => 'CG', 'label' => __('Congo')],
			['value' => 'CH', 'label' => __('Switzerland')],
			['value' => 'CI', 'label' => __('Cote D\'ivoire')],
			['value' => 'CK', 'label' => __('Cook Islands')],
			['value' => 'CL', 'label' => __('Chile')],
			['value' => 'CM', 'label' => __('Cameroon')],
			['value' => 'CN', 'label' => __('China')],
			['value' => 'CO', 'label' => __('Colombia')],
			['value' => 'CR', 'label' => __('Costa Rica')],
			['value' => 'CU', 'label' => __('Cuba')],
			['value' => 'CV', 'label' => __('Cape Verde')],
			['value' => 'CX', 'label' => __('Christmas Island')],
			['value' => 'CY', 'label' => __('Cyprus')],
			['value' => 'CZ', 'label' => __('Czech Republic')],
			['value' => 'DE', 'label' => __('Germany')],
			['value' => 'DJ', 'label' => __('Djibouti')],
			['value' => 'DK', 'label' => __('Denmark')],
			['value' => 'DM', 'label' => __('Dominica')],
			['value' => 'DO', 'label' => __('Dominican Republic')],
			['value' => 'DZ', 'label' => __('Algeria')],
			['value' => 'EC', 'label' => __('Ecuador')],
			['value' => 'EE', 'label' => __('Estonia')],
			['value' => 'EG', 'label' => __('Egypt')],
			['value' => 'EH', 'label' => __('Western Sahara')],
			['value' => 'ER', 'label' => __('Eritrea')],
			['value' => 'ES', 'label' => __('Spain')],
			['value' => 'ET', 'label' => __('Ethiopia')],
			['value' => 'FI', 'label' => __('Finland')],
			['value' => 'FJ', 'label' => __('Fiji')],
			['value' => 'FK', 'label' => __('Falkland Islands')],
			['value' => 'FM', 'label' => __('Micronesia')],
			['value' => 'FO', 'label' => __('Faroe Islands')],
			['value' => 'FR', 'label' => __('France')],
			['value' => 'GA', 'label' => __('Gabon')],
			['value' => 'GB', 'label' => __('United Kingdom')],
			['value' => 'GD', 'label' => __('Grenada')],
			['value' => 'GE', 'label' => __('Georgia')],
			['value' => 'GF', 'label' => __('French Guiana')],
			['value' => 'GG', 'label' => __('Guernsey')],
			['value' => 'GH', 'label' => __('Ghana')],
			['value' => 'GI', 'label' => __('Gibraltar')],
			['value' => 'GL', 'label' => __('Greenland')],
			['value' => 'GM', 'label' => __('Gambia')],
			['value' => 'GN', 'label' => __('Guinea')],
			['value' => 'GP', 'label' => __('Guadeloupe')],
			['value' => 'GQ', 'label' => __('Equatorial Guinea')],
			['value' => 'GR', 'label' => __('Greece')],
			['value' => 'GS', 'label' => __('S.Georgia & S.Sandwich Islands')],
			['value' => 'GT', 'label' => __('Guatemala')],
			['value' => 'GU', 'label' => __('Guam')],
			['value' => 'GW', 'label' => __('Guinea-Bissau')],
			['value' => 'GY', 'label' => __('Guyana')],
			['value' => 'HK', 'label' => __('Hong Kong')],
			['value' => 'HM', 'label' => __('Heard & McDonald Islands')],
			['value' => 'HN', 'label' => __('Honduras')],
			['value' => 'HR', 'label' => __('Croatia')],
			['value' => 'HT', 'label' => __('Haiti')],
			['value' => 'HU', 'label' => __('Hungary')],
			['value' => 'ID', 'label' => __('Indonesia')],
			['value' => 'IE', 'label' => __('Ireland')],
			['value' => 'IL', 'label' => __('Israel')],
			['value' => 'IM', 'label' => __('Isle of Man')],
			['value' => 'IN', 'label' => __('India')],
			['value' => 'IO', 'label' => __('British Indian Ocean Territory')],
			['value' => 'IQ', 'label' => __('Iraq')],
			['value' => 'IR', 'label' => __('Iran')],
			['value' => 'IS', 'label' => __('Iceland')],
			['value' => 'IT', 'label' => __('Italy')],
			['value' => 'JE', 'label' => __('Jersey')],
			['value' => 'JM', 'label' => __('Jamaica')],
			['value' => 'JO', 'label' => __('Jordan')],
			['value' => 'JP', 'label' => __('Japan')],
			['value' => 'KE', 'label' => __('Kenya')],
			['value' => 'KG', 'label' => __('Kyrgyzstan')],
			['value' => 'KH', 'label' => __('Cambodia')],
			['value' => 'KI', 'label' => __('Kiribati')],
			['value' => 'KM', 'label' => __('Comoros')],
			['value' => 'KN', 'label' => __('Saint Kitts & Nevis')],
			['value' => 'KP', 'label' => __('Korea')],
			['value' => 'KR', 'label' => __('Korea')],
			['value' => 'KW', 'label' => __('Kuwait')],
			['value' => 'KY', 'label' => __('Cayman Islands')],
			['value' => 'KZ', 'label' => __('Kazakhstan')],
			['value' => 'LA', 'label' => __('Laos')],
			['value' => 'LB', 'label' => __('Lebanon')],
			['value' => 'LC', 'label' => __('Saint Lucia')],
			['value' => 'LI', 'label' => __('Liechtenstein')],
			['value' => 'LK', 'label' => __('Sri Lanka')],
			['value' => 'LR', 'label' => __('Liberia')],
			['value' => 'LS', 'label' => __('Lesotho')],
			['value' => 'LT', 'label' => __('Lithuania')],
			['value' => 'LU', 'label' => __('Luxembourg')],
			['value' => 'LV', 'label' => __('Latvia')],
			['value' => 'LY', 'label' => __('Libya')],
			['value' => 'MA', 'label' => __('Morocco')],
			['value' => 'MC', 'label' => __('Monaco')],
			['value' => 'MD', 'label' => __('Moldova')],
			['value' => 'MG', 'label' => __('Madagascar')],
			['value' => 'MH', 'label' => __('Marshall Islands')],
			['value' => 'MK', 'label' => __('Macedonia')],
			['value' => 'ML', 'label' => __('Mali')],
			['value' => 'MM', 'label' => __('Myanmar')],
			['value' => 'MN', 'label' => __('Mongolia')],
			['value' => 'MO', 'label' => __('Macau')],
			['value' => 'MP', 'label' => __('Northern Mariana Islands')],
			['value' => 'MQ', 'label' => __('Martinique')],
			['value' => 'MR', 'label' => __('Mauritania')],
			['value' => 'MS', 'label' => __('Montserrat')],
			['value' => 'MT', 'label' => __('Malta')],
			['value' => 'MU', 'label' => __('Mauritius')],
			['value' => 'MV', 'label' => __('Maldives')],
			['value' => 'MW', 'label' => __('Malawi')],
			['value' => 'MX', 'label' => __('Mexico')],
			['value' => 'MY', 'label' => __('Malaysia')],
			['value' => 'MZ', 'label' => __('Mozambique')],
			['value' => 'NA', 'label' => __('Namibia')],
			['value' => 'NC', 'label' => __('New Caledonia')],
			['value' => 'NE', 'label' => __('Niger')],
			['value' => 'NF', 'label' => __('Norfolk Island')],
			['value' => 'NG', 'label' => __('Nigeria')],
			['value' => 'NI', 'label' => __('Nicaragua')],
			['value' => 'NL', 'label' => __('Netherlands')],
			['value' => 'NO', 'label' => __('Norway')],
			['value' => 'NP', 'label' => __('Nepal')],
			['value' => 'NR', 'label' => __('Nauru')],
			['value' => 'NU', 'label' => __('Niue')],
			['value' => 'NZ', 'label' => __('New Zealand')],
			['value' => 'OM', 'label' => __('Oman')],
			['value' => 'PA', 'label' => __('Panama')],
			['value' => 'PE', 'label' => __('Peru')],
			['value' => 'PF', 'label' => __('French Polynesia')],
			['value' => 'PG', 'label' => __('Papua New Guinea')],
			['value' => 'PH', 'label' => __('Philippines')],
			['value' => 'PK', 'label' => __('Pakistan')],
			['value' => 'PL', 'label' => __('Poland')],
			['value' => 'PM', 'label' => __('St. Pierre & Miquelon')],
			['value' => 'PN', 'label' => __('Pitcairn')],
			['value' => 'PR', 'label' => __('Puerto Rico')],
			['value' => 'PT', 'label' => __('Portugal')],
			['value' => 'PW', 'label' => __('Palau')],
			['value' => 'PY', 'label' => __('Paraguay')],
			['value' => 'QA', 'label' => __('Qatar')],
			['value' => 'RE', 'label' => __('Reunion')],
			['value' => 'RO', 'label' => __('Romania')],
			['value' => 'RU', 'label' => __('Russian Federation')],
			['value' => 'RW', 'label' => __('Rwanda')],
			['value' => 'SA', 'label' => __('Saudi Arabia')],
			['value' => 'SB', 'label' => __('Solomon Islands')],
			['value' => 'SC', 'label' => __('Seychelles')],
			['value' => 'SD', 'label' => __('Sudan')],
			['value' => 'SE', 'label' => __('Sweden')],
			['value' => 'SG', 'label' => __('Singapore')],
			['value' => 'SI', 'label' => __('Slovenia')],
			['value' => 'SJ', 'label' => __('Svalbard & Jan Mayen Islands')],
			['value' => 'SK', 'label' => __('Slovak Republic')],
			['value' => 'SL', 'label' => __('Sierra Leone')],
			['value' => 'SM', 'label' => __('San Marino')],
			['value' => 'SN', 'label' => __('Senegal')],
			['value' => 'SO', 'label' => __('Somalia')],
			['value' => 'SR', 'label' => __('Suriname')],
			['value' => 'ST', 'label' => __('Sao Tome & Principe')],
			['value' => 'SV', 'label' => __('El Salvador')],
			['value' => 'SY', 'label' => __('Syria')],
			['value' => 'SZ', 'label' => __('Swaziland')],
			['value' => 'TC', 'label' => __('Turks & Caicos Islands')],
			['value' => 'TD', 'label' => __('Chad')],
			['value' => 'TF', 'label' => __('French Southern Territories')],
			['value' => 'TG', 'label' => __('Togo')],
			['value' => 'TH', 'label' => __('Thailand')],
			['value' => 'TJ', 'label' => __('Tajikistan')],
			['value' => 'TK', 'label' => __('Tokelau')],
			['value' => 'TM', 'label' => __('Turkmenistan')],
			['value' => 'TN', 'label' => __('Tunisia')],
			['value' => 'TO', 'label' => __('Tonga')],
			['value' => 'TP', 'label' => __('East Timor')],
			['value' => 'TR', 'label' => __('Turkey')],
			['value' => 'TT', 'label' => __('Trinidad & Tobago')],
			['value' => 'TV', 'label' => __('Tuvalu')],
			['value' => 'TW', 'label' => __('Taiwan')],
			['value' => 'TZ', 'label' => __('Tanzania')],
			['value' => 'UA', 'label' => __('Ukraine')],
			['value' => 'UG', 'label' => __('Uganda')],
			['value' => 'US', 'label' => __('United States')],
			['value' => 'UY', 'label' => __('Uruguay')],
			['value' => 'UZ', 'label' => __('Uzbekistan')],
			['value' => 'VA', 'label' => __('Vatican City')],
			['value' => 'VC', 'label' => __('St. Vincent & the Grenadines')],
			['value' => 'VE', 'label' => __('Venezuela')],
			['value' => 'VG', 'label' => __('Virgin Islands')],
			['value' => 'VI', 'label' => __('Virgin Islands')],
			['value' => 'VN', 'label' => __('Viet Nam')],
			['value' => 'VU', 'label' => __('Vanuatu')],
			['value' => 'WF', 'label' => __('Wallis & Futuna Islands')],
			['value' => 'WS', 'label' => __('Samoa')],
			['value' => 'YE', 'label' => __('Yemen')],
			['value' => 'YT', 'label' => __('Mayotte')],
			['value' => 'ZA', 'label' => __('South Africa')],
			['value' => 'ZM', 'label' => __('Zambia')],
			['value' => 'ZW', 'label' => __('Zimbabwe')],
			['value' => 'BQ', 'label' => __('Caribbean Netherlands')],
			['value' => 'CW', 'label' => __('Curaçao')],
			['value' => 'ME', 'label' => __('Montenegro')],
			['value' => 'RS', 'label' => __('Serbia')],
			['value' => 'SH', 'label' => __('Saint Helena, Ascension and Tristan da Cunha')],
			['value' => 'SS', 'label' => __('South Sudan')],
			['value' => 'SX', 'label' => __('Sint Maarten')],
			['value' => 'TL', 'label' => __('Timor-Leste')],
		];
	}
}
