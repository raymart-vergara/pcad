<?php

// IRCS / Inspection Output Functions
// Must Require Database Config "../conn/pcad.php" before using this functions
// Must Require Database Config "../conn/ircs.php" before using this functions

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
   $day = $search_arr['day'];
   $day_tomorrow = $search_arr['day_tomorrow'];
   $opt = $search_arr['opt'];

   $start_date = '';
   $end_date = '';
   $start_time_ds = ' 06:00:00';
   $end_time_ds = ' 17:59:59';
   $start_time_ns = ' 18:00:00';
   $end_time_ns = ' 05:59:59';

   $total = 0;

   $date_column = $final_process;

   $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";

   $query = "SELECT COUNT(*) AS OUTPUT FROM T_PRODUCTWK WHERE REGISTLINENAME = '$registlinename'";

   if (!empty($ipAddresses)) {
      $query .= " AND $ipaddresscolumn IN ($ipAddressesString)";
   }

   if ($opt == 2) {
      if ($shift == 'DS') {
         $start_date = $day . $start_time_ds;
         $end_date = $day . $end_time_ds;
      } else if ($shift == 'NS') {
         $start_date = $day . $start_time_ns;
         $end_date = $day_tomorrow . $end_time_ns;
      }
   } else if ($shift == 'DS') {
      $start_date = $server_date_only . $start_time_ds;
      $end_date = $server_date_only . $end_time_ds;
   } else if ($shift == 'NS') {
      if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
         $start_date = $server_date_only . $start_time_ns;
         $end_date = $server_date_only_tomorrow . $end_time_ns;
      } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
         $start_date = $server_date_only_yesterday . $start_time_ns;
         $end_date = $server_date_only . $end_time_ns;
      }
   }

   $query .= "AND $date_column BETWEEN TO_DATE('$start_date', 'yyyy-MM-dd HH24:MI:SS') 
                                AND TO_DATE('$end_date', 'yyyy-MM-dd HH24:MI:SS')";

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
   $processesAndIpAddresses = getIpAddressesFromDatabase($search_arr['registlinename'], $search_arr['line_no'], $conn_pcad);

   if (!empty($processesAndIpAddresses)) {
      foreach ($processesAndIpAddresses as $processData) {
         $process = $processData['process'];
         $ipaddresscolumn = $processData['ipaddresscolumn'];
         $ipAddresses = $processData['ipAddresses'];

         $judgmentColumnNG = $processData['judgement'];
         $date_column = $processData['finishdatetime'];

         $processDetailsNG = array(
            'process' => $process,
            'date_column' => $date_column,
            'ipAddressColumn' => $ipaddresscolumn,
            'judgmentColumn' => $judgmentColumnNG,
            'ipAddresses' => $ipAddresses
         );

         $p_ng = countProcessNG($search_arr, $conn_ircs, $processDetailsNG);

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
   $server_date_only = $search_arr['server_date_only'];
   $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
   $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
   $server_time = $search_arr['server_time'];
   $day = $search_arr['day'];
   $day_tomorrow = $search_arr['day_tomorrow'];
   $opt = $search_arr['opt'];

   $start_date = '';
   $end_date = '';
   $start_time_ds = ' 06:00:00';
   $end_time_ds = ' 17:59:59';
   $start_time_ns = ' 18:00:00';
   $end_time_ns = ' 05:59:59';

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

   if ($opt == 2) {
      if ($shift == 'DS') {
         $start_date = $day . $start_time_ds;
         $end_date = $day . $end_time_ds;
      } else if ($shift == 'NS') {
         $start_date = $day . $start_time_ns;
         $end_date = $day_tomorrow . $end_time_ns;
      }
   } else if ($shift == 'DS') {
      $start_date = $server_date_only . $start_time_ds;
      $end_date = $server_date_only . $end_time_ds;
   } else if ($shift == 'NS') {
      if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
         $start_date = $server_date_only . $start_time_ns;
         $end_date = $server_date_only_tomorrow . $end_time_ns;
      } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
         $start_date = $server_date_only_yesterday . $start_time_ns;
         $end_date = $server_date_only . $end_time_ns;
      }
   }

   $query .= " AND $date_column BETWEEN TO_DATE('$start_date', 'yyyy-MM-dd HH24:MI:SS') 
                                AND TO_DATE('$end_date', 'yyyy-MM-dd HH24:MI:SS')";

   $stmt = oci_parse($conn_ircs, $query);
   oci_execute($stmt);

   while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
      $total = $row->PROCESS_COUNT_GOOD;
   }

   return $total;
}

