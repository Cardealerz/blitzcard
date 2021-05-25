<?php

// Home
Breadcrumbs::for('home.index', function ($trail) {
    $trail->push(__('labels.home'), route('home.index'));
});

// CODE TEMPLATE

// Home > CodeTemplate List
Breadcrumbs::for('codeTemplate.list', function ($trail) {
    $trail->parent('home.index');
    $trail->push(__('labels.code_templates'), route('codeTemplate.list'));
});

// Home > CodeTemplate Details
Breadcrumbs::for('codeTemplate.details', function ($trail, $code) {
    $trail->parent('codeTemplate.list');
    $trail->push($code->toString(), route('codeTemplate.details', $code->id));
});

// Home > CodeTemplate Create
Breadcrumbs::for('codeTemplate.addCode', function ($trail) {
    $trail->parent('codeTemplate.list');
    $trail->push(__('labels.add_code_template'), route('codeTemplate.addCode'));
});

// Orders

// Home > Orders
Breadcrumbs::for('orders.list', function ($trail) {
    $trail->parent('home.index');
    $trail->push(__('labels.all_orders'), route('orders.list'));
});

// Home > Orders > Details
Breadcrumbs::for('orders.details', function ($trail, $payHistory) {
    $trail->parent('orders.list');
    $trail->push($payHistory->getUuId(), route('orders.list', $payHistory));
});

// Payments

// Home > Payments
Breadcrumbs::for('payments.list', function ($trail) {
    $trail->parent('home.index');
    $trail->push(__('labels.pay_history'), route('payhistory.showAll'));
});

// Home > Payments > Details
Breadcrumbs::for('payments.details', function ($trail, $payHistory) {
    $trail->parent('payments.list');
    $trail->push($payHistory->getUuId(), route('payhistory.showOne', $payHistory));
});

// Cart

// Home > Cart
Breadcrumbs::for('cart.index', function ($trail) {
    $trail->parent('home.index');
    $trail->push(__('labels.cart'), route('cart.index'));
});

// Home > Cart > Buy
Breadcrumbs::for('cart.buy', function ($trail) {
    $trail->parent('cart.index');
    $trail->push(__('labels.buy'), route('cart.buy'));
});

// Code

// Home > Codes
Breadcrumbs::for('code.list', function ($trail) {
    $trail->parent('home.index');
    $trail->push(__('labels.codes'), route('code.list'));
});

// Home > Code > details
Breadcrumbs::for('code.details', function ($trail, $code) {
    $trail->parent('code.list');
    $trail->push($code->toString(), route('code.details', $code));
});

// Discounts

// Home > Discounts
Breadcrumbs::for('responses.discounts', function ($trail) {
    $trail->parent('home.index');
    $trail->push(__('messages.special_product_discounts'), route('responses.discounts'));
});

// Anime

// Home > Anime
Breadcrumbs::for('responses.animes', function ($trail) {
    $trail->parent('home.index');
    $trail->push(__('messages.animes_list'), route('responses.animes'));
});
