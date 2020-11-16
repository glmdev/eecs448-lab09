<?php

require_once '../configuration.php';

$request = CommonRequest::capture();
$products = require_system('exercise3/products.php');

if ( !$request->input() ) {
    system_redirect('exercise3/customerFrontend.html');
}

$page = new CommonPage();

$page->title('Exercise 3 - EECS 448 Lab 9')
    ->header('Order placed!')
    ->stylesheet(system_url('exercise3/style.css'))
    ->writes('<p>Hello, ' . $request->input('email') . '! (Your password was <code>' . $request->input('password') . '</code>.)');

$page->table(function() use($page, $products, $request) {
    $page->table_row(function() use($page) {
        $page->table_head(function() {})
            ->table_head(function() use($page) {
                $page->writes('Price / Item');
            })
            ->table_head(function() use($page) {
                $page->writes('Order Quantity');
            })
            ->table_head(function() use($page) {
                $page->writes('Bill Total');
            });
    });

    foreach ( $products as $product ) {
        $page->table_row(function() use($page, $product, $request) {
            $page->table_cell(function() use($page, $product) {
                $page->writes('<b>' . $product['name'] . '</b>');
            })
                ->table_cell(function() use($page, $product) {
                    $page->writes('$' . $product['price']);
                })
                ->table_cell(function() use($page, $product, $request) {
                    $page->writes($request->input('product-qty-' . $product['id']) ?: '0');
                })
                ->table_cell(function() use($page, $product, $request) {
                    $quantity = intval($request->input('product-qty-' . $product['id']) ?: '0');
                    $page->writes('$' . ($quantity * $product['price']));
                });
        });
    }

    $page->table_row(function() use($page, $request) {
        $page->table_cell(function() use($page, $request) {
            $page->writes('<b>Shipping</b> (' . ucfirst($request->input('shipping-type')) . ')');
        })
            ->table_cell(function() {})
            ->table_cell(function() {})
            ->table_cell(function() use($page, $request) {
                $type = $request->input('shipping-type');

                if ( $type === 'free' ) {
                    $page->writes('$0.00');
                } else if ( $type === 'medium' ) {
                    $page->writes('$5.00');
                } else if ( $type === 'overnight' ) {
                    $page->writes('$50.00');
                }
            });
    });

    $page->table_row(function() use($page, $request, $products) {
        $page->table_cell(function() use($page) {
            $page->writes('<b>Bill Total</b>');
        })
            ->table_cell(function() {})
            ->table_cell(function() {})
            ->table_cell(function() use($page, $request, $products) {
                $total = 0;

                foreach ( $products as $product ) {
                    $quantity = intval($request->input('product-qty-' . $product['id']));
                    $total += $quantity * $product['price'];
                }

                $type = $request->input('shipping-type');

                if ( $type === 'medium' ) {
                    $total += 5;
                } else if ( $type === 'overnight' ) {
                    $total += 50;
                }

                $page->writes('<b>$' . $total . '</b>');
            });
    });
});

$page->write();
