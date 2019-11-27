<?php
/**
 * Created by PhpStorm.
 * User: WOLF
 * Date: 11/17/2019
 * Time: 1:53 AM
 */
add_action('rest_api_init', 'rest_registration_endpoint');

function rest_registration_endpoint()
{
    // Declare our namespace
    $namespace = 'rest/v1';

    // Register the route
    register_rest_route($namespace, '/save/', array(
        'methods' => 'POST',
        'callback' => 'rest_registration_handler'
    ));
}

// The callback handler for the endpoint
function rest_registration_handler(WP_REST_Request $request)
{
    // We don't need to specifically check the nonce like with admin-ajax. It is handled by the API.
    $params = $request->get_json_params();


    if (empty($params)) {
        return new WP_REST_Response(array('message' => 'Something went wrong. Refresh page and try again.', 'error' => true), 200);
    }
    try {
       $response = saveInDB($params);
    } catch (\Exception $e) {
        echo $e->getMessage();
        exit(0);
    }

    return new WP_REST_Response(array('response' => $response, 'message' => 'You are suuccessfully registrated.', 'params' => $params, 'success' => true), 200);

}

function convertReasons($reason)
{
    $reasons =
        array(
            'SE' => 'Search engine',
            'SM' => 'Social media',
            'AM' => 'Amazon',
            'RG' => 'Recieved as a gift',
            'WM' => 'Word of mouth',
            'OT' => 'Other'
        );

    return $reasons[sanitize_text_field($reason)];
}

function convertToNumbers($string)
{
    $stings =
        array(
            'One' => '1',
            'Two' => '2',
            'Three' => '3',
            'Four-Plus' => '4+'
        );

    return $stings[sanitize_text_field($string)];
}

function convertStates($state)
{
    $states = array(
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AS' => 'American Samoa',
        'AZ' => 'Arizona',
        'AR' => 'Arkansas',
        'AF' => 'Armed Forces Africa',
        'AA' => 'Armed Forces Americas',
        'AC' => 'Armed Forces Canada',
        'AE' => 'Armed Forces Europe',
        'AM' => 'Armed Forces Middle East',
        'AP' => 'Armed Forces Pacific',
        'CA' => 'California',
        'CO' => 'Colorado',
        'CT' => 'Connecticut',
        'DE' => 'Delaware',
        'DC' => 'District of Columbia',
        'FM' => 'Federated States Of Micronesia',
        'FL' => 'Florida',
        'GA' => 'Georgia',
        'GU' => 'Guam',
        'HI' => 'Hawaii',
        'ID' => 'Idaho',
        'IL' => 'Illinois',
        'IN' => 'Indiana',
        'IA' => 'Iowa',
        'KS' => 'Kansas',
        'KY' => 'Kentucky',
        'LA' => 'Louisiana',
        'ME' => 'Maine',
        'MH' => 'Marshall Islands',
        'MD' => 'Maryland',
        'MA' => 'Massachusetts',
        'MI' => 'Michigan',
        'MN' => 'Minnesota',
        'MS' => 'Mississippi',
        'MO' => 'Missouri',
        'MT' => 'Montana',
        'NE' => 'Nebraska',
        'NV' => 'Nevada',
        'NH' => 'New Hampshire',
        'NJ' => 'New Jersey',
        'NM' => 'New Mexico',
        'NY' => 'New York',
        'NC' => 'North Carolina',
        'ND' => 'North Dakota',
        'MP' => 'Northern Mariana Islands',
        'OH' => 'Ohio',
        'OK' => 'Oklahoma',
        'OR' => 'Oregon',
        'PW' => 'Palau',
        'PA' => 'Pennsylvania',
        'PR' => 'Puerto Rico',
        'RI' => 'Rhode Island',
        'SC' => 'South Carolina',
        'SD' => 'South Dakota',
        'TN' => 'Tennessee',
        'TX' => 'Texas',
        'UT' => 'Utah',
        'VT' => 'Vermont',
        'VI' => 'Virgin Islands',
        'VA' => 'Virginia',
        'WA' => 'Washington',
        'WV' => 'West Virginia',
        'WI' => 'Wisconsin',
        'WY' => 'Wyoming'
    );
    return $states[sanitize_text_field($state)];
}

function saveInDB($params)
{

    $result = WPSR_Model::insert(array(
        'name' => sanitize_text_field($params['registration']['name']),
        'street' => sanitize_text_field($params['registration']['street']),
        'city' => sanitize_text_field($params['registration']['city']),
        'state' => convertStates($params['registration']['state']),
        'zip' => sanitize_text_field($params['registration']['zip']),
        'phone' => sanitize_text_field($params['registration']['phone']),

        'id_number' => sanitize_text_field($params['registration']['id_number']),
        'usage' => sanitize_text_field($params['registration']['usage']),
        'entries' => convertToNumbers($params['registration']['entries']),
        'reason' => convertReasons($params['registration']['reason']),
        'people' => convertToNumbers($params['registration']['people']),
        'other' => isset($params['registration']['other']) ? sanitize_text_field($params['registration']['other']) : '/',
        'created_at' => (new DateTime('America/New_York'))->format('M d, Y g:i:s A')
    ));

    if (is_a($result, 'WP_Error')) {
        throw new \Exception('Couldn\'t save data in Database');
    }
    return $result;
}
