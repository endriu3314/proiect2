<?php
include_once 'BaseAPI.php';

include_once __DIR__ . '../../Models/User.php';

class UsersAPI extends BaseAPI
{
    public function register()
    {
        $database = new DB();
        $db = $database->db;

        $user = new User($db);

        $data = json_decode(file_get_contents("php://input"));

        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = $data->password;

        try {
            $user->register();

            $arr = array(
                "success" => true,
                "body" => [],
                "message" => "Account created."
            );

            return json_encode($arr);
        } catch (Exception $e) {
            http_response_code(200);

            $arr = array(
                "success" => false,
                "body" => [],
                "message" => $e->getMessage(),
            );

            return json_encode($arr);
        }
    }

    public function login()
    {
        $database = new DB();
        $db = $database->db;

        $user = new User($db);

        $data = json_decode(file_get_contents("php://input"));

        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = $data->password;

        try {
            return json_encode($user->login());
        } catch (Exception $e) {
            http_response_code(200);
            
            $arr = array(
                "success" => false,
                "body" => [],
                "message" => $e->getMessage()
            );
            
            return json_encode($arr);
        }
    }
    
    public function getAll()
    {
        $database = new DB();
        $db = $database->db;

        $users = new User($db);

        try {
            return $users->getAll();
        } catch (Exception $e) {
            http_response_code(200);
            
            $arr = array(
                "success" => false,
                "body" => [],
                "message" => $e->getMessage()
            );
            
            return json_encode($arr);
        }
    }

    public function verifyAuthorization(string $param)
    {
        $database = new DB();
        $db = $database->db;

        $user = new User($db);

        $user->hash = $param;

        try {
            $user->verifyAuthorization();
            /*
            $arr = array(
                "success" => true,
                "body" => [],
                "message" => "Account verified."
            ); */

            return true;
        } catch (Exception $e) {
            http_response_code(200);

            $arr = array(
                "success" => false,
                "body" => [],
                "message" => $e->getMessage(),
            );

            return false;
        }
    }
}
