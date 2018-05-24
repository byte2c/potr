<?php
require_once 'assets/vendors/simpleimage/simpleimage.php';
require_once 'assets/vendors/paypal.php';
require_once 'assets/vendors/phpmailer/autoload.php';
require_once 'assets/vendors/email.php';
require_once 'lib/config.php';
require_once 'lib/limonade.php';


function configure(){
  option('site_uri', ROOTPATH);
  option('base_uri', ROOTPATH);
  option('title_prefix', '');
  option('title', SITE_NAME);
}

function before($route){
	global $cms;
	global $user;
	layout('default_layout.php');
    set('path', $route['path']);
    set('func', $route['callback'][1]);
	set('settings', $cms->settings);
	set('cms', $cms);
	set('user', $user);
	set('root_dir', option('root_dir'));
	set('menu', $cms->menu());

}

//Logged Pages
if($user->logged){
	dispatch('/', array($cms, 'dashboard'));
	dispatch('/dashboard', array($cms, 'dashboard'));
	dispatch('/book-now', array($cms, 'book_now'));
	dispatch('/book-now/packages/:code', array($cms, 'book_packages'));
	dispatch('/book-now/lists', array($cms, 'book_lists'));
	dispatch('/order/date-time/:code', array($cms, 'order_date_time'));
	dispatch('/order/remarks/:code', array($cms, 'order_remarks'));
	dispatch('/order/summary/:code', array($cms, 'order_summary'));
	dispatch('/order/return', array($cms, 'order_return'));
	
	dispatch('/booking-lists', array($cms, 'booking_lists'));
	dispatch('/reschedule/:code', array($cms, 'reschedule'));
	dispatch('/settings/profile', array($cms, 'setting_my_info'));
	dispatch('/settings/mypets', array($cms, 'setting_my_pets'));
	dispatch('/settings/mypets/add', array($cms, 'setting_my_pets_add'));
	dispatch('/settings/mypets/edit/:code', array($cms, 'setting_my_pets_edit'));
	dispatch('/logout', array($cms, 'logout'));
	
	dispatch_post('/profile', array($post, 'profile'));
	dispatch_post('/add_pet', array($post, 'add_pet'));
	dispatch_post('/edit_pet', array($post, 'edit_pet'));
	dispatch_post('/delete_pet', array($post, 'delete_pet'));
	dispatch_post('/delete_book_pet', array($post, 'delete_book_pet'));
	dispatch_post('/reschedule', array($post, 'reschedule'));
	
	/* BOOKING */
	dispatch_post('/select_pet', array($post, 'select_pet'));
	dispatch_post('/select_package', array($post, 'select_package'));
	dispatch_post('/create_booking', array($post, 'create_booking'));
	dispatch_post('/booking_date_time', array($post, 'booking_date_time'));
	dispatch_post('/booking_remarks', array($post, 'booking_remarks'));
	dispatch_post('/booking_payment', array($post, 'booking_payment'));
	dispatch_post('/promo_code/:code', array($post, 'promo_code'));
	
	/* AJAX */
	dispatch_post('/ajax/getBreed', array($post, 'ajax_getBreed'));
	dispatch_post('/ajax/getWeight', array($post, 'ajax_getWeight'));
	dispatch_post('/ajax/getOrderTime', array($post, 'ajax_getOrderTime'));
	dispatch_post('/ajax/viewOrder', array($post, 'ajax_viewOrder'));
	dispatch_post('/ajax/addON', array($post, 'ajax_addON'));
	
	dispatch('**', array($cms, 'not_found_login'));
	
//Logout Pages
}else{
	dispatch('/', array($cms, 'home'));
	dispatch('/signup', array($cms, 'signup'));
	dispatch('/phone-verify/:code', array($cms, 'phone_verify'));
	dispatch('/forgot', array($cms, 'forgot'));
	dispatch('/reset_password/:code', array($cms, 'reset_password'));
	
	dispatch_post('/login', array($post, 'login'));
	dispatch_post('/register', array($post, 'register'));
	dispatch_post('/resend-code', array($post, 'resend_code'));
	dispatch_post('/phone-verify', array($post, 'phone_verify'));
	dispatch_post('/forgot', array($post, 'forgot'));
	dispatch_post('/reset-password', array($post, 'reset_password'));
	
	dispatch('**', array($cms, 'not_found'));
}



function not_found($errno, $errstr, $errfile=null, $errline=null){
    set('errno', $errno);
    set('errstr', $errstr);
    set('errfile', $errfile);
    set('errline', $errline);
    return render('layout/404.php');
}
  
run();
?>
