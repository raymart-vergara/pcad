<?php
// count overall good
function count_overall_g($search_arr, $conn_ircs)
{
        $shift = $search_arr['shift'];
        $registlinename = addslashes($search_arr['registlinename']);
        $final_process = $search_arr['final_process'];
        $ip = addslashes($search_arr['ip']);
        $server_date_only = $search_arr['server_date_only'];
        $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
        $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
        $server_time = $search_arr['server_time'];

        $total = 0;

        $query = "SELECT COUNT(*) AS OUTPUT FROM T_PACKINGWK WHERE IPADDRESS IN ('$ip') AND REGISTLINENAME = '$registlinename' AND PACKINGBOXCARDJUDGMENT = '1'";

        // AND REGISTDATETIME BETWEEN to_date('2024-02-23 06:00:00', 'yyyy-MM-dd HH24:MI:SS') AND to_date('2024-02-23 17:59:59', 'yyyy-MM-dd HH24:MI:SS')

        if ($shift == 'DS') {
                $query = $query . "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        } else if ($shift == 'NS') {
                if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
                        $query = $query . "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
                        $query = $query . "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                }
        }

        // if ($final_process == 'QA') {
        //         $query = $query . "AND INSPECTION4IPADDRESS = '$ip'";
        // } else {
        //         $query = $query . "AND INSPECTION3IPADDRESS = '$ip'";
        // }

        $stmt = oci_parse($conn_ircs, $query);
        oci_execute($stmt);
        while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $total = $row->OUTPUT;
        }
        return $total;
}

// count overall no good
function count_overall_ng($search_arr, $conn_ircs)
{
        $shift = $search_arr['shift'];
        $registlinename = addslashes($search_arr['registlinename']);
        $final_process = $search_arr['final_process'];
        $ip = addslashes($search_arr['ip']);
        $server_date_only = $search_arr['server_date_only'];
        $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
        $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
        $server_time = $search_arr['server_time'];

        $total = 0;

        $query = "SELECT COUNT(*) AS NG FROM T_REPAIRWK WHERE REGISTLINENAME = '$registlinename'";

        if ($shift == 'DS') {
                $query = $query . "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        } else if ($shift == 'NS') {
                if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
                        $query = $query . "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
                        $query = $query . "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                }
        }

        // if ($final_process == 'QA') {
        //         $query = $query . "AND INSPECTION4IPADDRESS = '$ip'";
        // } else {
        //         $query = $query . "AND INSPECTION3IPADDRESS = '$ip'";
        // }

        $stmt = oci_parse($conn_ircs, $query);
        oci_execute($stmt);
        while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $total = $row->NG;
        }
        return $total;
}

// =====================================================================================================
// count of each inspection process

// dimension
function count_dimension($search_arr, $conn_ircs)
{
        $shift = $search_arr['shift'];
        $registlinename = addslashes($search_arr['registlinename']);
        $final_process = $search_arr['final_process'];
        $ip = addslashes($search_arr['ip']);
        $server_date_only = $search_arr['server_date_only'];
        $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
        $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
        $server_time = $search_arr['server_time'];

        $total = 0;

        $query = "SELECT COUNT(*) AS DIMENSION_G FROM T_PRODUCTWK WHERE INSPECTION1IPADDRESS = '172.25.161.242' AND REGISTLINENAME = '$registlinename'";

        if ($shift == 'DS') {
                $query = $query . "AND INSPECTION1FINISHDATETIME BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        } else if ($shift == 'NS') {
                if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
                        $query = $query . "AND INSPECTION1FINISHDATETIME BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
                        $query = $query . "AND INSPECTION1FINISHDATETIME BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                }
        }

        $stmt = oci_parse($conn_ircs, $query);
        oci_execute($stmt);
        while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $total = $row->DIMENSION_G;
        }
        return $total;
}

function count_dimension_ng($search_arr, $conn_ircs)
{
        $shift = $search_arr['shift'];
        $registlinename = addslashes($search_arr['registlinename']);
        $final_process = $search_arr['final_process'];
        $ip = addslashes($search_arr['ip']);
        $server_date_only = $search_arr['server_date_only'];
        $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
        $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
        $server_time = $search_arr['server_time'];

        $total = 0;

        $query = "SELECT COUNT(*) AS DIMENSION_NG FROM T_REPAIRWK WHERE INSPECTION2IPADDRESS = '172.25.161.242' AND REGISTLINENAME = '$registlinename' AND INSPECTION2JUDGMENT = '0'";

        if ($shift == 'DS') {
                $query = $query . "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        } else if ($shift == 'NS') {
                if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
                        $query = $query . "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
                        $query = $query . "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                }
        }

        $stmt = oci_parse($conn_ircs, $query);
        oci_execute($stmt);
        while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $total = $row->DIMENSION_NG;
        }
        return $total;
}

