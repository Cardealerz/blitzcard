<?php

// Home
Breadcrumbs::for('home.index', function ($trail) {
    $trail->push('Home', route('home.index'));
});

// CODE TEMPLATE

// Home > CodeTemplate List
Breadcrumbs::for('codeTemplate.list', function ($trail) {
    $trail->parent('home.index');
    $trail->push('CodeTemplates', route('codeTemplate.list'));
});

// Home > CodeTemplate Details
Breadcrumbs::for('codeTemplate.details', function ($trail, $code) {
    $trail->parent('home.index');
    $trail->push('CodeTemplate details', route('codeTemplate.details', $code->id));
});

// Home > CodeTemplate Create
Breadcrumbs::for('codeTemplate.addCode', function ($trail) {
    $trail->parent('home.index');
    $trail->push('CodeTemplate Add Code', route('codeTemplate.addCode'));
});

// Orders

// Home > Orders List
Breadcrumbs::for('orders.list', function ($trail) {
    $trail->parent('home.index');
    $trail->push('Orders List', route('orders.list'));
});



// Cart

// Home > Cart
Breadcrumbs::for('cart.index', function ($trail) {
    $trail->parent('home.index');
    $trail->push('Cart', route('cart.index'));
});

// Home > Cart > Buy
Breadcrumbs::for('cart.buy', function ($trail) {
    $trail->parent('cart.index');
    $trail->push('Buy', route('cart.buy'));
});


// Code

// Home > Codes
Breadcrumbs::for('code.list', function ($trail) {
    $trail->parent('home.index');
    $trail->push('Codes', route('code.list'));
});


// Home > Code details
Breadcrumbs::for('code.details', function ($trail, $code) {
    $trail->parent('home.index');
    $trail->push('Code Details', route('code.details', $code));
});
