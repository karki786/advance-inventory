<?php

use Illuminate\Database\Seeder;
use App\Country;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = array(
            array('country' => 'Afghanistan', 'currency' => 'AFN'),
            array('country' => 'Albania', 'currency' => 'ALL'),
            array('country' => 'Algeria', 'currency' => 'DZD'),
            array('country' => 'American Samoa', 'currency' => 'USD'),
            array('country' => 'Andorra', 'currency' => 'EUR'),
            array('country' => 'Angola', 'currency' => 'AOA'),
            array('country' => 'Anguilla', 'currency' => 'XCD'),
            array('country' => 'Antarctica', 'currency' => 'XCD'),
            array('country' => 'Antigua and Barbuda', 'currency' => 'XCD'),
            array('country' => 'Argentina', 'currency' => 'ARS'),
            array('country' => 'Armenia', 'currency' => 'AMD'),
            array('country' => 'Aruba', 'currency' => 'AWG'),
            array('country' => 'Australia', 'currency' => 'AUD'),
            array('country' => 'Austria', 'currency' => 'EUR'),
            array('country' => 'Azerbaijan', 'currency' => 'AZN'),
            array('country' => 'Bahamas', 'currency' => 'BSD'),
            array('country' => 'Bahrain', 'currency' => 'BHD'),
            array('country' => 'Bangladesh', 'currency' => 'BDT'),
            array('country' => 'Barbados', 'currency' => 'BBD'),
            array('country' => 'Belarus', 'currency' => 'BYR'),
            array('country' => 'Belgium', 'currency' => 'EUR'),
            array('country' => 'Belize', 'currency' => 'BZD'),
            array('country' => 'Benin', 'currency' => 'XOF'),
            array('country' => 'Bermuda', 'currency' => 'BMD'),
            array('country' => 'Bhutan', 'currency' => 'BTN'),
            array('country' => 'Bolivia', 'currency' => 'BOB'),
            array('country' => 'Bosnia-Herzegovina', 'currency' => 'BAM'),
            array('country' => 'Botswana', 'currency' => 'BWP'),
            array('country' => 'Bouvet Island', 'currency' => 'NOK'),
            array('country' => 'Brazil', 'currency' => 'BRL'),
            array('country' => 'British Indian Ocean Territory', 'currency' => 'USD'),
            array('country' => 'Brunei Darussalam', 'currency' => 'BND'),
            array('country' => 'Bulgaria', 'currency' => 'BGN'),
            array('country' => 'Burkina Faso', 'currency' => 'XOF'),
            array('country' => 'Burundi', 'currency' => 'BIF'),
            array('country' => 'Cambodia', 'currency' => 'KHR'),
            array('country' => 'Cameroon', 'currency' => 'XAF'),
            array('country' => 'Canada', 'currency' => 'CAD'),
            array('country' => 'Cape Verde', 'currency' => 'CVE'),
            array('country' => 'Cayman Islands', 'currency' => 'KYD'),
            array('country' => 'Central African Republic', 'currency' => 'XAF'),
            array('country' => 'Chad', 'currency' => 'XAF'),
            array('country' => 'Chile', 'currency' => 'CLP'),
            array('country' => 'China', 'currency' => 'CNY'),
            array('country' => 'Christmas Island', 'currency' => 'AUD'),
            array('country' => 'Cocos (Keeling) Islands', 'currency' => 'AUD'),
            array('country' => 'Colombia', 'currency' => 'COP'),
            array('country' => 'Comoros', 'currency' => 'KMF'),
            array('country' => 'Congo', 'currency' => 'XAF'),
            array('country' => 'Congo, Dem. Republic', 'currency' => 'CDF'),
            array('country' => 'Cook Islands', 'currency' => 'NZD'),
            array('country' => 'Costa Rica', 'currency' => 'CRC'),
            array('country' => 'Croatia', 'currency' => 'HRK'),
            array('country' => 'Cuba', 'currency' => 'CUP'),
            array('country' => 'Cyprus', 'currency' => 'EUR'),
            array('country' => 'Czech Rep.', 'currency' => 'CZK'),
            array('country' => 'Denmark', 'currency' => 'DKK'),
            array('country' => 'Djibouti', 'currency' => 'DJF'),
            array('country' => 'Dominica', 'currency' => 'XCD'),
            array('country' => 'Dominican Republic', 'currency' => 'DOP'),
            array('country' => 'Ecuador', 'currency' => 'ECS'),
            array('country' => 'Egypt', 'currency' => 'EGP'),
            array('country' => 'El Salvador', 'currency' => 'SVC'),
            array('country' => 'Equatorial Guinea', 'currency' => 'XAF'),
            array('country' => 'Eritrea', 'currency' => 'ERN'),
            array('country' => 'Estonia', 'currency' => 'EUR'),
            array('country' => 'Ethiopia', 'currency' => 'ETB'),
            array('country' => 'European Union', 'currency' => 'EUR'),
            array('country' => 'Falkland Islands (Malvinas)', 'currency' => 'FKP'),
            array('country' => 'Faroe Islands', 'currency' => 'DKK'),
            array('country' => 'Fiji', 'currency' => 'FJD'),
            array('country' => 'Finland', 'currency' => 'EUR'),
            array('country' => 'France', 'currency' => 'EUR'),
            array('country' => 'French Guiana', 'currency' => 'EUR'),
            array('country' => 'French Southern Territories', 'currency' => 'EUR'),
            array('country' => 'Gabon', 'currency' => 'XAF'),
            array('country' => 'Gambia', 'currency' => 'GMD'),
            array('country' => 'Georgia', 'currency' => 'GEL'),
            array('country' => 'Germany', 'currency' => 'EUR'),
            array('country' => 'Ghana', 'currency' => 'GHS'),
            array('country' => 'Gibraltar', 'currency' => 'GIP'),
            array('country' => 'Great Britain', 'currency' => 'GBP'),
            array('country' => 'Greece', 'currency' => 'EUR'),
            array('country' => 'Greenland', 'currency' => 'DKK'),
            array('country' => 'Grenada', 'currency' => 'XCD'),
            array('country' => 'Guadeloupe (French)', 'currency' => 'EUR'),
            array('country' => 'Guam (USA)', 'currency' => 'USD'),
            array('country' => 'Guatemala', 'currency' => 'QTQ'),
            array('country' => 'Guernsey', 'currency' => 'GGP'),
            array('country' => 'Guinea', 'currency' => 'GNF'),
            array('country' => 'Guinea Bissau', 'currency' => 'GWP'),
            array('country' => 'Guyana', 'currency' => 'GYD'),
            array('country' => 'Haiti', 'currency' => 'HTG'),
            array('country' => 'Heard Island and McDonald Islands', 'currency' => 'AUD'),
            array('country' => 'Honduras', 'currency' => 'HNL'),
            array('country' => 'Hong Kong', 'currency' => 'HKD'),
            array('country' => 'Hungary', 'currency' => 'HUF'),
            array('country' => 'Iceland', 'currency' => 'ISK'),
            array('country' => 'India', 'currency' => 'INR'),
            array('country' => 'Indonesia', 'currency' => 'IDR'),
            array('country' => 'Iran', 'currency' => 'IRR'),
            array('country' => 'Iraq', 'currency' => 'IQD'),
            array('country' => 'Ireland', 'currency' => 'EUR'),
            array('country' => 'Isle of Man', 'currency' => 'GBP'),
            array('country' => 'Israel', 'currency' => 'ILS'),
            array('country' => 'Italy', 'currency' => 'EUR'),
            array('country' => 'Ivory Coast', 'currency' => 'XOF'),
            array('country' => 'Jamaica', 'currency' => 'JMD'),
            array('country' => 'Japan', 'currency' => 'JPY'),
            array('country' => 'Jersey', 'currency' => 'GBP'),
            array('country' => 'Jordan', 'currency' => 'JOD'),
            array('country' => 'Kazakhstan', 'currency' => 'KZT'),
            array('country' => 'Kenya', 'currency' => 'KES'),
            array('country' => 'Kiribati', 'currency' => 'AUD'),
            array('country' => 'Korea-North', 'currency' => 'KPW'),
            array('country' => 'Korea-South', 'currency' => 'KRW'),
            array('country' => 'Kuwait', 'currency' => 'KWD'),
            array('country' => 'Kyrgyzstan', 'currency' => 'KGS'),
            array('country' => 'Laos', 'currency' => 'LAK'),
            array('country' => 'Latvia', 'currency' => 'LVL'),
            array('country' => 'Lebanon', 'currency' => 'LBP'),
            array('country' => 'Lesotho', 'currency' => 'LSL'),
            array('country' => 'Liberia', 'currency' => 'LRD'),
            array('country' => 'Libya', 'currency' => 'LYD'),
            array('country' => 'Liechtenstein', 'currency' => 'CHF'),
            array('country' => 'Lithuania', 'currency' => 'LTL'),
            array('country' => 'Luxembourg', 'currency' => 'EUR'),
            array('country' => 'Macau', 'currency' => 'MOP'),
            array('country' => 'Macedonia', 'currency' => 'MKD'),
            array('country' => 'Madagascar', 'currency' => 'MGF'),
            array('country' => 'Malawi', 'currency' => 'MWK'),
            array('country' => 'Malaysia', 'currency' => 'MYR'),
            array('country' => 'Maldives', 'currency' => 'MVR'),
            array('country' => 'Mali', 'currency' => 'XOF'),
            array('country' => 'Malta', 'currency' => 'EUR'),
            array('country' => 'Marshall Islands', 'currency' => 'USD'),
            array('country' => 'Martinique (French)', 'currency' => 'EUR'),
            array('country' => 'Mauritania', 'currency' => 'MRO'),
            array('country' => 'Mauritius', 'currency' => 'MUR'),
            array('country' => 'Mayotte', 'currency' => 'EUR'),
            array('country' => 'Mexico', 'currency' => 'MXN'),
            array('country' => 'Micronesia', 'currency' => 'USD'),
            array('country' => 'Moldova', 'currency' => 'MDL'),
            array('country' => 'Monaco', 'currency' => 'EUR'),
            array('country' => 'Mongolia', 'currency' => 'MNT'),
            array('country' => 'Montenegro', 'currency' => 'EUR'),
            array('country' => 'Montserrat', 'currency' => 'XCD'),
            array('country' => 'Morocco', 'currency' => 'MAD'),
            array('country' => 'Mozambique', 'currency' => 'MZN'),
            array('country' => 'Myanmar', 'currency' => 'MMK'),
            array('country' => 'Namibia', 'currency' => 'NAD'),
            array('country' => 'Nauru', 'currency' => 'AUD'),
            array('country' => 'Nepal', 'currency' => 'NPR'),
            array('country' => 'Netherlands', 'currency' => 'EUR'),
            array('country' => 'Netherlands Antilles', 'currency' => 'ANG'),
            array('country' => 'New Caledonia (French)', 'currency' => 'XPF'),
            array('country' => 'New Zealand', 'currency' => 'NZD'),
            array('country' => 'Nicaragua', 'currency' => 'NIO'),
            array('country' => 'Niger', 'currency' => 'XOF'),
            array('country' => 'Nigeria', 'currency' => 'NGN'),
            array('country' => 'Niue', 'currency' => 'NZD'),
            array('country' => 'Norfolk Island', 'currency' => 'AUD'),
            array('country' => 'Northern Mariana Islands', 'currency' => 'USD'),
            array('country' => 'Norway', 'currency' => 'NOK'),
            array('country' => 'Oman', 'currency' => 'OMR'),
            array('country' => 'Pakistan', 'currency' => 'PKR'),
            array('country' => 'Palau', 'currency' => 'USD'),
            array('country' => 'Panama', 'currency' => 'PAB'),
            array('country' => 'Papua New Guinea', 'currency' => 'PGK'),
            array('country' => 'Paraguay', 'currency' => 'PYG'),
            array('country' => 'Peru', 'currency' => 'PEN'),
            array('country' => 'Philippines', 'currency' => 'PHP'),
            array('country' => 'Pitcairn Island', 'currency' => 'NZD'),
            array('country' => 'Poland', 'currency' => 'PLN'),
            array('country' => 'Polynesia (French)', 'currency' => 'XPF'),
            array('country' => 'Portugal', 'currency' => 'EUR'),
            array('country' => 'Puerto Rico', 'currency' => 'USD'),
            array('country' => 'Qatar', 'currency' => 'QAR'),
            array('country' => 'Reunion (French)', 'currency' => 'EUR'),
            array('country' => 'Romania', 'currency' => 'RON'),
            array('country' => 'Russia', 'currency' => 'RUB'),
            array('country' => 'Rwanda', 'currency' => 'RWF'),
            array('country' => 'Saint Helena', 'currency' => 'SHP'),
            array('country' => 'Saint Kitts & Nevis Anguilla', 'currency' => 'XCD'),
            array('country' => 'Saint Lucia', 'currency' => 'XCD'),
            array('country' => 'Saint Pierre and Miquelon', 'currency' => 'EUR'),
            array('country' => 'Saint Vincent & Grenadines', 'currency' => 'XCD'),
            array('country' => 'Samoa', 'currency' => 'WST'),
            array('country' => 'San Marino', 'currency' => 'EUR'),
            array('country' => 'Sao Tome and Principe', 'currency' => 'STD'),
            array('country' => 'Saudi Arabia', 'currency' => 'SAR'),
            array('country' => 'Senegal', 'currency' => 'XOF'),
            array('country' => 'Serbia', 'currency' => 'RSD'),
            array('country' => 'Seychelles', 'currency' => 'SCR'),
            array('country' => 'Sierra Leone', 'currency' => 'SLL'),
            array('country' => 'Singapore', 'currency' => 'SGD'),
            array('country' => 'Slovakia', 'currency' => 'EUR'),
            array('country' => 'Slovenia', 'currency' => 'EUR'),
            array('country' => 'Solomon Islands', 'currency' => 'SBD'),
            array('country' => 'Somalia', 'currency' => 'SOS'),
            array('country' => 'South Africa', 'currency' => 'ZAR'),
            array('country' => 'South Georgia & South Sandwich Islands', 'currency' => 'GBP'),
            array('country' => 'South Sudan', 'currency' => 'SSP'),
            array('country' => 'Spain', 'currency' => 'EUR'),
            array('country' => 'Sri Lanka', 'currency' => 'LKR'),
            array('country' => 'Sudan', 'currency' => 'SDG'),
            array('country' => 'Suriname', 'currency' => 'SRD'),
            array('country' => 'Svalbard and Jan Mayen Islands', 'currency' => 'NOK'),
            array('country' => 'Swaziland', 'currency' => 'SZL'),
            array('country' => 'Sweden', 'currency' => 'SEK'),
            array('country' => 'Switzerland', 'currency' => 'CHF'),
            array('country' => 'Syria', 'currency' => 'SYP'),
            array('country' => 'Taiwan', 'currency' => 'TWD'),
            array('country' => 'Tajikistan', 'currency' => 'TJS'),
            array('country' => 'Tanzania', 'currency' => 'TZS'),
            array('country' => 'Thailand', 'currency' => 'THB'),
            array('country' => 'Togo', 'currency' => 'XOF'),
            array('country' => 'Tokelau', 'currency' => 'NZD'),
            array('country' => 'Tonga', 'currency' => 'TOP'),
            array('country' => 'Trinidad and Tobago', 'currency' => 'TTD'),
            array('country' => 'Tunisia', 'currency' => 'TND'),
            array('country' => 'Turkey', 'currency' => 'TRY'),
            array('country' => 'Turkmenistan', 'currency' => 'TMT'),
            array('country' => 'Turks and Caicos Islands', 'currency' => 'USD'),
            array('country' => 'Tuvalu', 'currency' => 'AUD'),
            array('country' => 'U.K.', 'currency' => 'GBP'),
            array('country' => 'Uganda', 'currency' => 'UGX'),
            array('country' => 'Ukraine', 'currency' => 'UAH'),
            array('country' => 'United Arab Emirates', 'currency' => 'AED'),
            array('country' => 'Uruguay', 'currency' => 'UYU'),
            array('country' => 'USA', 'currency' => 'USD'),
            array('country' => 'USA Minor Outlying Islands', 'currency' => 'USD'),
            array('country' => 'Uzbekistan', 'currency' => 'UZS'),
            array('country' => 'Vanuatu', 'currency' => 'VUV'),
            array('country' => 'Vatican', 'currency' => 'EUR'),
            array('country' => 'Venezuela', 'currency' => 'VEF'),
            array('country' => 'Vietnam', 'currency' => 'VND'),
            array('country' => 'Virgin Islands (British)', 'currency' => 'USD'),
            array('country' => 'Virgin Islands (USA)', 'currency' => 'USD'),
            array('country' => 'Wallis and Futuna Islands', 'currency' => 'XPF'),
            array('country' => 'Western Sahara', 'currency' => 'MAD'),
            array('country' => 'Yemen', 'currency' => 'YER'),
            array('country' => 'Zambia', 'currency' => 'ZMW'),
            array('country' => 'Zimbabwe', 'currency' => 'ZWD'),

        );

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}