// ECT
function count_ect($search_arr, $conn_ircs)
{
        $shift = $search_arr['shift'];
        $registlinename = addslashes($search_arr['registlinename']);
        $final_process = $search_arr['final_process'];
        $ip = addslashes($search_arr['ip']);
        $server_date_only = $search_arr['server_date_only'];
        $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
        $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
        $server_time = $search_arr['server_time'];

        $total = 0;

        $query = "SELECT COUNT(*) AS ECT_G FROM T_PRODUCTWK WHERE INSPECTION2IPADDRESS = '172.25.161.243' AND REGISTLINENAME = '$registlinename'";

        if ($shift == 'DS') {
                $query = $query . "AND INSPECTION2FINISHDATETIME BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        } else if ($shift == 'NS') {
                if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
                        $query = $query . "AND INSPECTION2FINISHDATETIME BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
                        $query = $query . "AND INSPECTION2FINISHDATETIME BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                }
        }

        $stmt = oci_parse($conn_ircs, $query);
        oci_execute($stmt);
        while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $total = $row->ECT_G;
        }
        return $total;
}

function count_ect_ng($search_arr, $conn_ircs)
{
        $shift = $search_arr['shift'];
        $registlinename = addslashes($search_arr['registlinename']);
        $final_process = $search_arr['final_process'];
        $ip = addslashes($search_arr['ip']);
        $server_date_only = $search_arr['server_date_only'];
        $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
        $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
        $server_time = $search_arr['server_time'];

        $total = 0;

        $query = "SELECT COUNT(*) AS ECT_NG FROM T_REPAIRWK WHERE INSPECTION2IPADDRESS = '172.25.161.243' AND REGISTLINENAME = '$registlinename' AND INSPECTION2JUDGMENT = '0'";

        if ($shift == 'DS') {
                $query = $query . "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        } else if ($shift == 'NS') {
                if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
                        $query = $query . "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
                        $query = $query . "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                }
        }

        $stmt = oci_parse($conn_ircs, $query);
        oci_execute($stmt);
        while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $total = $row->ECT_NG;
        }
        return $total;
}

// assurance
function count_assurance($search_arr, $conn_ircs)
{
        $shift = $search_arr['shift'];
        $registlinename = addslashes($search_arr['registlinename']);
        $final_process = $search_arr['final_process'];
        $ip = addslashes($search_arr['ip']);
        $server_date_only = $search_arr['server_date_only'];
        $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
        $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
        $server_time = $search_arr['server_time'];

        $total = 0;

        $query = "SELECT COUNT(*) AS ASSURANCE_G FROM T_PRODUCTWK WHERE INSPECTION4IPADDRESS = '172.25.161.166' AND REGISTLINENAME = '$registlinename'";

        if ($shift == 'DS') {
                $query = $query . "AND INSPECTION4FINISHDATETIME BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        } else if ($shift == 'NS') {
                if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
                        $query = $query . "AND INSPECTION4FINISHDATETIME BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
                        $query = $query . "AND INSPECTION4FINISHDATETIME BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                }
        }

        $stmt = oci_parse($conn_ircs, $query);
        oci_execute($stmt);
        while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $total = $row->ASSURANCE_G;
        }
        return $total;
}

function count_assurance_ng($search_arr, $conn_ircs)
{
        $shift = $search_arr['shift'];
        $registlinename = addslashes($search_arr['registlinename']);
        $final_process = $search_arr['final_process'];
        $ip = addslashes($search_arr['ip']);
        $server_date_only = $search_arr['server_date_only'];
        $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
        $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
        $server_time = $search_arr['server_time'];

        $total = 0;

        $query = "SELECT COUNT(*) AS ASSURANCE_NG FROM T_REPAIRWK WHERE INSPECTION4IPADDRESS = '172.25.161.166' AND REGISTLINENAME = '$registlinename' AND INSPECTION2JUDGMENT = '0'";

        if ($shift == 'DS') {
                $query = $query . "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        } else if ($shift == 'NS') {
                if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
                        $query = $query . "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
                        $query = $query . "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                }
        }

        $stmt = oci_parse($conn_ircs, $query);
        oci_execute($stmt);
        while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $total = $row->ASSURANCE_NG;
        }
        return $total;
}


?>