// 
function countProcessNG($search_arr, $conn_ircs, $processDetailsNG)
{
   $shift = $search_arr['shift'];
   $registlinename = addslashes($search_arr['registlinename']);

   $server_date_only = $search_arr['server_date_only'];
   $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
   $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
   $server_time = $search_arr['server_time'];
   $day = $search_arr['day'];
   $day_tomorrow = $search_arr['day_tomorrow'];
   $opt = $search_arr['opt'];

   $start_date = '';
   $end_date = '';
   $start_time_ds = ' 06:00:00';
   $end_time_ds = ' 17:59:59';
   $start_time_ns = ' 18:00:00';
   $end_time_ns = ' 05:59:59';

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

   if ($opt == 2) {
      if ($shift == 'DS') {
         $start_date = $day . $start_time_ds;
         $end_date = $day . $end_time_ds;
      } else if ($shift == 'NS') {
         $start_date = $day . $start_time_ns;
         $end_date = $day_tomorrow . $end_time_ns;
      }
   } else if ($shift == 'DS') {
      $start_date = $server_date_only . $start_time_ds;
      $end_date = $server_date_only . $end_time_ds;
   } else if ($shift == 'NS') {
      if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
         $start_date = $server_date_only . $start_time_ns;
         $end_date = $server_date_only_tomorrow . $end_time_ns;
      } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
         $start_date = $server_date_only_yesterday . $start_time_ns;
         $end_date = $server_date_only . $end_time_ns;
      }
   }

   $query .= " AND $date_column BETWEEN TO_DATE('$start_date', 'yyyy-MM-dd HH24:MI:SS') 
                                AND TO_DATE('$end_date', 'yyyy-MM-dd HH24:MI:SS')";

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

   $ircs_line_data_arr = $search_arr['ircs_line_data_arr'];
   $final_process = $ircs_line_data_arr['final_process'];
   $ipaddresscolumn = $ircs_line_data_arr['ipaddresscolumn'];
   $ipAddresses = $ircs_line_data_arr['ipAddresses'];

   $server_date_only = $search_arr['server_date_only'];
   $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
   $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
   $server_time = $search_arr['server_time'];
   $hourly_output_date = $search_arr['hourly_output_date'];
   $hourly_output_date_tomorrow = $search_arr['hourly_output_date_tomorrow'];
   $opt = $search_arr['opt'];

   $start_date = '';
   $end_date = '';
   $start_time_ds = ' 06:00:00';
   $end_time_ds = ' 17:59:59';
   $start_time_ns = ' 18:00:00';
   $end_time_ns = ' 05:59:59';

   $total = array();

   $date_column = $final_process;

   $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";

   $query = "SELECT * FROM T_PRODUCTWK WHERE REGISTLINENAME = '$registlinename'";

   if (!empty($ipAddresses)) {
      $query .= " AND $ipaddresscolumn IN ($ipAddressesString)";
   }

   if ($opt == 2) {
      if ($shift == 'DS') {
         $start_date = $hourly_output_date . $start_time_ds;
         $end_date = $hourly_output_date . $end_time_ds;
      } else if ($shift == 'NS') {
         $start_date = $hourly_output_date . $start_time_ns;
         $end_date = $hourly_output_date_tomorrow . $end_time_ns;
      }
   } else if ($shift == 'DS') {
      $start_date = $server_date_only . $start_time_ds;
      $end_date = $server_date_only . $end_time_ds;
   } else if ($shift == 'NS') {
      if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
         $start_date = $server_date_only . $start_time_ns;
         $end_date = $server_date_only_tomorrow . $end_time_ns;
      } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
         $start_date = $server_date_only_yesterday . $start_time_ns;
         $end_date = $server_date_only . $end_time_ns;
      }
   }

   $query .= "AND $date_column BETWEEN TO_DATE('$start_date', 'yyyy-MM-dd HH24:MI:SS') 
                                AND TO_DATE('$end_date', 'yyyy-MM-dd HH24:MI:SS')";

   $stmt = oci_parse($conn_ircs, $query);
   oci_execute($stmt);
   while ($row = oci_fetch_assoc($stmt)) {
      $total[] = $row;
   }
   return $total;
}

