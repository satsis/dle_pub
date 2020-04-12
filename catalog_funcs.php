$folder = "";
$vendors_curr_i_down = "";
$vendors_curr_i_down = get_vars_catalogue ( $folder, "vendors_currency" );
if (! $vendors_curr_i_down) {
    $vendors_curr_i_down = array ();

    $result = $db->query ( "SELECT vc.currency_id, vc.rate, name,vendor_id FROM `" . $tabl_prefix . "_vendors_currency` vc LEFT JOIN `" . $tabl_prefix . "_currency` c ON (c.id = vc.currency_id) WHERE `vendor_id` IN (SELECT `id` FROM `" . $tabl_prefix . "_vendors` ORDER BY `id` ASC) ORDER BY `vendor_id`,`currency_id`" );
    while ( $row = $db->get_row ( $result ) ) {
        $id_v = $row['vendor_id'];
            unset($row['vendor_id']);
            foreach ( $row as $key => $value ) {
                $vendors_curr_i_down[$id_v][$row['currency_id']][$key]= $value;
            }
    }
    set_vars_catalogue ( $folder, "vendors_currency", $vendors_curr_i_down );
    $folder = "";
    $db->free ( $result );
}
