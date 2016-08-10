<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );

function zipfiles($filename, $rootPath){

// Initialize archive object
$zip = new ZipArchive();
$zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}

// Zip archive will be created only after closing object
$zip->close();
}

function recurse_copy( $src, $dst, $is_dir ) {
    if ( $is_dir ) {
        // copy directory
        if ( is_dir( $src ) ) {
            if ( $src != '.svn' ) {
                $dir = opendir( $src );
                @mkdir( $dst );
                while ( false !== ( $file = readdir( $dir )) ) {
                    if ( ( $file != '.' ) && ( $file != '..' ) ) {
                        if ( is_dir( $src . '/' . $file ) ) {
                            recurse_copy( $src . '/' . $file, $dst . '/' . $file, true );
                        } else {
                            if ( strpos( $file, '.DS_Store' ) === false ) {
                                copy( $src . '/' . $file, $dst . '/' . $file );
                            }
                        }
                    }
                }
                closedir( $dir );
            }
        } else {
            echo 'dir ' . $src . ' is not found!';
        }
    } else {
        if ( strpos( $src, '.DS_Store' ) === false ) {
            // copy file
            copy( $src, $dst );
        }
    }
}
  
// make file and directory array
function data_element( $src, $dst, $is_dir = false ) {
    $data = array();
    $data['src'] = $src;
    $data['dst'] = $dst;
    $data['isdir'] = $is_dir;
    return $data;
}

// make data

$data = array();


$src = '../admin/controller/payment/cardgate/cardgate.php';
$dst = 'cardgate/admin/controller/payment/cardgate/cardgate.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../admin/controller/payment/cardgateafterpay.php';
$dst = 'cardgate/admin/controller/payment/cardgateafterpay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/controller/payment/cardgateamex.php';
$dst = 'cardgate/admin/controller/payment/cardgateamex.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/controller/payment/cardgatebanktransfer.php';
$dst = 'cardgate/admin/controller/payment/cardgatebanktransfer.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/controller/payment/cardgatebitcoin.php';
$dst = 'cardgate/admin/controller/payment/cardgatebitcoin.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/controller/payment/cardgatedirectdebit.php';
$dst = 'cardgate/admin/controller/payment/cardgatedirectdebit.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/controller/payment/cardgategiropay.php';
$dst = 'cardgate/admin/controller/payment/cardgategiropay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/controller/payment/cardgateideal.php';
$dst = 'cardgate/admin/controller/payment/cardgateideal.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/controller/payment/cardgateklarna.php';
$dst = 'cardgate/admin/controller/payment/cardgateklarna.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/controller/payment/cardgatemaestro.php';
$dst = 'cardgate/admin/controller/payment/cardgatemaestro.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/controller/payment/cardgatemastercard.php';
$dst = 'cardgate/admin/controller/payment/cardgatemastercard.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/controller/payment/cardgatemistercash.php';
$dst = 'cardgate/admin/controller/payment/cardgatemistercash.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/controller/payment/cardgatepaypal.php';
$dst = 'cardgate/admin/controller/payment/cardgatepaypal.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/controller/payment/cardgateprzelewy24.php';
$dst = 'cardgate/admin/controller/payment/cardgateprzelewy24.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/controller/payment/cardgatesofortbanking.php';
$dst = 'cardgate/admin/controller/payment/cardgatesofortbanking.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/controller/payment/cardgatevisa.php';
$dst = 'cardgate/admin/controller/payment/cardgatevisa.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/controller/payment/cardgatevpay.php';
$dst = 'cardgate/admin/controller/payment/cardgatevpay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/controller/payment/cardgatewebmoney.php';
$dst = 'cardgate/admin/controller/payment/cardgatewebmoney.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../admin/language/dutch/payment/cardgateafterpay.php';
$dst = 'cardgate/admin/language/dutch/payment/cardgateafterpay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/dutch/payment/cardgateamex.php';
$dst = 'cardgate/admin/language/dutch/payment/cardgateamex.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/dutch/payment/cardgatebanktransfer.php';
$dst = 'cardgate/admin/language/dutch/payment/cardgatebanktransfer.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/dutch/payment/cardgatebitcoin.php';
$dst = 'cardgate/admin/language/dutch/payment/cardgatebitcoin.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/dutch/payment/cardgatedirectdebit.php';
$dst = 'cardgate/admin/language/dutch/payment/cardgatedirectdebit.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/dutch/payment/cardgategiropay.php';
$dst = 'cardgate/admin/language/dutch/payment/cardgategiropay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/dutch/payment/cardgateideal.php';
$dst = 'cardgate/admin/language/dutch/payment/cardgateideal.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/dutch/payment/cardgateklarna.php';
$dst = 'cardgate/admin/language/dutch/payment/cardgateklarna.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/dutch/payment/cardgatemaestro.php';
$dst = 'cardgate/admin/language/dutch/payment/cardgatemaestro.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/dutch/payment/cardgatemastercard.php';
$dst = 'cardgate/admin/language/dutch/payment/cardgatemastercard.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/dutch/payment/cardgatemistercash.php';
$dst = 'cardgate/admin/language/dutch/payment/cardgatemistercash.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/dutch/payment/cardgatepaypal.php';
$dst = 'cardgate/admin/language/dutch/payment/cardgatepaypal.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/dutch/payment/cardgateprzelewy24.php';
$dst = 'cardgate/admin/language/dutch/payment/cardgateprzelewy24.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/dutch/payment/cardgatesofortbanking.php';
$dst = 'cardgate/admin/language/dutch/payment/cardgatesofortbanking.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/dutch/payment/cardgatevisa.php';
$dst = 'cardgate/admin/language/dutch/payment/cardgatevisa.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/dutch/payment/cardgatevpay.php';
$dst = 'cardgate/admin/language/dutch/payment/cardgatevpay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/dutch/payment/cardgatewebmoney.php';
$dst = 'cardgate/admin/language/dutch/payment/cardgatewebmoney.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );


