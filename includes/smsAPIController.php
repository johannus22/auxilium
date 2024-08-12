<?php

class smsAPIController {
    function semaphore($apikey, $contactnumber, $message) {
        $ch = curl_init();
        $parameters = array(
            'apikey' => $apikey,
            'number' => $contactnumber,
            'message' => $message,
            'sendername' => ''
        );

        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return array('success' => false, 'message' => $error_msg);
        }

        curl_close($ch);

        $response = json_decode($output, true);

        if (isset($response['status']) && $response['status'] === 'success') {
            return array('success' => true, 'message' => $response['message']);
        } else {
            return array('success' => false, 'message' => isset($response['message']) ? $response['message'] : 'Unknown error');
        }
    }
}
?>
