<?php

Breadcrumbs::register('build-index', function($breadcrumbs) {
    $breadcrumbs->push('Choose Picture', route('build-index'));
});

Breadcrumbs::register('build-process', function($breadcrumbs) {
	$breadcrumbs->parent('build-index');
	$breadcrumbs->push('Crop', route('build-process'));
});

Breadcrumbs::register('build-crop', function($breadcrumbs) {
    $breadcrumbs->parent('build-process');
    $breadcrumbs->push('Edit', route('build-crop'));
});

Breadcrumbs::register('build-send', function($breadcrumbs) {
    $breadcrumbs->parent('build-crop');
    $breadcrumbs->push('Recipients', route('build-send'));
});

Breadcrumbs::register('build-preview', function($breadcrumbs) {
    $breadcrumbs->parent('build-send');
    $breadcrumbs->push('Preview', route('build-preview'));
});

Breadcrumbs::register('instagram-edit', function($breadcrumbs) {
	$breadcrumbs->parent('build-index');
	$breadcrumbs->push('Edit', route('instagram-edit'));
});

Breadcrumbs::register('instagram-send', function($breadcrumbs) {
    $breadcrumbs->parent('instagram-edit');
    $breadcrumbs->push('Recipients', route('instagram-send'));
});

Breadcrumbs::register('instagram-preview', function($breadcrumbs) {
    $breadcrumbs->parent('instagram-send');
    $breadcrumbs->push('Preview', route('instagram-preview'));
});