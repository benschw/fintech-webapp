<?php

/*
* @requires Fl.Mapper
* @requires Util
* @requires Util.Db
*/

class Util_IpFilter_ClientNotFound extends Exception {}

interface Util_IpFilter_Requirement {
    public function match($ip);
}