<?php
require_once './vendor/autoload.php';

function google_custom_search_api($query, $page=0)
{
    $api_key = "*****************************"; // api_key
    $cx = "**********************************"; // cx

    $limit = 10;
    $start = $page == 0 ? '1' : (string)($page * $limit);

    // 検索用URL
    $search_url = "https://www.googleapis.com/customsearch/v1?";

    // 検索パラメタ発行
    $params_list = array(
        'q' => $query,
        'key' => $api_key,
        'cx' => $cx,
        'alt' => 'json',
        'start' => $start,
        'num' => $limit,
    );
    // リクエストパラメータ作成
    $req_param = http_build_query($params_list);

    // リクエスト本体作成
    $request = $search_url . $req_param;

    // jsonデータ取得
    $json = file_get_contents($request, true);
    $json_d = json_decode($json, true);

    // jsonデータ保存
    file_put_contents("./json/search_".$query."_".$page.".json", json_encode($json_d, JSON_UNESCAPED_UNICODE));

    return $json_d;
}

$query = "keyword"; // 検索キーワード入力

google_custom_search_api($keyword, 0); // 1ページ目を検索
google_custom_search_api($keyword, 1); // 2ページ目を検索

?>
