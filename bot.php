<?php

/**

PLEASE FOLLOW THE STEPS IN README.MD
Author: https://github.com/yzyjim/

**/

// Mastodon and welcome message configuration:

$token="YOUR_TOKEN_HERE"; // Token of your Mastodon welcome bot account
$account_id="123"; // User ID (an integer) of your welcome bot account
$base_url="https://example.com"; // URL of your instance (Do not include '/' at the end.)
$visibility="direct"; // "Direct" means sending welcome message as a private message. The four tiers of visibility for toots are Public , Unlisted, Private, and Direct (default)
$welcome_message="Welcome!\n\nSecond line"; // Welcome message
$language="en"; // en for English, zh for Chinese, etc.

// End of configuration. You don't need to edit anything below.


// Retrieve the user ID of the latest follower of your bot account

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $base_url . '/api/v1/accounts/' . $account_id . '/followers');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

$headers = array();
$headers[] = 'Authorization: Bearer ' . $token ;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);

$json = json_decode($result, TRUE);
$newest_user_id=$json[0]['id'];
$newest_user_username=$json[0]['username'];

echo $newest_user_id;

// Read the previously stored follower ID from newest_user_id.txt

$readstorage = fopen("newest_user_id.txt", "r") or die("Unable to open file!");
$last_user_id = fread($readstorage,filesize("newest_user_id.txt"));
echo "<br>last_user_id is: " . $last_user_id;
fclose($readstorage);

// Compare the previously stored follower ID with current latest follower ID

if ($last_user_id == "") {
    $writestorage = fopen("newest_user_id.txt", "w") or die("Unable to open file!");
    fwrite($writestorage, $newest_user_id);
    fclose($writestorage);
}

if (($last_user_id != $newest_user_id) && ($last_user_id != "")) {
  
    // Write current follower ID to newest_user_id.txt

    $writestorage = fopen("newest_user_id.txt", "w") or die("Unable to open file!");
    fwrite($writestorage, $newest_user_id);
    fclose($writestorage);

    // Post Mastodon message through Mastodon API

    $headers = [
      'Authorization: Bearer ' . $token
    ];
  
    $post="";

    $status_data = array(
      "status" => "@" . $newest_user_username . " " . $welcome_message ,
      "language" => $language,
      "visibility" => $visibility
    );

    $ch_status = curl_init();
    curl_setopt($ch_status, CURLOPT_URL, $base_url . "/api/v1/statuses");
    curl_setopt($ch_status, CURLOPT_POST, 1);
    curl_setopt($ch_status, CURLOPT_POSTFIELDS, $status_data);
    curl_setopt($ch_status, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch_status, CURLOPT_HTTPHEADER, $headers);
    $output_status = json_decode(curl_exec($ch_status));
    curl_close ($ch_status);

} else {

    echo "<br>No new user";

}

