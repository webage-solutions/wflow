<?php

Route::get('/colors', 'UiController@colors')->middleware('organizationRequired');
