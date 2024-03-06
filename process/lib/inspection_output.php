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

                        $judgmentColumnGood = "";
                        $judgmentColumnNG = "";
                        $ipJudgementColumn = "";

                        switch ($process) {
                                case "Dimension":
                                        $ipJudgementColumn = "INSPECTION1FINISHDATETIME";
                                        $judgmentColumnGood = "INSPECTION1FINISHDATETIME";
                                        $judgmentColumnNG = "INSPECTION1JUDGMENT";
                                        break;
                                case "Electric":
                                        $ipJudgementColumn = "INSPECTION2FINISHDATETIME";
                                        $judgmentColumnGood = "INSPECTION2FINISHDATETIME";
                                        $judgmentColumnNG = "INSPECTION2JUDGMENT";
                                        break;
                                case "Visual":
                                        $ipJudgementColumn = "INSPECTION3FINISHDATETIME";
                                        $judgmentColumnGood = "INSPECTION3FINISHDATETIME";
                                        $judgmentColumnNG = "INSPECTION3JUDGMENT";
                                        break;
                                case "Assurance":
                                        $ipJudgementColumn = "INSPECTION4FINISHDATETIME";
                                        $judgmentColumnGood = "INSPECTION4FINISHDATETIME";
                                        $judgmentColumnNG = "INSPECTION4JUDGMENT";
                                        break;
                                default:
                                        break;
                        }

                        $processDetailsNG = array(
                                'process' => $process,
                                'ipJudgementColumn' => $ipJudgementColumn,
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
        $ipJudgementColumn = $processDetailsNG['ipJudgementColumn'];
        $judgmentColumn = $processDetailsNG['judgmentColumn'];
        $process = $processDetailsNG['process'];

        // Get IP addresses from the database
        $ipAddresses = $processDetailsNG['ipAddresses'];

        if (empty($ipAddresses)) {
                // Handle the case where IP addresses are not found
                return $total;
        }

        $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";

        $query = "SELECT COUNT(*) AS PROCESS_COUNT_NG FROM T_REPAIRWK WHERE $ipAddressColumn IN ($ipAddressesString) AND $judgmentColumn = '0' AND REGISTLINENAME = '$registlinename'";

        if ($shift == 'DS') {
                $query .= " AND $ipJudgementColumn BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        } elseif ($shift == 'NS') {
                if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
                        $query .= " AND $ipJudgementColumn BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                } elseif ($server_time >= '00:00:00' && $server_time < '06:00:00') {
                        $query .= " AND $ipJudgementColumn BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
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
function get_rows_overall_g($search_arr, $conn_ircs)
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

        $query = "SELECT * FROM T_PACKINGWK WHERE IPADDRESS IN ( '172.25.166.83' ,  '172.25.161.166'  ) AND REGISTLINENAME = '$registlinename' AND PACKINGBOXCARDJUDGMENT = '1'";

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
                $total = $row;
        }
        return $total;
}

function get_overall_g($search_arr, $conn_ircs, $processDetailsGood)
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




function get_rows_overall_ng($search_arr, $conn_ircs, $conn_pcad)
{
        // $insp_overall_ng = 0;
        $insp_overall_ng = array();

        // Fetch processes and their corresponding IP addresses
        $processesAndIpAddresses = getIpAddressesFromDatabase($search_arr['registlinename'], $conn_pcad);

        if (!empty($processesAndIpAddresses)) {
                foreach ($processesAndIpAddresses as $processData) {
                        $process = $processData['process'];
                        $ipaddresscolumn = $processData['ipaddresscolumn'];
                        $ipAddresses = $processData['ipAddresses'];

                        $judgmentColumnGood = "";
                        $judgmentColumnNG = "";
                        $ipJudgementColumn = "";

                        switch ($process) {
                                case "Dimension":
                                        $ipJudgementColumn = "INSPECTION1FINISHDATETIME";
                                        $judgmentColumnGood = "INSPECTION1FINISHDATETIME";
                                        $judgmentColumnNG = "INSPECTION1JUDGMENT";
                                        break;
                                case "Electric":
                                        $ipJudgementColumn = "INSPECTION2FINISHDATETIME";
                                        $judgmentColumnGood = "INSPECTION2FINISHDATETIME";
                                        $judgmentColumnNG = "INSPECTION2JUDGMENT";
                                        break;
                                case "Visual":
                                        $ipJudgementColumn = "INSPECTION3FINISHDATETIME";
                                        $judgmentColumnGood = "INSPECTION3FINISHDATETIME";
                                        $judgmentColumnNG = "INSPECTION3JUDGMENT";
                                        break;
                                case "Assurance":
                                        $ipJudgementColumn = "INSPECTION4FINISHDATETIME";
                                        $judgmentColumnGood = "INSPECTION4FINISHDATETIME";
                                        $judgmentColumnNG = "INSPECTION4JUDGMENT";
                                        break;
                                default:
                                        break;
                        }

                        $processDetailsNG = array(
                                'process' => $process,
                                'ipJudgementColumn' => $ipJudgementColumn,
                                'ipAddressColumn' => $ipaddresscolumn,
                                'judgmentColumn' => $judgmentColumnNG,
                                'ipAddresses' => $ipAddresses
                        );

                        $p_ng = get_overall_ng($search_arr, $conn_ircs, $conn_pcad, $processDetailsNG);

                        // $insp_overall_ng += $p_ng;
                        $insp_overall_ng[] = $p_ng;
                }
        }
        return $insp_overall_ng;
}

function get_overall_ng($search_arr, $conn_ircs, $conn_pcad, $processDetailsNG)
{
        $shift = $search_arr['shift'];
        $registlinename = addslashes($search_arr['registlinename']);
        $server_date_only = $search_arr['server_date_only'];
        $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
        $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
        $server_time = $search_arr['server_time'];

        // $total = 0;
        $total = array();

        // Check if the necessary parameters are provided
        if (!isset($processDetailsNG['ipAddressColumn']) || !isset($processDetailsNG['judgmentColumn']) || !isset($processDetailsNG['ipAddresses'])) {
                // Handle the case where the required parameters are not provided
                return $total;
        }

        $ipAddressColumn = $processDetailsNG['ipAddressColumn'];
        $ipJudgementColumn = $processDetailsNG['ipJudgementColumn'];
        $judgmentColumn = $processDetailsNG['judgmentColumn'];
        $process = $processDetailsNG['process'];

        // Get IP addresses from the database
        $ipAddresses = $processDetailsNG['ipAddresses'];

        if (empty($ipAddresses)) {
                // Handle the case where IP addresses are not found
                return $total;
        }

        $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";

        // $query = "SELECT COUNT(*) AS PROCESS_COUNT_NG FROM T_REPAIRWK WHERE $ipAddressColumn IN ($ipAddressesString) AND $judgmentColumn = '0' AND REGISTLINENAME = '$registlinename'";
        $query = "SELECT * FROM T_REPAIRWK WHERE $ipAddressColumn IN ($ipAddressesString) AND $judgmentColumn = '0' AND REGISTLINENAME = '$registlinename'";

        if ($shift == 'DS') {
                $query .= " AND $ipJudgementColumn BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        } elseif ($shift == 'NS') {
                if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
                        $query .= " AND $ipJudgementColumn BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                } elseif ($server_time >= '00:00:00' && $server_time < '06:00:00') {
                        $query .= " AND $ipJudgementColumn BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
                }
        }

        $stmt = oci_parse($conn_ircs, $query);
        oci_execute($stmt);

        while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                // $total = $row->PROCESS_COUNT_NG;
                $total[] = $row;
        }

        return $total;
}


?>