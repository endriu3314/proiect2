<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, Content-Disposition');
header('Access-Control-Expose-Headers: Content-Disposition');

include_once __DIR__ . '../../Core/DB.php';

class BaseAPI extends DB
{

}
