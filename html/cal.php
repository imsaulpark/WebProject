<?php

$last_day = date("t", time()); //총 요일 수
$start_day = date("w", strtotime(date("Y-m")."-01")); //시작 요일
$total_week = ceil(($last_day + $start_day)/7); // 총 요일
$last_week = date('w',strtotime(date("Y-m")."-".$last_day));

?>

<!DOCTYPE>
<HTML>
<head>
</head>
    <body>
        <table width='500' cellpadding='0' cellspacing="1" bgcolor="#999999">
           <tr>
                <td height="50" align="center" bgcolor="#FFFFFF" colspan="7">
                     님 빨리 변경좀제발유 
                     <?=date("Y년 n월")?>
                     
                </td>
            </tr>
          <tr>
                <td width="60" height="60" align="center" bgcolor="#DDDDDDD">일</td>
                <td align="center" bgcolor="#DDDDDDD">월</td>
                <td align="center" bgcolor="#DDDDDDD">화</td>
                <td align="center" bgcolor="#DDDDDDD">수</td>
                <td align="center" bgcolor="#DDDDDDD">목</td>
                <td align="center" bgcolor="#DDDDDDD">금</td>
                <td align="center" bgcolor="#DDDDDDD">토</td>
            </tr>

            <?php 
/*
                $day=1; //달력초기 값
                for($i=1; $i<=$total_week; $i++){
                    echo "$total_week";
            ?><tr width="60" height="60"><?php}
            
                
                //가로칸 생성 7칸 월~일
                for($j=0; $j<7; $j++)
                    { ?> 제발
 
                <td height="30" align="center" bgcolor="#FFFFFF">
                </td> 흐으으음
                <?php } ?>
                
*/

    $day=1;

    // 6. 총 주 수에 맞춰서 세로줄 만들기
    for($i=1; $i <= $total_week; $i++){?>

        <tr>
        <?php
        // 7. 총 가로칸 만들기
        for ($j=0; $j<7; $j++){
        ?>
	        <td height="30" align="center" bgcolor="#FFFFFF">
	        왜안될까?
	        </td>
        <?php } ?>
        </tr>
    <?php } ?>
       </table>

    </body>

</HTML>