function get_rows_overall_ng($search_arr, $conn_ircs, $conn_pcad)
{
   $insp_overall_ng = array();

   // Fetch processes and their corresponding IP addresses
   $processesAndIpAddresses = getIpAddressesFromDatabase($search_arr['registlinename'], $search_arr['line_no'], $conn_pcad);

   if (!empty($processesAndIpAddresses)) {
      foreach ($processesAndIpAddresses as $processData) {
         $process = $processData['process'];
         $ipaddresscolumn = $processData['ipaddresscolumn'];
         $ipAddresses = $processData['ipAddresses'];

         $judgmentColumnNG = $processData['judgement'];
         $ipJudgementColumn = $processData['finishdatetime'];

         $processDetailsNG = array(
            'process' => $process,
            'ipJudgementColumn' => $ipJudgementColumn,
            'ipAddressColumn' => $ipaddresscolumn,
            'judgmentColumn' => $judgmentColumnNG,
            'ipAddresses' => $ipAddresses
         );

         $p_ng = get_overall_ng($search_arr, $conn_ircs, $processDetailsNG);

         foreach ($p_ng as $row) {
            $insp_overall_ng[] = $row;
         }
      }
   }
   return $insp_overall_ng;
}

function get_overall_ng($search_arr, $conn_ircs, $processDetailsNG)
{
   $shift = $search_arr['shift'];
   $registlinename = addslashes($search_arr['registlinename']);
   $server_date_only = $search_arr['server_date_only'];
   $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
   $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
   $server_time = $search_arr['server_time'];
   $hourly_ng_date = $search_arr['hourly_ng_date'];
   $hourly_ng_date_tomorrow = $search_arr['hourly_ng_date_tomorrow'];
   $opt = $search_arr['opt'];

   $start_date = '';
   $end_date = '';
   $start_time_ds = ' 06:00:00';
   $end_time_ds = ' 17:59:59';
   $start_time_ns = ' 18:00:00';
   $end_time_ns = ' 05:59:59';

   $total = array();

   // Check if the necessary parameters are provided
   if (!isset($processDetailsNG['ipAddressColumn']) || !isset($processDetailsNG['judgmentColumn']) || !isset($processDetailsNG['ipAddresses'])) {
      // Handle the case where the required parameters are not provided
      return $total;
   }

   $ipAddressColumn = $processDetailsNG['ipAddressColumn'];
   $ipJudgementColumn = $processDetailsNG['ipJudgementColumn'];
   $judgmentColumn = $processDetailsNG['judgmentColumn'];

   // Get IP addresses from the database
   $ipAddresses = $processDetailsNG['ipAddresses'];

   if (empty($ipAddresses)) {
      // Handle the case where IP addresses are not found
      return $total;
   }

   $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";

   // $query = "SELECT COUNT(*) AS PROCESS_COUNT_NG FROM T_REPAIRWK 
   //             WHERE $ipAddressColumn IN ($ipAddressesString) 
   //             AND $judgmentColumn = '0' AND REGISTLINENAME = '$registlinename'";

   $query = "SELECT * FROM T_REPAIRWK WHERE REGISTLINENAME = '$registlinename' AND $judgmentColumn = '0'";

   if (!empty($ipAddresses)) {
      $query .= " AND $ipAddressColumn IN ($ipAddressesString)";
   }

   if ($opt == 2) {
      if ($shift == 'DS') {
         $start_date = $hourly_ng_date . $start_time_ds;
         $end_date = $hourly_ng_date . $end_time_ds;
      } else if ($shift == 'NS') {
         $start_date = $hourly_ng_date . $start_time_ns;
         $end_date = $hourly_ng_date_tomorrow . $end_time_ns;
      }
   } else if ($shift == 'DS') {
      $start_date = $server_date_only . $start_time_ds;
      $end_date = $server_date_only . $end_time_ds;
   } else if ($shift == 'NS') {
      if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
         $start_date = $server_date_only . $start_time_ns;
         $end_date = $server_date_only_tomorrow . $end_time_ns;
      } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
         $start_date = $server_date_only_yesterday . $start_time_ns;
         $end_date = $server_date_only . $end_time_ns;
      }
   }

   $query .= " AND $ipJudgementColumn BETWEEN TO_DATE('$start_date', 'yyyy-MM-dd HH24:MI:SS') 
                                AND TO_DATE('$end_date', 'yyyy-MM-dd HH24:MI:SS')";

   $stmt = oci_parse($conn_ircs, $query);
   oci_execute($stmt);

   while ($row = oci_fetch_assoc($stmt)) {
      $total[] = $row;
   }

   return $total;
}


