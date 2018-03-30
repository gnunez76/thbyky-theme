<?php

/**
 * Añade el campo NIF a la página de checkout de WooCommerce
 */
add_action( 'woocommerce_before_order_notes', 'agrega_mi_campo_personalizado' );

function agrega_mi_campo_personalizado( $checkout ) {

    echo '<div id="additional_checkout_field"></h2>';

    woocommerce_form_field( 'nif', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('NIF'),
        'required'      => true,
        'placeholder'   => __('Introduce tu NIF'),
    ), $checkout->get_value( 'nif' ));

    echo '</div>';

}
/**
 * Comprueba que el campo NIF no esté vacío
 */
add_action('woocommerce_checkout_process', 'comprobar_campo_nif');

function comprobar_campo_nif() {

    // Comprueba si se ha introducido un valor y si está vacío se muestra un error.
    if ( ! $_POST['nif'] )
        wc_add_notice( __( 'El NIF es un campo requerido.' ), 'error' );
}

/**
 * Actualiza la información del pedido con el nuevo campo
 */
add_action( 'woocommerce_checkout_update_order_meta', 'actualizar_info_pedido_con_nuevo_campo' );

function actualizar_info_pedido_con_nuevo_campo( $order_id ) {
    if ( ! empty( $_POST['nif'] ) ) {
        update_post_meta( $order_id, 'NIF', sanitize_text_field( $_POST['nif'] ) );
    }
}

/**
 * Muestra el valor del nuevo campo NIF en la página de edición del pedido
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'mostrar_campo_personalizado_en_admin_pedido', 10, 1 );

function mostrar_campo_personalizado_en_admin_pedido($order){
    echo '<p><strong>'.__('NIF').':</strong> ' . get_post_meta( $order->id, 'NIF', true ) . '</p>';
}

/**
 * Incluye el campo NIF en el email de notificación del cliente
 */

add_filter('woocommerce_email_order_meta_keys', 'muestra_campo_personalizado_email');

function muestra_campo_personalizado_email( $keys ) {
    $keys[] = 'NIF';
    return $keys;
}