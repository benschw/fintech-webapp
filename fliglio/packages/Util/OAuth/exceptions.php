<?php

class Util_OAuth_Exception extends Exception {}


/* Generic problem with oauth web service request */
class Util_OAuth_RequestException extends Util_OAuth_Exception {}

/* Service sent back a "HTTP 400 Bad Request" code */
class Util_OAuth_BadRequestException extends Util_OAuth_RequestException {}
/* Service sent back a "HTTP 401 Unauthorized" code */
class Util_OAuth_UnauthorizedException extends Util_OAuth_RequestException {}

class Util_OAuth_BadTokenException extends Util_OAuth_Exception {}
class Util_OAuth_DuplicateNonceException extends Util_OAuth_Exception {}