$src = '../admin/language/english/payment/cardgateafterpay.php';
$dst = 'cardgate/admin/language/english/payment/cardgateafterpay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/english/payment/cardgateamex.php';
$dst = 'cardgate/admin/language/english/payment/cardgateamex.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/english/payment/cardgatebanktransfer.php';
$dst = 'cardgate/admin/language/english/payment/cardgatebanktransfer.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/english/payment/cardgatebitcoin.php';
$dst = 'cardgate/admin/language/english/payment/cardgatebitcoin.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/english/payment/cardgatedirectdebit.php';
$dst = 'cardgate/admin/language/english/payment/cardgatedirectdebit.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/english/payment/cardgategiropay.php';
$dst = 'cardgate/admin/language/english/payment/cardgategiropay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/english/payment/cardgateideal.php';
$dst = 'cardgate/admin/language/english/payment/cardgateideal.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/english/payment/cardgateklarna.php';
$dst = 'cardgate/admin/language/english/payment/cardgateklarna.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/english/payment/cardgatemaestro.php';
$dst = 'cardgate/admin/language/english/payment/cardgatemaestro.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/english/payment/cardgatemastercard.php';
$dst = 'cardgate/admin/language/english/payment/cardgatemastercard.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/english/payment/cardgatemistercash.php';
$dst = 'cardgate/admin/language/english/payment/cardgatemistercash.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/english/payment/cardgatepaypal.php';
$dst = 'cardgate/admin/language/english/payment/cardgatepaypal.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/english/payment/cardgateprzelewy24.php';
$dst = 'cardgate/admin/language/english/payment/cardgateprzelewy24.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/english/payment/cardgatesofortbanking.php';
$dst = 'cardgate/admin/language/english/payment/cardgatesofortbanking.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/english/payment/cardgatevisa.php';
$dst = 'cardgate/admin/language/english/payment/cardgatevisa.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/english/payment/cardgatevpay.php';
$dst = 'cardgate/admin/language/english/payment/cardgatevpay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/language/english/payment/cardgatewebmoney.php';
$dst = 'cardgate/admin/language/english/payment/cardgatewebmoney.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../admin/view/image/payment/cardgateplus.png';
$dst = 'cardgate/admin/view/image/payment/cardgateplus.png';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../admin/view/template/payment/cardgateafterpay.tpl';
$dst = 'cardgate/admin/view/template/payment/cardgateafterpay.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/view/template/payment/cardgateamex.tpl';
$dst = 'cardgate/admin/view/template/payment/cardgateamex.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/view/template/payment/cardgatebanktransfer.tpl';
$dst = 'cardgate/admin/view/template/payment/cardgatebanktransfer.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/view/template/payment/cardgatebitcoin.tpl';
$dst = 'cardgate/admin/view/template/payment/cardgatebitcoin.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/view/template/payment/cardgatedirectdebit.tpl';
$dst = 'cardgate/admin/view/template/payment/cardgatedirectdebit.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/view/template/payment/cardgategiropay.tpl';
$dst = 'cardgate/admin/view/template/payment/cardgategiropay.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/view/template/payment/cardgateideal.tpl';
$dst = 'cardgate/admin/view/template/payment/cardgateideal.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/view/template/payment/cardgateklarna.tpl';
$dst = 'cardgate/admin/view/template/payment/cardgateklarna.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/view/template/payment/cardgatemaestro.tpl';
$dst = 'cardgate/admin/view/template/payment/cardgatemaestro.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/view/template/payment/cardgatemastercard.tpl';
$dst = 'cardgate/admin/view/template/payment/cardgatemastercard.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/view/template/payment/cardgatemistercash.tpl';
$dst = 'cardgate/admin/view/template/payment/cardgatemistercash.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/view/template/payment/cardgatepaypal.tpl';
$dst = 'cardgate/admin/view/template/payment/cardgatepaypal.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/view/template/payment/cardgateprzelewy24.tpl';
$dst = 'cardgate/admin/view/template/payment/cardgateprzelewy24.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/view/template/payment/cardgatesofortbanking.tpl';
$dst = 'cardgate/admin/view/template/payment/cardgatesofortbanking.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/view/template/payment/cardgatevisa.tpl';
$dst = 'cardgate/admin/view/template/payment/cardgatevisa.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/view/template/payment/cardgatevpay.tpl';
$dst = 'cardgate/admin/view/template/payment/cardgatevpay.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../admin/view/template/payment/cardgatewebmoney.tpl';
$dst = 'cardgate/admin/view/template/payment/cardgatewebmoney.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../catalog/controller/payment/cardgate.php';
$dst = 'cardgate/catalog/controller/payment/cardgate.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/controller/payment/cardgateafterpay.php';
$dst = 'cardgate/catalog/controller/payment/cardgateafterpay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/controller/payment/cardgateamex.php';
$dst = 'cardgate/catalog/controller/payment/cardgateamex.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/controller/payment/cardgatebanktransfer.php';
$dst = 'cardgate/catalog/controller/payment/cardgatebanktransfer.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/controller/payment/cardgatebitcoin.php';
$dst = 'cardgate/catalog/controller/payment/cardgatebitcoin.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/controller/payment/cardgatedirectdebit.php';
$dst = 'cardgate/catalog/controller/payment/cardgatedirectdebit.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/controller/payment/cardgategeneric.php';
$dst = 'cardgate/catalog/controller/payment/cardgategeneric.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/controller/payment/cardgategiropay.php';
$dst = 'cardgate/catalog/controller/payment/cardgategiropay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/controller/payment/cardgateideal.php';
$dst = 'cardgate/catalog/controller/payment/cardgateideal.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/controller/payment/cardgateklarna.php';
$dst = 'cardgate/catalog/controller/payment/cardgateklarna.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/controller/payment/cardgatemaestro.php';
$dst = 'cardgate/catalog/controller/payment/cardgatemaestro.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/controller/payment/cardgatemastercard.php';
$dst = 'cardgate/catalog/controller/payment/cardgatemastercard.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/controller/payment/cardgatemistercash.php';
$dst = 'cardgate/catalog/controller/payment/cardgatemistercash.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/controller/payment/cardgatepaypal.php';
$dst = 'cardgate/catalog/controller/payment/cardgatepaypal.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/controller/payment/cardgateprzelewy24.php';
$dst = 'cardgate/catalog/controller/payment/cardgateprzelewy24.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/controller/payment/cardgatesofortbanking.php';
$dst = 'cardgate/catalog/controller/payment/cardgatesofortbanking.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/controller/payment/cardgatevisa.php';
$dst = 'cardgate/catalog/controller/payment/cardgatevisa.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/controller/payment/cardgatevpay.php';
$dst = 'cardgate/catalog/controller/payment/cardgatevpay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/controller/payment/cardgatewebmoney.php';
$dst = 'cardgate/catalog/controller/payment/cardgatewebmoney.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../catalog/language/dutch/payment/cardgateafterpay.php';
$dst = 'cardgate/catalog/language/dutch/payment/cardgateafterpay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/dutch/payment/cardgateamex.php';
$dst = 'cardgate/catalog/language/dutch/payment/cardgateamex.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/dutch/payment/cardgatebanktransfer.php';
$dst = 'cardgate/catalog/language/dutch/payment/cardgatebanktransfer.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/dutch/payment/cardgatebitcoin.php';
$dst = 'cardgate/catalog/language/dutch/payment/cardgatebitcoin.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/dutch/payment/cardgatedirectdebit.php';
$dst = 'cardgate/catalog/language/dutch/payment/cardgatedirectdebit.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/dutch/payment/cardgategiropay.php';
$dst = 'cardgate/catalog/language/dutch/payment/cardgategiropay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/dutch/payment/cardgateideal.php';
$dst = 'cardgate/catalog/language/dutch/payment/cardgateideal.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/dutch/payment/cardgateklarna.php';
$dst = 'cardgate/catalog/language/dutch/payment/cardgateklarna.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/dutch/payment/cardgatemaestro.php';
$dst = 'cardgate/catalog/language/dutch/payment/cardgatemaestro.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/dutch/payment/cardgatemastercard.php';
$dst = 'cardgate/catalog/language/dutch/payment/cardgatemastercard.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/dutch/payment/cardgatemistercash.php';
$dst = 'cardgate/catalog/language/dutch/payment/cardgatemistercash.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/dutch/payment/cardgatepaypal.php';
$dst = 'cardgate/catalog/language/dutch/payment/cardgatepaypal.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/dutch/payment/cardgateprzelewy24.php';
$dst = 'cardgate/catalog/language/dutch/payment/cardgateprzelewy24.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/dutch/payment/cardgatesofortbanking.php';
$dst = 'cardgate/catalog/language/dutch/payment/cardgatesofortbanking.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/dutch/payment/cardgatevisa.php';
$dst = 'cardgate/catalog/language/dutch/payment/cardgatevisa.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/dutch/payment/cardgatevpay.php';
$dst = 'cardgate/catalog/language/dutch/payment/cardgatevpay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/dutch/payment/cardgatewebmoney.php';
$dst = 'cardgate/catalog/language/dutch/payment/cardgatewebmoney.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../catalog/language/english/payment/cardgateafterpay.php';
$dst = 'cardgate/catalog/language/english/payment/cardgateafterpay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/english/payment/cardgateamex.php';
$dst = 'cardgate/catalog/language/english/payment/cardgateamex.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/english/payment/cardgatebanktransfer.php';
$dst = 'cardgate/catalog/language/english/payment/cardgatebanktransfer.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/english/payment/cardgatebitcoin.php';
$dst = 'cardgate/catalog/language/english/payment/cardgatebitcoin.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/english/payment/cardgatedirectdebit.php';
$dst = 'cardgate/catalog/language/english/payment/cardgatedirectdebit.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/english/payment/cardgategiropay.php';
$dst = 'cardgate/catalog/language/english/payment/cardgategiropay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/english/payment/cardgateideal.php';
$dst = 'cardgate/catalog/language/english/payment/cardgateideal.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/english/payment/cardgateklarna.php';
$dst = 'cardgate/catalog/language/english/payment/cardgateklarna.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/english/payment/cardgatemaestro.php';
$dst = 'cardgate/catalog/language/english/payment/cardgatemaestro.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/english/payment/cardgatemastercard.php';
$dst = 'cardgate/catalog/language/english/payment/cardgatemastercard.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/english/payment/cardgatemistercash.php';
$dst = 'cardgate/catalog/language/english/payment/cardgatemistercash.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/english/payment/cardgatepaypal.php';
$dst = 'cardgate/catalog/language/english/payment/cardgatepaypal.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/english/payment/cardgateprzelewy24.php';
$dst = 'cardgate/catalog/language/english/payment/cardgateprzelewy24.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/english/payment/cardgatesofortbanking.php';
$dst = 'cardgate/catalog/language/english/payment/cardgatesofortbanking.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/english/payment/cardgatevisa.php';
$dst = 'cardgate/catalog/language/english/payment/cardgatevisa.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/english/payment/cardgatevpay.php';
$dst = 'cardgate/catalog/language/english/payment/cardgatevpay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/language/english/payment/cardgatewebmoney.php';
$dst = 'cardgate/catalog/language/english/payment/cardgatewebmoney.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../catalog/model/payment/cardgateafterpay.php';
$dst = 'cardgate/catalog/model/payment/cardgateafterpay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/model/payment/cardgateamex.php';
$dst = 'cardgate/catalog/model/payment/cardgateamex.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/model/payment/cardgatebanktransfer.php';
$dst = 'cardgate/catalog/model/payment/cardgatebanktransfer.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/model/payment/cardgatebitcoin.php';
$dst = 'cardgate/catalog/model/payment/cardgatebitcoin.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/model/payment/cardgatedirectdebit.php';
$dst = 'cardgate/catalog/model/payment/cardgatedirectdebit.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/model/payment/cardgategiropay.php';
$dst = 'cardgate/catalog/model/payment/cardgategiropay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/model/payment/cardgateideal.php';
$dst = 'cardgate/catalog/model/payment/cardgateideal.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/model/payment/cardgateklarna.php';
$dst = 'cardgate/catalog/model/payment/cardgateklarna.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/model/payment/cardgatemaestro.php';
$dst = 'cardgate/catalog/model/payment/cardgatemaestro.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/model/payment/cardgatemastercard.php';
$dst = 'cardgate/catalog/model/payment/cardgatemastercard.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/model/payment/cardgatemistercash.php';
$dst = 'cardgate/catalog/model/payment/cardgatemistercash.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/model/payment/cardgatepaypal.php';
$dst = 'cardgate/catalog/model/payment/cardgatepaypal.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/model/payment/cardgateprzelewy24.php';
$dst = 'cardgate/catalog/model/payment/cardgateprzelewy24.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/model/payment/cardgatesofortbanking.php';
$dst = 'cardgate/catalog/model/payment/cardgatesofortbanking.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/model/payment/cardgatevisa.php';
$dst = 'cardgate/catalog/model/payment/cardgatevisa.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/model/payment/cardgatevpay.php';
$dst = 'cardgate/catalog/model/payment/cardgatevpay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/model/payment/cardgatewebmoney.php';
$dst = 'cardgate/catalog/model/payment/cardgatewebmoney.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../catalog/view/theme/default/template/payment/cardgateafterpay.tpl';
$dst = 'cardgate/catalog/view/theme/default/template/payment/cardgateafterpay.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/view/theme/default/template/payment/cardgateamex.tpl';
$dst = 'cardgate/catalog/view/theme/default/template/payment/cardgateamex.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/view/theme/default/template/payment/cardgatebanktransfer.tpl';
$dst = 'cardgate/catalog/view/theme/default/template/payment/cardgatebanktransfer.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/view/theme/default/template/payment/cardgatebitcoin.tpl';
$dst = 'cardgate/catalog/view/theme/default/template/payment/cardgatebitcoin.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/view/theme/default/template/payment/cardgatedirectdebit.tpl';
$dst = 'cardgate/catalog/view/theme/default/template/payment/cardgatedirectdebit.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/view/theme/default/template/payment/cardgategiropay.tpl';
$dst = 'cardgate/catalog/view/theme/default/template/payment/cardgategiropay.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/view/theme/default/template/payment/cardgateideal.tpl';
$dst = 'cardgate/catalog/view/theme/default/template/payment/cardgateideal.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/view/theme/default/template/payment/cardgateklarna.tpl';
$dst = 'cardgate/catalog/view/theme/default/template/payment/cardgateklarna.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/view/theme/default/template/payment/cardgatemaestro.tpl';
$dst = 'cardgate/catalog/view/theme/default/template/payment/cardgatemaestro.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/view/theme/default/template/payment/cardgatemastercard.tpl';
$dst = 'cardgate/catalog/view/theme/default/template/payment/cardgatemastercard.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/view/theme/default/template/payment/cardgatemistercash.tpl';
$dst = 'cardgate/catalog/view/theme/default/template/payment/cardgatemistercash.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/view/theme/default/template/payment/cardgatepaypal.tpl';
$dst = 'cardgate/catalog/view/theme/default/template/payment/cardgatepaypal.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/view/theme/default/template/payment/cardgateprzelewy24.tpl';
$dst = 'cardgate/catalog/view/theme/default/template/payment/cardgateprzelewy24.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/view/theme/default/template/payment/cardgatesofortbanking.tpl';
$dst = 'cardgate/catalog/view/theme/default/template/payment/cardgatesofortbanking.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/view/theme/default/template/payment/cardgatevisa.tpl';
$dst = 'cardgate/catalog/view/theme/default/template/payment/cardgatevisa.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/view/theme/default/template/payment/cardgatevpay.tpl';
$dst = 'cardgate/catalog/view/theme/default/template/payment/cardgatevpay.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../catalog/view/theme/default/template/payment/cardgatewebmoney.tpl';
$dst = 'cardgate/catalog/view/theme/default/template/payment/cardgatewebmoney.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../image/cgp/';
$dst = 'cardgate/image/cgp/';
$is_dir = true;
array_push( $data, data_element( $src, $dst, $is_dir ) );

// copy files

foreach ( $data as $k => $v ) {
        recurse_copy( $v['src'], $v['dst'], $v['isdir'] );
}

// make the zip
echo 'files copied<br>';

// Get real path for our folder
$rootPath = '/home/richard/websites/opencart2000/htdocs/_plugin/cardgate';
$filename = 'cardgate.zip';

zipfiles($filename, $rootPath);
echo 'zipfile made<br>';
echo 'done!';
?>