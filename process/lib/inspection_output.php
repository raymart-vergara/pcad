<?php
// count overall good
function count_overall_g($search_arr, $conn_ircs)
{
        $shift = $search_arr['shift'];
        $registlinename = addslashes($search_arr['registlinename']);

        $ircs_line_data_arr = $search_arr['ircs_line_data_arr'];
        $final_process = $ircs_line_data_arr['final_process'];
        $ipaddresscolumn = $ircs_line_data_arr['ipaddresscolumn'];
        $ipAddresses = $ircs_line_data_arr['ipAddresses'];

        $server_date_only = $search_arr['server_date_only'];
        $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
        $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
        $server_time = $search_arr['server_time'];

        $total = 0;

        $date_column = "INSPECTION4FINISHDATETIME";

        if ($final_process == 'Assurance') {
                $date_column = "INSPECTION4FINISHDATETIME";
        } else {
                $date_column = "INSPECTION3FINISHDATETIME";
        }

        $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";

        $query = "SELECT COUNT(*) AS OUTPUT FROM T_PACKINGWK WHERE REGISTLINENAME = '$registlinename' AND PACKINGBOXCARDJUDGMENT = '1'";

        if (!empty($ipAddresses)) {
                $query .= " AND IPADDRESS IN ($ipAddressesString)";
        }

        if ($shift == 'DS') {
                $query .= "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') 
                                AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        } else if ($shift == 'NS') {
                if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
                        $query .= "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') 
                                        AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
                        $query .= "AND REGISTDATETIME BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') 
                                        AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                }
        }

        $stmt = oci_parse($conn_ircs, $query);
        oci_execute($stmt);
        while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $total = $row->OUTPUT;
        }
        return $total;
}

function count_overall_ng($search_arr, $conn_ircs, $conn_pcad)
{
        $insp_overall_ng = 0;

        // Fetch processes and their corresponding IP addresses
        $processesAndIpAddresses = getIpAddressesFromDatabase($search_arr['registlinename'], $conn_pcad);

        if (!empty($processesAndIpAddresses)) {
                foreach ($processesAndIpAddresses as $processData) {
                        $process = $processData['process'];
                        $ipaddresscolumn = $processData['ipaddresscolumn'];
                        $ipAddresses = $processData['ipAddresses'];

                        $judgmentColumnNG = "";
                        $date_column = "";

                        switch ($process) {
                                case "Dimension":
                                        $date_column = "INSPECTION1FINISHDATETIME";
                                        $judgmentColumnNG = "INSPECTION1JUDGMENT";
                                        break;
                                case "Electric":
                                        $date_column = "INSPECTION2FINISHDATETIME";
                                        $judgmentColumnNG = "INSPECTION2JUDGMENT";
                                        break;
                                case "Visual":
                                        $date_column = "INSPECTION3FINISHDATETIME";
                                        $judgmentColumnNG = "INSPECTION3JUDGMENT";
                                        break;
                                case "Assurance":
                                        $date_column = "INSPECTION4FINISHDATETIME";
                                        $judgmentColumnNG = "INSPECTION4JUDGMENT";
                                        break;
                                default:
                                        break;
                        }

                        $processDetailsNG = array(
                                'process' => $process,
                                'date_column' => $date_column,
                                'ipAddressColumn' => $ipaddresscolumn,
                                'judgmentColumn' => $judgmentColumnNG,
                                'ipAddresses' => $ipAddresses
                        );

                        $p_ng = countProcessNG($search_arr, $conn_ircs, $processDetailsNG, $conn_pcad);

                        $insp_overall_ng += $p_ng;
                }
        }
        return $insp_overall_ng;
}

// =====================================================================================================
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
        if (!isset($processDetailsGood['ipAddressColumn']) || !isset($processDetailsGood['ipAddresses'])) {
                // Handle the case where the required parameters are not provided
                return $total;
        }

        $ipAddressColumn = $processDetailsGood['ipAddressColumn'];
        $date_column = $processDetailsGood['date_column'];
        $ipAddresses = $processDetailsGood['ipAddresses'];

        $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";

        $query = "SELECT COUNT(*) AS PROCESS_COUNT_GOOD FROM T_PRODUCTWK WHERE REGISTLINENAME = '$registlinename'";

        if (!empty($ipAddresses)) {
                $query .= " AND $ipAddressColumn IN ($ipAddressesString)";
        }

        if ($shift == 'DS') {
                $query .= " AND $date_column BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') 
                                AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        } elseif ($shift == 'NS') {
                if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
                        $query .= " AND $date_column BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') 
                                        AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                } elseif ($server_time >= '00:00:00' && $server_time < '06:00:00') {
                        $query .= " AND $date_column BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') 
                                        AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                }
        }

        $stmt = oci_parse($conn_ircs, $query);
        oci_execute($stmt);

        while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $total = $row->PROCESS_COUNT_GOOD;
        }

        return $total;
}

