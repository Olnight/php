<?php
date_default_timezone_set('Asia/Yekaterinburg');

function format(int $price): string {
    return number_format($price, 0, '.', ' ').' ₽';
}
function lastTime(string $dateEnd) : array{
    //преобразование
    $currentDate = time();
    $endDate = strtotime($dateEnd.'+ 1 day'.'+ 1 minute');
    $COUNT_SECONDS = 3600;
    $COUNT_MINUTES = 60;
    //интервал между датами
    $hours = str_pad(floor(($endDate - $currentDate)/ $COUNT_SECONDS), 2, "0", STR_PAD_LEFT);
    $minutes = str_pad(floor((($endDate - $currentDate)% $COUNT_SECONDS)/$COUNT_MINUTES), 2, "0", STR_PAD_LEFT);
    return [$hours, $minutes];
}
function addStyle(string $dateEnd){
    $hour = 1;
    $COUNT_MINUTES = 60;
    $hours = floor((strtotime($dateEnd)-time())/$COUNT_MINUTES);
    $isAddStyle = $hours < $hour;
    return $isAddStyle ? "timer--finishing":"";
}
function getNewLots(mysqli $con): array{
    $sql = "SELECT
    l.name,
    l.start_price,
    l.image,
    c.name AS categoryName,
    l.end_date
FROM Lot AS l
    INNER JOIN Category AS c ON l.category_id = c.id
WHERE l.end_date > CURRENT_DATE
ORDER BY l.creation_date DESC";
    return mysqli_fetch_all(mysqli_query($con, $sql), MYSQLI_ASSOC);
}

function getCategories(mysqli $con): array{
    $sql = "SELECT * FROM Category";
    return mysqli_fetch_all(mysqli_query($con, $sql), MYSQLI_ASSOC);
}

function lot_detail(mysqli $con, int $id_lot):array{
    $sql = "SELECT
    l.name as name_lot, 
    l.image, 
    l.start_price, 
    l.end_date,
    c.name AS categoryName
FROM Lot AS l
    INNER JOIN Category AS c ON l.category_id = c.id 
    WHERE l.id = ?";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_lot);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($res,MYSQLI_ASSOC);
    return $rows;
}