<?php
/* Template Name: Thank You Page */
get_template_part('parts/header');

// Ensure WooCommerce is loaded
if (class_exists('WooCommerce')) {
    // Get order ID and order key from the URL parameters
    $order_id = isset($_GET['order_id']) ? absint($_GET['order_id']) : 0;
    $order_key = isset($_GET['key']) ? sanitize_text_field($_GET['key']) : '';

    // Retrieve the WooCommerce order object
    $order = wc_get_order($order_id);

    // ❗ Validate the order exists and matches the provided key
    if (!$order || $order->get_order_key() !== $order_key) {
        echo '<div class="text-center py-20 text-red-600 font-bold text-xl">❌ Invalid or missing order details.</div>';
        get_template_part('parts/footer');
        return;
    }

    // Get customer details
    $billing_address = $order->get_billing_address_1() . ', ' . $order->get_billing_city() . ' ' . $order->get_billing_postcode();
    $shipping_address = $order->get_shipping_address_1() . ', ' . $order->get_shipping_city() . ' ' . $order->get_shipping_postcode();
    $shipping_total = $order->get_shipping_total();
    $order_total = $order->get_total();
}
?>
<!-- Tailwind CSS v2.2.19 -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />

<div class="py-14 px-4 md:px-6 2xl:px-20 2xl:container 2xl:mx-auto">
    <!--order number and date -->
    <div class="flex justify-start item-start space-y-2 flex-col">
        <h1 class="text-3xl dark:text-white lg:text-4xl font-semibold leading-7 lg:leading-9 text-gray-800">
            Order #<?php echo esc_html($order->get_id()); ?>
        </h1>
        <p class="text-base dark:text-gray-300 font-medium leading-6 text-gray-600">
            <?php echo date('jS F Y \a\t g:i A', strtotime($order->get_date_created())); ?>
        </p>
    </div>
    <div class="mt-10 flex flex-col xl:flex-row justify-center items-stretch w-full xl:space-x-8 space-y-4 md:space-y-6 xl:space-y-0">
        <div class="flex flex-col justify-start items-start w-full space-y-4 md:space-y-6 xl:space-y-8">
            <div class="flex flex-col justify-start items-start dark:bg-gray-800 bg-gray-50 px-4 py-4 md:py-6 md:p-6 xl:p-8 w-full">
                <p class="text-lg md:text-xl dark:text-white font-semibold leading-6 xl:leading-5 text-gray-800">
                    Customer’s Cart
                </p>
                <?php
                $items = $order->get_items();
                foreach ($items as $item_id => $item) :
                    $product = $item->get_product();
                    $product_name = $item->get_name();
                    $product_price = $product->get_price();
                    $product_quantity = $item->get_quantity();
                    $product_image = wp_get_attachment_url($product->get_image_id());
                    $product_total = $item->get_total();
                ?>
                    <div class="mt-4 md:mt-6 flex flex-col md:flex-row justify-start items-start md:items-center md:space-x-6 xl:space-x-8 w-full">
                        <div class="pb-4 md:pb-8 w-full md:w-40">
                            <img class="w-full hidden md:block" src="<?php echo esc_url($product_image); ?>" alt="product" />
                            <img class="w-full md:hidden" src="<?php echo esc_url($product_image); ?>" alt="product" />
                        </div>
                        <div class="border-b border-gray-200 md:flex-row flex-col flex justify-between items-start w-full pb-8 space-y-4 md:space-y-0">
                            <div class="w-full flex flex-col justify-start items-start space-y-8">
                                <h3 class="text-xl dark:text-white xl:text-2xl font-semibold leading-6 text-gray-800">
                                    <?php echo esc_html($product_name); ?>
                                </h3>
                            </div>
                            <div class="flex justify-between space-x-8 items-start w-full">
                                <p class="text-base dark:text-white xl:text-lg leading-6">
                                    <?php echo get_woocommerce_currency_symbol() . number_format($product_price, 2); ?>
                                </p>
                                <p class="text-base dark:text-white xl:text-lg leading-6 text-gray-800">
                                    <?php echo esc_html($product_quantity); ?>
                                </p>
                                <p class="text-base dark:text-white xl:text-lg font-semibold leading-6 text-gray-800">
                                    <?php echo get_woocommerce_currency_symbol() . number_format($product_total, 2); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Order Summary -->
            <div class="flex justify-center flex-col md:flex-row flex-col items-stretch w-full space-y-4 md:space-y-0 md:space-x-6 xl:space-x-8">
                <div class="flex flex-col px-4 py-6 md:p-6 xl:p-8 w-full bg-gray-50 dark:bg-gray-800 space-y-6">
                    <h3 class="text-xl dark:text-white font-semibold leading-5 text-gray-800">Summary</h3>
                    <div class="flex justify-center items-center w-full space-y-4 flex-col border-gray-200 border-b pb-4">
                        <div class="flex justify-between w-full">
                            <p class="text-base dark:text-white leading-4 text-gray-800">Subtotal</p>
                            <p class="text-base dark:text-gray-300 leading-4 text-gray-600">
                                <?php echo get_woocommerce_currency_symbol() . number_format($order->get_subtotal(), 2); ?>
                            </p>
                        </div>
                        <div class="flex justify-between items-center w-full">
                            <p class="text-base dark:text-white leading-4 text-gray-800">Discount</p>
                            <p class="text-base dark:text-gray-300 leading-4 text-gray-600">
                                <?php echo get_woocommerce_currency_symbol() . number_format($order->get_discount_total(), 2); ?>
                            </p>
                        </div>
                        <div class="flex justify-between items-center w-full">
                            <p class="text-base dark:text-white leading-4 text-gray-800">Shipping</p>
                            <p class="text-base dark:text-gray-300 leading-4 text-gray-600">
                                <?php echo get_woocommerce_currency_symbol() . number_format($order->get_shipping_total(), 2); ?>
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center w-full">
                        <p class="text-base dark:text-white font-semibold leading-4 text-gray-800">Total</p>
                        <p class="text-base dark:text-gray-300 font-semibold leading-4 text-gray-600">
                            <?php echo get_woocommerce_currency_symbol() . number_format($order->get_total(), 2); ?>
                        </p>
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="flex flex-col justify-center px-4 py-6 md:p-6 xl:p-8 w-full bg-gray-50 dark:bg-gray-800 space-y-6">
                    <h3 class="text-xl dark:text-white font-semibold leading-5 text-gray-800">Shipping</h3>
                    <div class="flex justify-between items-start w-full">
                        <div class="flex justify-center items-center space-x-4">
                            <div class="w-8 h-8">
                                <img class="w-full h-full" alt="logo" src="https://i.ibb.co/L8KSdNQ/image-3.png" />
                            </div>
                            <div class="flex flex-col justify-start items-center">
                                <p class="text-lg leading-6 dark:text-white font-semibold text-gray-800">
                                    <?php echo esc_html($order->get_shipping_method()); ?><br />
                                    <span class="font-normal">Delivery with 24 Hours</span>
                                </p>
                            </div>
                        </div>
                        <p class="text-lg font-semibold leading-6 dark:text-white text-gray-800">
                            <?php echo get_woocommerce_currency_symbol() . number_format($order->get_shipping_total(), 2); ?>
                        </p>
                    </div>
                    <div class="w-full flex justify-center items-center">
                        <button
                            class="hover:bg-black dark:bg-white dark:text-gray-800 dark:hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 py-5 w-96 md:w-full bg-gray-800 text-base font-medium leading-4 text-white">
                            View Carrier Details
                        </button>
                    </div>
                </div>

            </div>
        </div>


        <!-- Customer Details -->
        <div class="bg-gray-50 dark:bg-gray-800 w-full xl:w-96 flex justify-between items-center md:items-start px-4 py-6 md:p-6 xl:p-8 flex-col">
            <h3 class="text-xl dark:text-white font-semibold leading-5 text-gray-800">Customer</h3>
            <div class="flex flex-col md:flex-row xl:flex-col justify-start items-stretch h-full w-full md:space-x-6 lg:space-x-8 xl:space-x-0">
                <div class="flex flex-col justify-start items-start flex-shrink-0">
                    <!-- Customer Name and Previous Orders -->
                    <div class="flex justify-center w-full md:justify-start items-center space-x-4 py-8 border-b border-gray-200">
                        <img src="https://i.ibb.co/5TSg7f6/Rectangle-18.png" alt="avatar" />
                        <div class="flex justify-start items-start flex-col space-y-2">
                            <p class="text-base dark:text-white font-semibold leading-4 text-left text-gray-800">
                                <?php echo esc_html($order->get_billing_first_name() . ' ' . $order->get_billing_last_name()); ?>
                            </p>
                            <p class="text-sm dark:text-gray-300 leading-5 text-gray-600">
                                <?php
                                // Query for previous orders
                                $customer_id = $order->get_customer_id();
                                $orders = wc_get_orders(array(
                                    'customer_id' => $customer_id,
                                ));
                                echo count($orders) . ' Previous Orders';
                                ?>
                            </p>
                        </div>
                    </div>

                    <!-- Customer Email -->
                    <div class="flex justify-center text-gray-800 dark:text-white md:justify-start items-center space-x-4 py-4 border-b border-gray-200 w-full">
                        <img class="dark:hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/order-summary-3-svg1.svg" alt="email" />
                        <img class="hidden dark:block" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/order-summary-3-svg1dark.svg" alt="email" />
                        <p class="cursor-pointer text-sm leading-5">
                            <?php echo esc_html($order->get_billing_email()); ?>
                        </p>
                    </div>
                </div>

                <!-- Shipping and Billing Addresses -->
                <div class="flex justify-between xl:h-full items-stretch w-full flex-col mt-6 md:mt-0">
                    <div class="flex justify-center md:justify-start xl:flex-col flex-col md:space-x-6 lg:space-x-8 xl:space-x-0 space-y-4 xl:space-y-12 md:space-y-0 md:flex-row items-center md:items-start">
                        <!-- Shipping Address -->
                        <div class="flex justify-center md:justify-start items-center md:items-start flex-col space-y-4 xl:mt-8">
                            <p class="text-base dark:text-white font-semibold leading-4 text-center md:text-left text-gray-800">
                                Shipping Address
                            </p>
                            <p class="w-48 lg:w-full dark:text-gray-300 xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600">
                                <?php echo esc_html($shipping_address); ?>
                            </p>
                        </div>
                        <!-- Billing Address -->
                        <div class="flex justify-center md:justify-start items-center md:items-start flex-col space-y-4">
                            <p class="text-base dark:text-white font-semibold leading-4 text-center md:text-left text-gray-800">
                                Billing Address
                            </p>
                            <p class="w-48 lg:w-full dark:text-gray-300 xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600">
                                <?php echo esc_html($billing_address); ?>
                            </p>
                        </div>
                    </div>
                    <!-- Edit Details Button -->
                    <div class="flex w-full justify-center items-center md:justify-start md:items-start">
                        <button class="mt-6 md:mt-0 dark:border-white dark:hover:bg-gray-900 dark:bg-transparent dark:text-white py-5 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 border border-gray-800 font-medium w-96 2xl:w-full text-base font-medium leading-4 text-gray-800">
                            Edit Details
                        </button>
                    </div>
                </div>
            </div>
        </div>



    </div>


</div>
</div>