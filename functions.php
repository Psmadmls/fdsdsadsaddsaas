<?php

define('API_URL', 'https://sheet.best/api/sheets/f7ba6bef-d7a0-473b-984d-18e9cfbdefca');

class DB_con {
    public function sendRequest($method, $url, $data = []) {
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, true);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case "GET":
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                break;
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        return json_decode($result, true);
    }

    public function usernameAvailable($uname) {
        $users = $this->sendRequest('GET', API_URL);
        foreach ($users as $user) {
            if ($user['username'] === $uname) {
                return ['available' => false];
            }
        }
        return ['available' => true];
    }

    public function registration($fname, $uname, $uemail, $password) {
        $data = [
            'fullname' => $fname,
            'username' => $uname,
            'useremail' => $uemail,
            'password' => $password
        ];
        return $this->sendRequest('POST', API_URL, $data);
    }

    public function signin($uname, $password) {
        $result = $this->sendRequest('GET', API_URL, ['username' => $uname]);
        if (!empty($result)) {
            foreach ($result as $user) {
                if ($password == $user['password']) {
                    return $user; // Return user details if password matches
                }
            }
        }
        return false; // Return false if user not found or password does not match
    }
}

?>
