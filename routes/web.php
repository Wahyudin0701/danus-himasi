<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('dashboard', \App\Livewire\Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('projects', \App\Livewire\Project\Index::class)
    ->middleware(['auth'])
    ->name('projects.index');

Route::get('projects/create', \App\Livewire\Project\Create::class)
    ->middleware(['auth'])
    ->name('projects.create');

Route::get('projects/{project}', \App\Livewire\Project\Show::class)
    ->middleware(['auth'])
    ->name('projects.show');

Route::get('projects/{project}/edit', \App\Livewire\Project\Edit::class)
    ->middleware(['auth'])
    ->name('projects.edit');

Route::get('members', \App\Livewire\Member\Index::class)
    ->middleware(['auth'])
    ->name('members.index');

Route::get('members/create', \App\Livewire\Member\Create::class)
    ->middleware(['auth'])
    ->name('members.create');

Route::get('members/{member}/edit', \App\Livewire\Member\Edit::class)
    ->middleware(['auth'])
    ->name('members.edit');

Route::get('bidang', \App\Livewire\Bidang\Index::class)
    ->middleware(['auth'])
    ->name('bidang.index');

Route::get('projects/{project}/rab/create', \App\Livewire\Rab\Create::class)->middleware(['auth'])->name('rab.create');
Route::get('projects/{project}/rab/edit', \App\Livewire\Rab\Edit::class)->middleware(['auth'])->name('rab.edit');
Route::get('projects/{project}/finance/{type}', \App\Livewire\Project\Finance::class)->middleware(['auth'])->name('projects.finance');

Route::get('kas', \App\Livewire\Kas\Index::class)->middleware(['auth'])->name('kas.index');
Route::get('dokumen', \App\Livewire\Dokumen\Index::class)->middleware(['auth'])->name('dokumen.index');
Route::get('system-logs', \App\Livewire\SystemLog\Index::class)->middleware(['auth'])->name('system.logs');

require __DIR__.'/auth.php';
