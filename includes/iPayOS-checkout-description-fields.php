<?php

add_filter( 'woocommerce_gateway_description', 'techiepress_iPayOS_description_fields', 20, 2 );
add_action( 'woocommerce_checkout_process', 'techiepress_iPayOS_description_amount_fields_validation' );
// add_action( 'woocommerce_checkout_process', 'techiepress_iPayOS_description_email_fields_validation' );
// add_action( 'woocommerce_checkout_process', 'techiepress_iPayOS_description_mobile_number_fields_validation' );
add_action( 'woocommerce_checkout_update_order_meta', 'techiepress_checkout_update_order_meta', 10, 1 );
// add_action( 'woocommerce_admin_order_data_after_billing_address', 'techiepress_order_data_after_billing_address', 10, 1 );
// add_action( 'woocommerce_order_item_meta_end', 'techiepress_order_item_meta_end', 10, 3 );

function techiepress_iPayOS_description_fields( $description, $payment_id ) {

    if ( 'iPayOS' !== $payment_id ) {
        return $description;
    }
    
    ob_start();

    echo '<div style="display: block; width:300px; height:auto;">';
    echo '<img src="' . plugins_url('../assets/ipayos-black.png', __FILE__ ) . '">';
    

    // woocommerce_form_field(
    //     'amount',
    //     array(
    //         'type' => 'text',
    //         'label' =>__( 'Payment Amount', 'iPayOS-payments-woo' ),
    //         'class' => array( 'form-row', 'form-row-wide' ),
    //         'required' => true,
    //     )
    // );

    woocommerce_form_field(
        'email',
        array(
            'type' => 'text',
            'label' =>__( 'Payment E-mail', 'iPayOS-payments-woo' ),
            'class' => array( 'form-row', 'form-row-wide' ),
            'required' => true,
        )
    );

    woocommerce_form_field(
        'mobile_number',
        array(
            'type' => 'text',
            'label' =>__( 'Payment mobile number', 'iPayOS-payments-woo' ),
            'class' => array( 'form-row', 'form-row-wide' ),
            'required' => true,
        )
    );

    echo '</div>';

    $description .= ob_get_clean();

    return $description;
}

function techiepress_iPayOS_description_amount_fields_validation() {
    if('iPayOS' === $_POST['payment_method'] && ! isset( $_POST['email'] )  || empty( $_POST['email'] )) {
        wc_add_notice( 'Please enter your email', 'error' );
    } else {
        if( 'iPayOS' === $_POST['payment_method'] && ! isset( $_POST['mobile_number'] )  || empty( $_POST['mobile_number'] ) ) {
            wc_add_notice( 'Please enter your mobile_number number', 'error' );
        } 
    }
}

// function techiepress_iPayOS_description_email_fields_validation() {
//     if( 'iPayOS' === $_POST['payment_method'] && ! isset( $_POST['email'] )  || empty( $_POST['email'] ) ) {
//         wc_add_notice( 'Please enter your email', 'error' );
//     }
// }

// function techiepress_iPayOS_description_mobile_number_fields_validation() {
//     if( 'iPayOS' === $_POST['payment_method'] && ! isset( $_POST['mobile_number'] )  || empty( $_POST['mobile_number'] ) ) {
//         wc_add_notice( 'Please enter your mobile_number number', 'error' );
//     }
// }

function techiepress_checkout_update_order_meta( $order_id ) {
    if( (isset( $_POST['email'] ) || ! empty( $_POST['email'] )) && (isset( $_POST['mobile_number'] ) || ! empty( $_POST['mobile_number'] )) ) {
       update_post_meta( $order_id, 'email', $_POST['email'] );
    }
}