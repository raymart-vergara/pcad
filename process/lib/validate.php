<?php
// Validations

function custom_trim($data) {
	$data = trim($data);
    preg_replace('/[\t\n\r\s]+/', ' ', $data); // Remove Extra Whitespaces
    return $data;
}

function validate_username($data) {
	if (!preg_match("/^(?=.{2,255}$)(?![-'_. ])(?!.*[-'_. ]{2})[a-zA-Z0-9-'._ ñÑ]*(?<![-'_. ])$/", $data)) {
		return false;
	} else {
		return true;
	}
}

function validate_password($data) {
	$uppercase = preg_match('@[A-Z]@', $data);
	$lowercase = preg_match('@[a-z]@', $data);
	$number    = preg_match('@[0-9]@', $data);
	$specialChars = preg_match('@[^\w]@', $data);

	if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($data) < 8) {
		return false;
	} else {
		return true;
	}
}

function validate_name($data) {
	if (!preg_match("/^(?=.{2,255}$)(?![-'. ])(?!.*[-'. ]{2})[a-zA-Z0-9-'. ñÑ]*(?<![-'. ])$/", $data)) {
		return false;
	} else {
		return true;
	}
}

function validate_line_no($data) {
	if (!preg_match("/^(?=.{2,255}$)(?![()])(?!.*[()]{2})[a-zA-Z0-9() ]*(?<![(])$/", $data)) {
		return false;
	} else {
		return true;
	}
}

function validate_item_no($data) {
	if(!preg_match('/^[0-9]*$/', $data)) {
		return false;
	} else {
		return true;
	}
}

function validate_item_name($data) {
	if (!preg_match("/^.{8,100}$/", $data)) {
		return false;
	} else {
		return true;
	}
}

function validate_pcs_bundle($data) {
	if (!preg_match("/^.{3,12}$/", $data)) {
		return false;
	} else {
		return true;
	}
}

function validate_id_no($data) {
	$number = preg_match('@[0-9]@', $data);
	if (!preg_match("/^(?=.{8,255}$)(?![-])(?!.*[-]{2})[a-zA-Z0-9-]*(?<![-])$/", $data)) {
		return false;
	} else if (!$number) {
		return false;
	} else {
		return true;
	}
}

function validate_requestor($data) {
	if (!preg_match("/^(?=.{2,255}$)(?![-])(?!.*[-]{2})[a-zA-Z0-9-]*(?<![-])$/", $data)) {
		return false;
	} else {
		return true;
	}
}

function validate_route_no($data) {
	if(!preg_match('/^[0-9]*$/', $data)) {
		return false;
	} else {
		return true;
	}
}

function validate_section($data) {
	if (!preg_match("/^(?=.{2,100}$)(?![-_. ])(?!.*[-_. ]{2})[a-zA-Z0-9-._ ]*(?<![-_. ])$/", $data)) {
		return false;
	} else {
		return true;
	}
}

function validate_ip($data) {
	$flags = array(
	    'flags' => FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6
	);
	if (!filter_var($data, FILTER_VALIDATE_IP, $flags)) {
		return false;
	} else {
		return true;
	}
}

function validate_area($data) {
	if (!preg_match("/^(?=.{2,12}$)(?![-_. ])(?!.*[-_. ]{2})[a-zA-Z0-9-_. ñÑ]*(?<![-_. ])$/", $data)) {
		return false;
	} else {
		return true;
	}
}

function validate_supplier($data) {
	if (!preg_match("/^(?=.{2,255}$)(?![-'_. ])(?!.*[-'_. ]{2})[a-zA-Z0-9-'._ ñÑ]*(?<![-'_. ])$/", $data)) {
		return false;
	} else {
		return true;
	}
}

function validate_date($data) {
	if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$data)) {
	    return true;
	} else {
	    return false;
	}
}
?>