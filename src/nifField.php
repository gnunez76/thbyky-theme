<?php
//Arreglamos la dirección predeterminada
function agrega_campo_nif_formularios( $fields ) {

    $fields['billing_nif'] = array(
        'label' => __('NIF', 'woocommerce'),
        'placeholder' => _x('Ej: 99999999E', 'placeholder', 'woocommerce'),
        'required' => true,
        'class' => array('my-field-class form-row-wide'),
    );

    //Asigna nuevas clases de estilo a algunos campos del formulario
//    $fields[ 'company' ][ 'class' ][0] = 'form-row-last';
//    $fields[ 'company' ][ 'clear' ] = true;
//    $fields[ 'city' ][ 'class' ][0] = 'form-row-first';
//    $fields[ 'state' ][ 'class' ][0] = 'form-row-last update_totals_on_change';
//    $fields[ 'postcode' ][ 'class' ][0] .= ' update_totals_on_change';

    //Ordena los campos del formulario
    $orderedFields = array();
    $orderedFields = array_slice( $fields, 0, 2, true );

    $orderedFields[ 'billing_nif' ] = $fields['billing_nif'];
    $orderedFields = array_merge( $orderedFields, array_slice( $fields, 2 ) );

    return $orderedFields;
}
//add_filter('woocommerce_default_address_fields' , 'agrega_campo_nif_formularios');
add_filter('woocommerce_billing_fields' , 'agrega_campo_nif_formularios');

//Nueva función para hacer compatible el código con WooCommerce 2.1
function obtener_campo_personalizado( $field, $order) {
    $value = get_post_meta( $order, $field, false );

    if ( isset( $value[0] ) ) return $value[0];

    return NULL;
}

//Añade el NIF a la dirección de facturación y envío
add_filter('woocommerce_order_formatted_billing_address','agrega_campo_nif_direccion_facturacion', 1, 2);
function agrega_campo_nif_direccion_facturacion($fields, $order) {
    $fields['nif'] = obtener_campo_personalizado('_billing_nif', $order->id);

    return $fields;
}

//add_filter('woocommerce_order_formatted_shipping_address','agrega_campo_nif_direccion_envio', 1, 2);
//function agrega_campo_nif_direccion_envio($fields, $order) {
//    $fields['nif'] = obtener_campo_personalizado('_shipping_nif', $order->id);
//
//    return $fields;
//}

add_filter('woocommerce_formatted_address_replacements','formato_direccion_de_facturacion', 1, 2);
function formato_direccion_de_facturacion($fields, $argumentos) {
    $fields['{nif}'] = $argumentos['nif'];
    $fields['{nif_upper}'] = strtoupper($argumentos['nif']);

    return $fields;
}

//Reordena los campos de la dirección predeterminada
add_filter('woocommerce_localisation_address_formats','formato_direccion_localizacion' );
function formato_direccion_localizacion( $fields ) {

    $new_fields = $fields;

    foreach ( $fields as $country => $format ) {

        $new_fields[ $country ] = str_replace( "{company}" , "{company}\n{nif}", $format );
    }

    return $new_fields;
}

//Añade el campo CIF/NIF a usuarios
add_filter('woocommerce_customer_meta_fields', 'agrega_campos_administracion_usuarios');
function agrega_campos_administracion_usuarios($fields) {
    $orderedFields = array();

    $fields['billing']['fields']['billing_nif'] = array(
        'label' => __( 'NIF', 'woocommerce' ),
        'description' => ''
    );

    //Ordena los campos en el perfil del cliente
    $orderedFields[ 'billing' ][ 'title' ] = $fields['billing']['title'];

    $orderedFields[ 'billing' ][ 'fields' ] = array_slice( $fields['billing']['fields'], 0, 3, true );
    $orderedFields['billing']['fields']['billing_nif'] = $fields['billing']['fields']['billing_nif'];
    $orderedFields[ 'billing' ][ 'fields' ] = array_merge( $orderedFields[ 'billing' ][ 'fields' ], array_slice( $fields[ 'billing' ][ 'fields' ], 3 ) );
    $orderedFields[ 'shipping' ] = $fields['shipping'];

    return $orderedFields;
}

//Añadimos el NIF a la dirección de facturación y envío
add_filter('woocommerce_user_column_billing_address','agrega_campo_nif_usuario_direccion_facturacion', 1, 2);
function agrega_campo_nif_usuario_direccion_facturacion($fields, $user) {
    $fields['nif'] = get_user_meta($user, 'billing_nif', true);

    return $fields;
}

//Añade el campo NIF a Editar mi dirección
add_filter('woocommerce_my_account_my_address_formatted_address', 'agrega_campo_nif_editar_direccion', 10, 3);
function agrega_campo_nif_editar_direccion($fields, $user, $name) {
    $fields['nif'] = get_user_meta($user, $name . '_nif', true);

    //Ordena los campos
    $fields_nuevos['first_name'] = $fields['first_name'];
    $fields_nuevos['last_name'] = $fields['last_name'];
    $fields_nuevos['company'] = $fields['company'];
    $fields_nuevos['nif'] = $fields['nif'];
    $fields_nuevos['address_1'] = $fields['address_1'];
    $fields_nuevos['address_2'] = $fields['address_2'];
    $fields_nuevos['postcode'] = $fields['postcode'];
    $fields_nuevos['city'] = $fields['city'];
    $fields_nuevos['state'] = $fields['state'];
    $fields_nuevos['country'] = $fields['country'];

    return $fields_nuevos;
}

//Añade el campo NIF a Detalles del pedido
add_filter('woocommerce_admin_billing_fields', 'agrega_campo_nif_editar_direccion_pedido');
//add_filter('woocommerce_admin_shipping_fields', 'agrega_campo_nif_editar_direccion_pedido');
function agrega_campo_nif_editar_direccion_pedido( $fields ) {
    global $post;

    // Obtengo el NIF de la ficha de cliente si existe
    $order = new WC_Order( $post->ID );
    $customer_nif = get_user_meta( $order->user_id, 'billing_nif', true);

    $fields['nif'] = array(
        'label' => __('NIF', 'woocommerce'),
        'show'  => true,
        'value' => isset( $customer_nif )? $customer_nif : false,
    );

    //Ordena los campos
    $fields_nuevos['first_name'] = $fields['first_name'];
    $fields_nuevos['last_name'] = $fields['last_name'];
    $fields_nuevos['company'] = $fields['company'];
    $fields_nuevos['nif'] = $fields['nif'];
    $fields_nuevos['address_1'] = $fields['address_1'];
    $fields_nuevos['address_2'] = $fields['address_2'];
    $fields_nuevos['postcode'] = $fields['postcode'];
    $fields_nuevos['city'] = $fields['city'];
    $fields_nuevos['state'] = $fields['state'];
    $fields_nuevos['country'] = $fields['country'];

    return $fields_nuevos;
}

//add_filter( 'woocommerce_found_customer_details', 'carga_el_nif_en_datos_cliente_crear_nuevo_pedido', 10, 3 );
//function carga_el_nif_en_datos_cliente_crear_nuevo_pedido( $customer_data, $user_id, $type_to_load ){
//
//    $customer_data[ $type_to_load . '_nif' ] = get_user_meta( $user_id, $type_to_load . '_nif', true );
//
//    return $customer_data;
//}