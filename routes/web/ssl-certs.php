<?php


# SSL-Certss
Route::group([ 'prefix' => 'ssl-certs', 'middleware' => ['auth'] ], function () {

    Route::get('{ssl-certId}/clone', [ 'as' => 'clone/ssl-cert', 'uses' => 'SSL-CertssController@getClone' ]);
    Route::post('{ssl-certId}/clone', [ 'as' => 'clone/ssl-cert', 'uses' => 'SSL-CertssController@postCreate' ]);

    Route::get('{ssl-certId}/freecheckout', [
    'as' => 'ssl-certs.freecheckout',
    'uses' => 'SSL-CertssController@getFreeSSL-Certs'
    ]);
    Route::get('{ssl-certId}/checkout/{seatId?}', [
    'as' => 'ssl-certs.checkout',
    'uses' => 'SSL-CertssController@getCheckout'
    ]);
    Route::post(
        '{ssl-certId}/checkout/{seatId?}',
        [ 'as' => 'ssl-certs.checkout', 'uses' => 'SSL-CertssController@postCheckout' ]
    );
    Route::get('{ssl-certId}/checkin/{backto?}', [
    'as' => 'ssl-certs.checkin',
    'uses' => 'SSL-CertssController@getCheckin'
    ]);

    Route::post('{ssl-certId}/checkin/{backto?}', [
    'as' => 'ssl-certs.checkin.save',
    'uses' => 'SSL-CertssController@postCheckin'
    ]);

    Route::post(
    '{ssl-certId}/upload',
    [ 'as' => 'upload/ssl-cert', 'uses' => 'SSL-CertssController@postUpload' ]
    );
    Route::delete(
    '{ssl-certId}/deletefile/{fileId}',
    [ 'as' => 'delete/ssl-certfile', 'uses' => 'SSL-CertssController@getDeleteFile' ]
    );
    Route::get(
    '{ssl-certId}/showfile/{fileId}/{download?}',
    [ 'as' => 'show.ssl-certfile', 'uses' => 'SSL-CertssController@displayFile' ]
    );
});

Route::resource('ssl-certs', 'SSL-CertssController', [
    'middleware' => ['auth'],
    'parameters' => ['ssl-cert' => 'ssl-cert_id']
]);
