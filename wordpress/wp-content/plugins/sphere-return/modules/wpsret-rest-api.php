<?php
/**
 * Created by PhpStorm.
 * User: WOLF
 * Date: 11/17/2019
 * Time: 1:53 AM
 */
add_action('rest_api_init', 'rest_return_endpoint');

function rest_return_endpoint()
{
    // Declare our namespace
    $namespace = 'rest/v1';

    // Register the route
    register_rest_route($namespace, '/send/', array(
        'methods' => 'POST',
        'callback' => 'rest_return_handler'
    ));
}

// The callback handler for the endpoint
function rest_return_handler(WP_REST_Request $request)
{
    // We don't need to specifically check the nonce like with admin-ajax. It is handled by the API.
    $params = $request->get_json_params();


    if (empty($params)) {
        return new WP_REST_Response(array('message' => 'Something went wrong. Refresh page and try again.', 'error' => true), 200);
    }
    try {
       $response = saveReturnInDB($params);
    } catch (\Exception $e) {
        echo $e->getMessage();
        exit(0);
    }

    return new WP_REST_Response(array('response' => $response, 'message' => 'You are suuccessfully registrated.', 'params' => $params, 'success' => true), 200);

}

function saveReturnInDB($params)
{

    $result = WPSRET_Model::insert(array(
        'name' => sanitize_text_field($params['return']['name']),
        'email' => sanitize_text_field($params['return']['email']),
        'order' => sanitize_text_field($params['return']['order']),
        'action' => sanitize_text_field($params['return']['action']),
        'return' => sanitize_text_field($params['return']['return']),
        'replacement' => isset($params['return']['replacement']) ?  sanitize_text_field($params['return']['replacement']) : '/',
        'created_at' => (new DateTime('America/New_York'))->format('M d, Y g:i:s A')
    ));

    if (is_a($result, 'WP_Error')) {
        throw new \Exception('Couldn\'t save data in Database');
    }
    return $result;
}