// Actual Hourly Output
function count_actual_hourly_output($search_arr, $conn_ircs)
{
   $registlinename = addslashes($search_arr['registlinename']);

   $ircs_line_data_arr = $search_arr['ircs_line_data_arr'];
   $final_process = $ircs_line_data_arr['final_process'];
   $ipaddresscolumn = $ircs_line_data_arr['ipaddresscolumn'];
   $ipAddresses = $ircs_line_data_arr['ipAddresses'];

   $day = $search_arr['day'];
   $day_tomorrow = $search_arr['day_tomorrow'];

   $date_column = $final_process;

   $total = 0;

   $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";

   $start_date = '';
   $end_date = '';
   $start_time = ':00:00';
   $end_time = ':59:59';
   $server_hour = '';

   if ($search_arr['opt'] == 2) {
      if ($search_arr['shift'] == 'DS') {
         $server_hour = " " . date('H',(strtotime("17")));

         $start_date = $day . $server_hour . $start_time;
         $end_date = $day . $server_hour . $end_time;
      } else if ($search_arr['shift'] == 'NS') {
         $server_hour = " " . date('H',(strtotime("05")));

         $start_date = $day_tomorrow . $server_hour . $start_time;
         $end_date = $day_tomorrow . $server_hour . $end_time;
      }
   } else {
      $server_hour = " " . date('H');

      $start_date = $search_arr['server_date_only'] . $server_hour . $start_time;
      $end_date = $search_arr['server_date_only'] . $server_hour . $end_time;
   }

   // SELECT COUNT(PARTSNAME) AS HOURLY_OUTPUT FROM T_PRODUCTWK
   // WHERE INSPECTION4IPADDRESS IN ('172.25.161.166','172.25.166.83')
   // AND REGISTLINENAME = 'DAIHATSU_30' 
   // AND INSPECTION4FINISHDATETIME BETWEEN TO_DATE('2024-02-29 14:00:00', 'yyyy-MM-dd HH24:MI:SS') 
   // AND TO_DATE('2024-02-29 14:59:59', 'yyyy-MM-dd HH24:MI:SS');
   $query = "SELECT COUNT(PARTSNAME) AS HOURLY_OUTPUT 
            FROM T_PRODUCTWK WHERE REGISTLINENAME = '$registlinename'";

   if (!empty($ipAddresses)) {
      $query = $query . " AND $ipaddresscolumn IN ($ipAddressesString)";
   }

   $query = $query . "AND $date_column BETWEEN TO_DATE('$start_date', 'yyyy-MM-dd HH24:MI:SS') 
                        AND TO_DATE('$end_date', 'yyyy-MM-dd HH24:MI:SS')";

   $stmt = oci_parse($conn_ircs, $query);
   oci_execute($stmt);
   while ($row = oci_fetch_object($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
      $total = $row->HOURLY_OUTPUT;
   }

   return $total;
}

// Actual Hourly Output Per Process
function count_actual_hourly_output_process($search_arr, $conn_ircs, $processDetailsGood)
{
   $registlinename = addslashes($search_arr['registlinename']);

   $ipAddressColumn = $processDetailsGood['ipAddressColumn'];
   $date_column = $processDetailsGood['date_column'];
   $ipAddresses = $processDetailsGood['ipAddresses'];

   $start_date = '';
   $end_date = '';

   if ($search_arr['opt'] == 2) {
      $start_date = $search_arr['hourly_output_date'];
      $end_date = $search_arr['hourly_output_date_tomorrow'];
   } else if ($search_arr['server_time'] >= '00:00:00' && $search_arr['server_time'] < '06:00:00') {
      $start_date = $search_arr['server_date_only_yesterday'];
      $end_date = $search_arr['server_date_only'];
   } else {
      $start_date = $search_arr['server_date_only'];
      $end_date = $search_arr['server_date_only_tomorrow'];
   }

   $total = array();

   $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";

   $query = "SELECT DAY, HOUR, COUNT(*) AS TOTAL FROM (
                SELECT TO_CHAR(T_PRODUCTWK.$date_column, 'YYYY-MM-DD HH24') AS DATE_TIME,
                TO_CHAR(T_PRODUCTWK.$date_column, 'YYYY-MM-DD') AS DAY,
                TO_CHAR(T_PRODUCTWK.$date_column, 'HH24') AS HOUR, REGISTLINENAME 
                FROM T_PRODUCTWK
                WHERE REGISTLINENAME = '$registlinename'";

   if (!empty($ipAddresses)) {
      $query = $query . " AND $ipAddressColumn IN ($ipAddressesString)";
   }

   $query = $query . "AND T_PRODUCTWK.$date_column BETWEEN TO_DATE('$start_date 06:00:00', 'yyyy-MM-dd HH24:MI:SS') 
                                AND TO_DATE('$end_date 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";

   $query = $query . ") GROUP BY REGISTLINENAME, DAY, HOUR, DATE_TIME ORDER BY DATE_TIME";


   $stmt = oci_parse($conn_ircs, $query);
   oci_execute($stmt);
   while ($row = oci_fetch_assoc($stmt)) {
      $total[] = $row;
   }

   return $total;
}

// no good hourly output per process
function count_actual_ng_hourly_output_process($search_arr, $conn_ircs, $processDetailsNG)
{
   $registlinename = addslashes($search_arr['registlinename']);

   $ipAddressColumn = $processDetailsNG['ipAddressColumn'];
   $date_column = $processDetailsNG['date_column'];
   $judgmentColumn = $processDetailsNG['judgmentColumn'];

   $ipAddresses = $processDetailsNG['ipAddresses'];

   $start_date = '';
   $end_date = '';

   if ($search_arr['opt'] == 2) {
      $start_date = $search_arr['hourly_ng_date'];
      $end_date = $search_arr['hourly_ng_date_tomorrow'];
   } else if ($search_arr['server_time'] >= '00:00:00' && $search_arr['server_time'] < '06:00:00') {
      $start_date = $search_arr['server_date_only_yesterday'];
      $end_date = $search_arr['server_date_only'];
   } else {
      $start_date = $search_arr['server_date_only'];
      $end_date = $search_arr['server_date_only_tomorrow'];
   }

   $total = array();

   $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";

   $query = "SELECT DAY, HOUR, COUNT(*) AS TOTAL FROM (
                SELECT TO_CHAR(T_REPAIRWK.$date_column, 'YYYY-MM-DD HH24') AS DATE_TIME,
                TO_CHAR(T_REPAIRWK.$date_column, 'YYYY-MM-DD') AS DAY,
                TO_CHAR(T_REPAIRWK.$date_column, 'HH24') AS HOUR, REGISTLINENAME 
                FROM T_REPAIRWK
                WHERE REGISTLINENAME = '$registlinename' AND $judgmentColumn = '0'";

   if (!empty($ipAddresses)) {
      $query = $query . " AND $ipAddressColumn IN ($ipAddressesString)";
   }

   $query = $query . "AND T_REPAIRWK.$date_column BETWEEN TO_DATE('$start_date 06:00:00', 'YYYY-MM-DD HH24:MI:SS') 
                                AND TO_DATE('$end_date 05:59:59', 'YYYY-MM-DD HH24:MI:SS')";

   $query = $query . ") GROUP BY REGISTLINENAME, DAY, HOUR, DATE_TIME ORDER BY DATE_TIME";


   $stmt = oci_parse($conn_ircs, $query);

   oci_execute($stmt);
   while ($row = oci_fetch_assoc($stmt)) {
      $total[] = $row;
   }

   return $total;
}

// Overall Inspection List
function get_overall_inspection_list($search_arr, $conn_ircs, $conn_pcad) {
   $response_arr = array();

   // Fetch processes and their corresponding IP addresses
   $processesAndIpAddresses = getIpAddressesFromDatabase($search_arr['registlinename'], $search_arr['line_no'], $conn_pcad);

   if (!empty($processesAndIpAddresses)) {
      foreach ($processesAndIpAddresses as $processData) {
         $process = $processData['process'];
         $ipaddresscolumn = $processData['ipaddresscolumn'];
         $ipAddresses = $processData['ipAddresses'];

         $judgmentColumnNG2 = $processData['judgement'];
         $date_column = $processData['finishdatetime'];

         $search_arr = array(
            'day' => $search_arr['day'],
            'day_tomorrow' => $search_arr['day_tomorrow'],
            'shift' => $search_arr['shift'],
            'registlinename' => $search_arr['registlinename'],
            'server_date_only' => $search_arr['server_date_only'],
            'server_date_only_yesterday' => $search_arr['server_date_only_yesterday'],
            'server_date_only_tomorrow' => $search_arr['server_date_only_tomorrow'],
            'server_time' => $search_arr['server_time'],
            'opt' => $search_arr['opt']
         );

         $processDetailsGood = array(
            'process' => $process,
            'date_column' => $date_column,
            'ipAddressColumn' => $ipaddresscolumn,
            'ipAddresses' => $ipAddresses
         );

         $processDetailsNG = array(
            'process' => $process,
            'date_column' => $date_column,
            'ipAddressColumn' => $ipaddresscolumn,
            'judgmentColumn' => $judgmentColumnNG2,
            'ipAddresses' => $ipAddresses
         );

         $p_good = countProcessGood($search_arr, $conn_ircs, $processDetailsGood);
         $p_ng = countProcessNG($search_arr, $conn_ircs, $processDetailsNG);

         $response_arr[] = array(
            'p_good' => $p_good,
            'process' => $process,
            'p_ng' => $p_ng
         );
      }
   }

   return $response_arr;
}
