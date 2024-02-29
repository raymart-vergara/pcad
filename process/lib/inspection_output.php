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

        $query = "SELECT COUNT(*) AS OUTPUT FROM T_PACKINGWK WHERE IPADDRESS IN ( '172.25.166.83' ,  '172.25.161.166'  ) AND REGISTLINENAME = '$registlinename' AND PACKINGBOXCARDJUDGMENT = '1'";

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
// function count_dimension_g($search_arr, $conn_ircs)
// {
//         $shift = $search_arr['shift'];
//         $registlinename = addslashes($search_arr['registlinename']);
//         $final_process = $search_arr['final_process'];
//         $ip = addslashes($search_arr['ip']);
//         $server_date_only = $search_arr['server_date_only'];
//         $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
//         $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
//         $server_time = $search_arr['server_time'];

//         $total = 0;

//         $query = "SELECT COUNT(*) AS DIMENSION_G FROM T_PRODUCTWK WHERE INSPECTION1IPADDRESS IN ('172.25.161.242', '172.25.161.170') AND REGISTLINENAME = '$registlinename'";

//         if ($shift == 'DS') {
//                 $query = $query . "AND INSPECTION1FINISHDATETIME BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
//         } else if ($shift == 'NS') {
//                 if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
//                         $query = $query . "AND INSPECTION1FINISHDATETIME BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
//                 } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
//                         $query = $query . "AND INSPECTION1FINISHDATETIME BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
//                 }
//         }

//         $stmt = oci_parse($conn_ircs, $query);
//         oci_execute($stmt);
//         while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
//                 $total = $row->DIMENSION_G;
//         }
//         return $total;
// }

// function count_dimension_ng($search_arr, $conn_ircs)
// {
//         $shift = $search_arr['shift'];
//         $registlinename = addslashes($search_arr['registlinename']);
//         $final_process = $search_arr['final_process'];
//         $ip = addslashes($search_arr['ip']);
//         $server_date_only = $search_arr['server_date_only'];
//         $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
//         $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
//         $server_time = $search_arr['server_time'];

//         $total = 0;

//         $query = "SELECT COUNT(*) AS DIMENSION_NG FROM T_REPAIRWK WHERE INSPECTION1IPADDRESS IN ('172.25.161.242','172.25.161.170') AND REGISTLINENAME = '$registlinename' AND INSPECTION2JUDGMENT = '0'";

//         if ($shift == 'DS') {
//                 $query = $query . "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
//         } else if ($shift == 'NS') {
//                 if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
//                         $query = $query . "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
//                 } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
//                         $query = $query . "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
//                 }
//         }

//         $stmt = oci_parse($conn_ircs, $query);
//         oci_execute($stmt);
//         while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
//                 $total = $row->DIMENSION_NG;
//         }
//         return $total;
// }

// // ================================
function countProcessGood($search_arr, $conn_ircs, $processDetailsGood)
{
    $shift = $search_arr['shift'];
    $registlinename = addslashes($search_arr['registlinename']);
//     $process = $search_arr['process'];
    $server_date_only = $search_arr['server_date_only'];
    $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
    $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
    $server_time = $search_arr['server_time'];

    $total = 0;

    // Check if the necessary parameters are provided
    if (!isset($processDetailsGood['ipAddressColumn']) || !isset($processDetailsGood['judgmentColumn']) || !isset($processDetailsGood['ipAddresses'])) {
        // Handle the case where the required parameters are not provided
        return $total;
    }

    $ipAddressColumn = $processDetailsGood['ipAddressColumn'];
    $judgmentColumn = $processDetailsGood['judgmentColumn'];
    $ipAddresses = $processDetailsGood['ipAddresses'];

    $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";
    
    $query = "SELECT COUNT(*) AS PROCESS_COUNT_GOOD FROM T_PRODUCTWK WHERE $ipAddressColumn IN ($ipAddressesString) AND REGISTLINENAME = '$registlinename'";

    if ($shift == 'DS') {
        $query .= " AND $judgmentColumn BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
    } elseif ($shift == 'NS') {
        if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
            $query .= " AND $judgmentColumn BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        } elseif ($server_time >= '00:00:00' && $server_time < '06:00:00') {
            $query .= " AND $judgmentColumn BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        }
    }

    $stmt = oci_parse($conn_ircs, $query);
    oci_execute($stmt);

    while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
        $total = $row->PROCESS_COUNT_GOOD;
    }

    return $total;
}

function countProcessNG($search_arr, $conn_ircs, $processDetailsNG)
{
    $shift = $search_arr['shift'];
    $registlinename = addslashes($search_arr['registlinename']);
//     $final_process = $search_arr['final_process'];
//     $ip = addslashes($search_arr['ip']);
    $server_date_only = $search_arr['server_date_only'];
    $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
    $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
    $server_time = $search_arr['server_time'];

    $total = 0;

    // Check if the necessary parameters are provided
    if (!isset($processDetailsNG['ipAddressColumn']) || !isset($processDetailsNG['judgmentColumn']) || !isset($processDetailsNG['ipAddresses'])) {
        // Handle the case where the required parameters are not provided
        return $total;
    }

    $ipAddressColumn = $processDetailsNG['ipAddressColumn'];
    $judgmentColumn = $processDetailsNG['judgmentColumn'];
    $ipAddresses = $processDetailsNG['ipAddresses'];

    $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";

    $query = "SELECT COUNT(*) AS PROCESS_COUNT_NG FROM T_REPAIRWK WHERE $ipAddressColumn IN ($ipAddressesString) AND $judgmentColumn = '0' AND REGISTLINENAME = '$registlinename'";

    if ($shift == 'DS') {
        $query .= " AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
    } elseif ($shift == 'NS') {
        if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
            $query .= " AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        } elseif ($server_time >= '00:00:00' && $server_time < '06:00:00') {
            $query .= " AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        }
    }

    $stmt = oci_parse($conn_ircs, $query);
    oci_execute($stmt);

    while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
        $total = $row->PROCESS_COUNT_NG;
    }

    return $total;
}





?>