// 
function countProcessNG($search_arr, $conn_ircs, $processDetailsNG, $conn_pcad)
{
        $shift = $search_arr['shift'];
        $registlinename = addslashes($search_arr['registlinename']);

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
        $date_column = $processDetailsNG['date_column'];
        $judgmentColumn = $processDetailsNG['judgmentColumn'];

        // Get IP addresses from the database
        $ipAddresses = $processDetailsNG['ipAddresses'];

        if (empty($ipAddresses)) {
                // Handle the case where IP addresses are not found
                return $total;
        }

        $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";

        $query = "SELECT COUNT(*) AS PROCESS_COUNT_NG FROM T_REPAIRWK WHERE REGISTLINENAME = '$registlinename' AND $judgmentColumn = '0'";

        if (!empty($ipAddresses)) {
                $query .= " AND $ipAddressColumn IN ($ipAddressesString)";
        }

        if ($shift == 'DS') {
                $query .= " AND $date_column BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') 
                                AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        } elseif ($shift == 'NS') {
                if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
                        $query .= " AND $date_column BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') 
                                        AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                } elseif ($server_time >= '00:00:00' && $server_time < '06:00:00') {
                        $query .= " AND $date_column BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') 
                                        AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                }
        }

        $stmt = oci_parse($conn_ircs, $query);
        oci_execute($stmt);

        while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $total = $row->PROCESS_COUNT_NG;
        }

        return $total;
}

// for inspection details
function getInspectionDetailsGood($search_arr, $conn_ircs, $inspectionDetailsGood)
{
        $shift = $search_arr['shift'];
        $registlinename = addslashes($search_arr['registlinename']);
        $server_date_only = $search_arr['server_date_only'];
        $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
        $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
        $server_time = $search_arr['server_time'];

        $total = 0;

        // Check if the necessary parameters are provided
        if (!isset($inspectionDetailsGood['ipAddressColumn']) || !isset($inspectionDetailsGood['judgmentColumn']) || !isset($inspectionDetailsGood['ipAddresses'])) {
                // Handle the case where the required parameters are not provided
                return $total;
        }

        $ipAddressColumn = $inspectionDetailsGood['ipAddressColumn'];
        $ipJudgementColumn = $inspectionDetailsGood['ipJudgementColumn'];
        $judgmentColumn = $inspectionDetailsGood['judgmentColumn'];
        $process = $inspectionDetailsGood['process'];

        // Get IP addresses from the database
        $ipAddresses = $inspectionDetailsGood['ipAddresses'];

        if (empty($ipAddresses)) {
                // Handle the case where IP addresses are not found
                return $total;
        }

        $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";

        $query = "SELECT * FROM T_PRODUCTWK WHERE $ipAddressColumn IN ($ipAddressesString) AND REGISTLINENAME = '$registlinename'";

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
                $total = $row;
        }

        return $total;
}

// function getInspectionDetailsNoGood($search_arr, $conn_ircs, $inspectionDetailsNG)
// {
//         $shift = $search_arr['shift'];
//         $registlinename = addslashes($search_arr['registlinename']);
//         $server_date_only = $search_arr['server_date_only'];
//         $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
//         $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
//         $server_time = $search_arr['server_time'];

//         $total = 0;

//         // Check if the necessary parameters are provided
//         if (!isset($inspectionDetailsNG['ipAddressColumn']) || !isset($inspectionDetailsNG['judgmentColumn']) || !isset($inspectionDetailsNG['ipAddresses'])) {
//                 // Handle the case where the required parameters are not provided
//                 return $total;
//         }

//         $ipAddressColumn = $inspectionDetailsNG['ipAddressColumn'];
//         $ipJudgementColumn = $inspectionDetailsNG['ipJudgementColumn'];
//         $judgmentColumn = $inspectionDetailsNG['judgmentColumn'];
//         $process = $inspectionDetailsNG['process'];

//         // Get IP addresses from the database
//         $ipAddresses = $inspectionDetailsNG['ipAddresses'];

//         if (empty($ipAddresses)) {
//                 // Handle the case where IP addresses are not found
//                 return $total;
//         }

//         $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";

//         $query = "SELECT * FROM T_REPAIRWK WHERE $ipAddressColumn IN ($ipAddressesString) AND $judgmentColumn = '0' AND REGISTLINENAME = '$registlinename'";

//         if ($shift == 'DS') {
//                 $query .= " AND $ipJudgementColumn BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
//         } elseif ($shift == 'NS') {
//                 if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
//                         $query .= " AND $ipJudgementColumn BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
//                 } elseif ($server_time >= '00:00:00' && $server_time < '06:00:00') {
//                         $query .= " AND $ipJudgementColumn BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
//                 }
//         }

//         $stmt = oci_parse($conn_ircs, $query);
//         oci_execute($stmt);

//         while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
//                 $total = $row;
//         }

//         return $total;
// }
?>