<?php

if (! defined('BASEPATH')) exit('No direct script access allowed');

use GB\ReactProject\Helper\TemplateHelper;

class React_project_mcp
{
    public $name        = 'React Project';
    public $version     = '1.0.0';
    public $short_name  = 'react_project';
    public $class_name  = 'React_project';


    public function index()
    {
        ee()->load->helper('form');

        $settings = [
            'id' => 'new',
            'code' => '',
            'displayText' => 'Display Text',
            'backgroundColour' => '#ffce1f',
            'displayFormat' => 'top_left',
            'displayFormatOptions' => [
                ['value' => 'top_left', 'label' => 'Top Left'],
                ['value' => 'top_right', 'label' => 'Top Right'],
                ['value' => 'bottom_left', 'label' => 'Bottom Left'],
                ['value' => 'bottom_right', 'label' => 'Bottom Right'],
            ],
            'country' => '',
            'countryOptions' => $this->loadCountries(),
        ];

        $vars['sections'] = [
            'Settings' => [
                [
                    'title' => 'name',
                    'fields' => [
                        'name' => [
                            'type' => 'text',
                            'class' => 'name',
                            'value' => '',
                            'required' => true,
                        ],
                    ],
                ],
                [
                    'fields' => [
                        'settings' => [
                            'type' => 'html',
                            'content' => '<div class="react-project" data-react_project="' . htmlspecialchars(json_encode($settings), ENT_QUOTES, 'UTF-8')  . '"></div>',
                        ],
                    ],
                ],
                [
                    'title' => 'trigger',
                    'fields' => [
                        'trigger' => [
                            'type' => 'checkbox',
                            'value' => '',
                            'choices' => ['yes' => lang('run_submit_hook')],
                            'required' => true,
                        ],
                    ],
                ],
            ],
        ];

        $vars += [
            'base_url' => ee('CP/URL', 'addons/settings/react_project/submit'),
            'cp_page_title' => lang('text_demonstration'),
            'save_btn_text' => sprintf(lang('btn_save'), 'ettings'),
            'save_btn_text_working' => 'btn_saving',
        ];

        $version = $this->version;

        if (true) { // Dev mode
            $version = time();
        }

        ee()->cp->add_to_head('<link rel="stylesheet" type="text/css" href="' . URL_THIRD_THEMES . $this->short_name . '/css/app.css?v=' . $version . '"/>');
        $additional_js = '<script src="' . URL_THIRD_THEMES . $this->short_name . '/js/app.js?v=' . $version . '"></script>';

        $template_block = new TemplateHelper;
        $template_block->getCodeMirrorAssets('code_block_temp');

        ee()->cp->load_package_js('example');

        ee()->javascript->output("
            console.log('-- ee()->javascript->output() --');

            const submitHook = new Event('submitHook');

            let cmCodeBlockInterval = setInterval(cmCodeBlock, 100);
            function cmCodeBlock() {
                if ($('#code_block').length > 0) {
                    $('#code_block').toggleCodeMirror();
                    const elementCodeBlock = document.getElementById('code_block');
                    const cmRef = $('#code_block').data('codemirror.editor');

                    cmRef.getDoc().setValue(elementCodeBlock.value);

                    const nativeTextAreaValueSetter = Object.getOwnPropertyDescriptor(window.HTMLTextAreaElement.prototype, 'value').set;

                    const eventValueChange = new Event('input');

                    cmRef.on('change', editor => {
                        nativeTextAreaValueSetter.call(elementCodeBlock, editor.getValue());
                        elementCodeBlock.dispatchEvent(eventValueChange);
                    });
                    clearInterval(cmCodeBlockInterval);
                    console.log('-- CodeMirror Attached --');
                }
            }

            const updateCodeMirrorValue = (run) => {
                if (run) {
                    const elementCodeBlock = document.getElementById('code_block');
                    const cmRef = $('#code_block').data('codemirror.editor');
                    cmRef.getDoc().setValue(elementCodeBlock.value);
                }
            }
            $(document).on('click', '.button[type=\"submit\"]', function (e) {
                e.preventDefault();

                if ($('input[name=\"trigger\"]:checked').val() !== 'yes') {
                    document.dispatchEvent(submitHook);
                }
                updateCodeMirrorValue(true);
                $(this).closest('form').submit();
            }).ready(function () {
                console.log('-- jQuery document ready --');
            });
        ");

        $additional_css = '<style>.CodeMirror-sizer { margin-left: 29px !important; } .CodeMirror-lineNumber { left: -29px !important; } .custom_code_block .CodeMirror { min-height: 360px; }</style>';

        return [
            'heading'       => $vars['cp_page_title'],
            'body'          => $additional_css . ee('View')->make('ee:_shared/form')->render($vars) . $additional_js,
            'breadcrumb'    => [
                ee('CP/URL', 'addons/settings/react_project')->compile() => lang('react_project_name'),
                ee('CP/URL', 'addons/settings/react_project')->compile() => lang('text_demonstration'),
            ],
        ];
    }

    public function submit()
    {
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        die;
    }

    private function loadCountries()
    {
        return [
            ['value' => 'AF', 'label' => 'Afghanistan'],
            ['value' => 'AX', 'label' => 'Aland Islands'],
            ['value' => 'AL', 'label' => 'Albania'],
            ['value' => 'DZ', 'label' => 'Algeria'],
            ['value' => 'AS', 'label' => 'American Samoa'],
            ['value' => 'AD', 'label' => 'Andorra'],
            ['value' => 'AO', 'label' => 'Angola'],
            ['value' => 'AI', 'label' => 'Anguilla'],
            ['value' => 'AQ', 'label' => 'Antarctica'],
            ['value' => 'AG', 'label' => 'Antigua and Barbuda'],
            ['value' => 'AR', 'label' => 'Argentina'],
            ['value' => 'AM', 'label' => 'Armenia'],
            ['value' => 'AW', 'label' => 'Aruba'],
            ['value' => 'AU', 'label' => 'Australia'],
            ['value' => 'AT', 'label' => 'Austria'],
            ['value' => 'AZ', 'label' => 'Azerbaijan'],
            ['value' => 'BS', 'label' => 'Bahamas'],
            ['value' => 'BH', 'label' => 'Bahrain'],
            ['value' => 'BD', 'label' => 'Bangladesh'],
            ['value' => 'BB', 'label' => 'Barbados'],
            ['value' => 'BY', 'label' => 'Belarus'],
            ['value' => 'BE', 'label' => 'Belgium'],
            ['value' => 'BZ', 'label' => 'Belize'],
            ['value' => 'BJ', 'label' => 'Benin'],
            ['value' => 'BM', 'label' => 'Bermuda'],
            ['value' => 'BT', 'label' => 'Bhutan'],
            ['value' => 'BO', 'label' => 'Bolivia'],
            ['value' => 'BQ', 'label' => 'Bonaire, Sint Eustatius and Saba'],
            ['value' => 'BA', 'label' => 'Bosnia and Herzegovina'],
            ['value' => 'BW', 'label' => 'Botswana'],
            ['value' => 'BV', 'label' => 'Bouvet Island'],
            ['value' => 'BR', 'label' => 'Brazil'],
            ['value' => 'IO', 'label' => 'British Indian Ocean Territory'],
            ['value' => 'BN', 'label' => 'Brunei Darussalam'],
            ['value' => 'BG', 'label' => 'Bulgaria'],
            ['value' => 'BF', 'label' => 'Burkina Faso'],
            ['value' => 'MM', 'label' => 'Burma (Myanmar)'],
            ['value' => 'BI', 'label' => 'Burundi'],
            ['value' => 'KH', 'label' => 'Cambodia'],
            ['value' => 'CM', 'label' => 'Cameroon'],
            ['value' => 'CA', 'label' => 'Canada'],
            ['value' => 'CV', 'label' => 'Cape Verde'],
            ['value' => 'KY', 'label' => 'Cayman Islands'],
            ['value' => 'CF', 'label' => 'Central African Republic'],
            ['value' => 'TD', 'label' => 'Chad'],
            ['value' => 'CL', 'label' => 'Chile'],
            ['value' => 'CN', 'label' => 'China'],
            ['value' => 'CX', 'label' => 'Christmas Island'],
            ['value' => 'CC', 'label' => 'Cocos (Keeling) Islands'],
            ['value' => 'CO', 'label' => 'Colombia'],
            ['value' => 'KM', 'label' => 'Comoros'],
            ['value' => 'CG', 'label' => 'Congo'],
            ['value' => 'CK', 'label' => 'Cook Islands'],
            ['value' => 'CR', 'label' => 'Costa Rica'],
            ['value' => 'HR', 'label' => 'Croatia (Hrvatska)'],
            ['value' => 'CU', 'label' => 'Cuba'],
            ['value' => 'CW', 'label' => 'Curacao'],
            ['value' => 'CY', 'label' => 'Cyprus'],
            ['value' => 'CZ', 'label' => 'Czech Republic'],
            ['value' => 'CD', 'label' => 'Democratic Republic of Congo'],
            ['value' => 'DK', 'label' => 'Denmark'],
            ['value' => 'DJ', 'label' => 'Djibouti'],
            ['value' => 'DM', 'label' => 'Dominica'],
            ['value' => 'DO', 'label' => 'Dominican Republic'],
            ['value' => 'EC', 'label' => 'Ecuador'],
            ['value' => 'EG', 'label' => 'Egypt'],
            ['value' => 'SV', 'label' => 'El Salvador'],
            ['value' => 'GQ', 'label' => 'Equatorial Guinea'],
            ['value' => 'ER', 'label' => 'Eritrea'],
            ['value' => 'EE', 'label' => 'Estonia'],
            ['value' => 'ET', 'label' => 'Ethiopia'],
            ['value' => 'FK', 'label' => 'Falkland Islands (Malvinas)'],
            ['value' => 'FO', 'label' => 'Faroe Islands'],
            ['value' => 'FJ', 'label' => 'Fiji'],
            ['value' => 'FI', 'label' => 'Finland'],
            ['value' => 'FR', 'label' => 'France'],
            ['value' => 'GF', 'label' => 'French Guiana'],
            ['value' => 'PF', 'label' => 'French Polynesia'],
            ['value' => 'TF', 'label' => 'French Southern Territories'],
            ['value' => 'GA', 'label' => 'Gabon'],
            ['value' => 'GM', 'label' => 'Gambia'],
            ['value' => 'GE', 'label' => 'Georgia'],
            ['value' => 'DE', 'label' => 'Germany'],
            ['value' => 'GH', 'label' => 'Ghana'],
            ['value' => 'GI', 'label' => 'Gibraltar'],
            ['value' => 'GR', 'label' => 'Greece'],
            ['value' => 'GL', 'label' => 'Greenland'],
            ['value' => 'GD', 'label' => 'Grenada'],
            ['value' => 'GP', 'label' => 'Guadeloupe'],
            ['value' => 'GU', 'label' => 'Guam'],
            ['value' => 'GT', 'label' => 'Guatemala'],
            ['value' => 'GG', 'label' => 'Guernsey'],
            ['value' => 'GN', 'label' => 'Guinea'],
            ['value' => 'GW', 'label' => 'Guinea-Bissau'],
            ['value' => 'GY', 'label' => 'Guyana'],
            ['value' => 'HT', 'label' => 'Haiti'],
            ['value' => 'HM', 'label' => 'Heard and McDonald Islands'],
            ['value' => 'HN', 'label' => 'Honduras'],
            ['value' => 'HK', 'label' => 'Hong Kong'],
            ['value' => 'HU', 'label' => 'Hungary'],
            ['value' => 'IS', 'label' => 'Iceland'],
            ['value' => 'IN', 'label' => 'India'],
            ['value' => 'ID', 'label' => 'Indonesia'],
            ['value' => 'IR', 'label' => 'Iran'],
            ['value' => 'IQ', 'label' => 'Iraq'],
            ['value' => 'IE', 'label' => 'Ireland'],
            ['value' => 'IM', 'label' => 'Isle Of Man'],
            ['value' => 'IL', 'label' => 'Israel'],
            ['value' => 'IT', 'label' => 'Italy'],
            ['value' => 'CI', 'label' => 'Ivory Coast'],
            ['value' => 'JM', 'label' => 'Jamaica'],
            ['value' => 'JP', 'label' => 'Japan'],
            ['value' => 'JE', 'label' => 'Jersey'],
            ['value' => 'JO', 'label' => 'Jordan'],
            ['value' => 'KZ', 'label' => 'Kazakhstan'],
            ['value' => 'KE', 'label' => 'Kenya'],
            ['value' => 'KI', 'label' => 'Kiribati'],
            ['value' => 'KP', 'label' => 'Korea (North)'],
            ['value' => 'KR', 'label' => 'Korea (South)'],
            ['value' => 'KW', 'label' => 'Kuwait'],
            ['value' => 'KG', 'label' => 'Kyrgyzstan'],
            ['value' => 'LA', 'label' => 'Laos'],
            ['value' => 'LV', 'label' => 'Latvia'],
            ['value' => 'LB', 'label' => 'Lebanon'],
            ['value' => 'LS', 'label' => 'Lesotho'],
            ['value' => 'LR', 'label' => 'Liberia'],
            ['value' => 'LY', 'label' => 'Libya'],
            ['value' => 'LI', 'label' => 'Liechtenstein'],
            ['value' => 'LT', 'label' => 'Lithuania'],
            ['value' => 'LU', 'label' => 'Luxembourg'],
            ['value' => 'MO', 'label' => 'Macau'],
            ['value' => 'MK', 'label' => 'Macedonia'],
            ['value' => 'MG', 'label' => 'Madagascar'],
            ['value' => 'MW', 'label' => 'Malawi'],
            ['value' => 'MY', 'label' => 'Malaysia'],
            ['value' => 'MV', 'label' => 'Maldives'],
            ['value' => 'ML', 'label' => 'Mali'],
            ['value' => 'MT', 'label' => 'Malta'],
            ['value' => 'MH', 'label' => 'Marshall Islands'],
            ['value' => 'MQ', 'label' => 'Martinique'],
            ['value' => 'MR', 'label' => 'Mauritania'],
            ['value' => 'MU', 'label' => 'Mauritius'],
            ['value' => 'YT', 'label' => 'Mayotte'],
            ['value' => 'MX', 'label' => 'Mexico'],
            ['value' => 'FM', 'label' => 'Micronesia'],
            ['value' => 'MD', 'label' => 'Moldova'],
            ['value' => 'MC', 'label' => 'Monaco'],
            ['value' => 'MN', 'label' => 'Mongolia'],
            ['value' => 'ME', 'label' => 'Montenegro'],
            ['value' => 'MS', 'label' => 'Montserrat'],
            ['value' => 'MA', 'label' => 'Morocco'],
            ['value' => 'MZ', 'label' => 'Mozambique'],
            ['value' => 'NA', 'label' => 'Namibia'],
            ['value' => 'NR', 'label' => 'Nauru'],
            ['value' => 'NP', 'label' => 'Nepal'],
            ['value' => 'NL', 'label' => 'Netherlands'],
            ['value' => 'NC', 'label' => 'New Caledonia'],
            ['value' => 'NZ', 'label' => 'New Zealand'],
            ['value' => 'NI', 'label' => 'Nicaragua'],
            ['value' => 'NE', 'label' => 'Niger'],
            ['value' => 'NG', 'label' => 'Nigeria'],
            ['value' => 'NU', 'label' => 'Niue'],
            ['value' => 'NF', 'label' => 'Norfolk Island'],
            ['value' => 'MP', 'label' => 'Northern Mariana Islands'],
            ['value' => 'NO', 'label' => 'Norway'],
            ['value' => 'OM', 'label' => 'Oman'],
            ['value' => 'PK', 'label' => 'Pakistan'],
            ['value' => 'PS', 'label' => 'Palestinian Territory, Occupied'],
            ['value' => 'PW', 'label' => 'Palau'],
            ['value' => 'PA', 'label' => 'Panama'],
            ['value' => 'PG', 'label' => 'Papua New Guinea'],
            ['value' => 'PY', 'label' => 'Paraguay'],
            ['value' => 'PE', 'label' => 'Peru'],
            ['value' => 'PH', 'label' => 'Philippines'],
            ['value' => 'PN', 'label' => 'Pitcairn'],
            ['value' => 'PL', 'label' => 'Poland'],
            ['value' => 'PT', 'label' => 'Portugal'],
            ['value' => 'PR', 'label' => 'Puerto Rico'],
            ['value' => 'QA', 'label' => 'Qatar'],
            ['value' => 'RE', 'label' => 'Reunion'],
            ['value' => 'RS', 'label' => 'Republic of Serbia'],
            ['value' => 'RO', 'label' => 'Romania'],
            ['value' => 'RU', 'label' => 'Russia'],
            ['value' => 'RW', 'label' => 'Rwanda'],
            ['value' => 'BL', 'label' => 'Saint Barthelemy'],
            ['value' => 'GS', 'label' => 'S. Georgia and S. Sandwich Isls.'],
            ['value' => 'KN', 'label' => 'Saint Kitts and Nevis'],
            ['value' => 'LC', 'label' => 'Saint Lucia'],
            ['value' => 'MF', 'label' => 'Saint Martin (French part)'],
            ['value' => 'VC', 'label' => 'Saint Vincent and the Grenadines'],
            ['value' => 'WS', 'label' => 'Samoa'],
            ['value' => 'SM', 'label' => 'San Marino'],
            ['value' => 'ST', 'label' => 'Sao Tome and Principe'],
            ['value' => 'SA', 'label' => 'Saudi Arabia'],
            ['value' => 'SN', 'label' => 'Senegal'],
            ['value' => 'SC', 'label' => 'Seychelles'],
            ['value' => 'SL', 'label' => 'Sierra Leone'],
            ['value' => 'SG', 'label' => 'Singapore'],
            ['value' => 'SX', 'label' => 'Sint Maarten (Dutch part)'],
            ['value' => 'SK', 'label' => 'Slovak Republic'],
            ['value' => 'SI', 'label' => 'Slovenia'],
            ['value' => 'SB', 'label' => 'Solomon Islands'],
            ['value' => 'SO', 'label' => 'Somalia'],
            ['value' => 'ZA', 'label' => 'South Africa'],
            ['value' => 'SS', 'label' => 'South Sudan'],
            ['value' => 'ES', 'label' => 'Spain'],
            ['value' => 'LK', 'label' => 'Sri Lanka'],
            ['value' => 'SH', 'label' => 'St. Helena'],
            ['value' => 'PM', 'label' => 'St. Pierre and Miquelon'],
            ['value' => 'SD', 'label' => 'Sudan'],
            ['value' => 'SR', 'label' => 'Suriname'],
            ['value' => 'SJ', 'label' => 'Svalbard and Jan Mayen Islands'],
            ['value' => 'SZ', 'label' => 'Swaziland'],
            ['value' => 'SE', 'label' => 'Sweden'],
            ['value' => 'CH', 'label' => 'Switzerland'],
            ['value' => 'SY', 'label' => 'Syria'],
            ['value' => 'TW', 'label' => 'Taiwan'],
            ['value' => 'TJ', 'label' => 'Tajikistan'],
            ['value' => 'TZ', 'label' => 'Tanzania'],
            ['value' => 'TH', 'label' => 'Thailand'],
            ['value' => 'TL', 'label' => 'Timor-Leste'],
            ['value' => 'TG', 'label' => 'Togo'],
            ['value' => 'TK', 'label' => 'Tokelau'],
            ['value' => 'TO', 'label' => 'Tonga'],
            ['value' => 'TT', 'label' => 'Trinidad and Tobago'],
            ['value' => 'TN', 'label' => 'Tunisia'],
            ['value' => 'TR', 'label' => 'Turkey'],
            ['value' => 'TM', 'label' => 'Turkmenistan'],
            ['value' => 'TC', 'label' => 'Turks and Caicos Islands'],
            ['value' => 'TV', 'label' => 'Tuvalu'],
            ['value' => 'UG', 'label' => 'Uganda'],
            ['value' => 'UA', 'label' => 'Ukraine'],
            ['value' => 'AE', 'label' => 'United Arab Emirates'],
            ['value' => 'GB', 'label' => 'United Kingdom'],
            ['value' => 'US', 'label' => 'United States'],
            ['value' => 'UM', 'label' => 'United States Minor Outlying Islands'],
            ['value' => 'UY', 'label' => 'Uruguay'],
            ['value' => 'UZ', 'label' => 'Uzbekistan'],
            ['value' => 'VU', 'label' => 'Vanuatu'],
            ['value' => 'VA', 'label' => 'Vatican City State (Holy See)'],
            ['value' => 'VE', 'label' => 'Venezuela'],
            ['value' => 'VN', 'label' => 'Viet Nam'],
            ['value' => 'VG', 'label' => 'Virgin Islands (British)'],
            ['value' => 'VI', 'label' => 'Virgin Islands (U.S.)'],
            ['value' => 'WF', 'label' => 'Wallis and Futuna Islands'],
            ['value' => 'EH', 'label' => 'Western Sahara'],
            ['value' => 'YE', 'label' => 'Yemen'],
            ['value' => 'ZM', 'label' => 'Zambia'],
            ['value' => 'ZW', 'label' => 'Zimbabwe'],
        ];
    }
}
