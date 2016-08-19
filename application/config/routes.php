<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/*

| -------------------------------------------------------------------------

| URI ROUTING

| -------------------------------------------------------------------------

| This file lets you re-map URI requests to specific controller functions.

|

| Typically there is a one-to-one relationship between a URL string

| and its corresponding controller class/method. The segments in a

| URL normally follow this pattern:

|

|	example.com/class/method/id/

|

| In some instances, however, you may want to remap this relationship

| so that a different class/function is called than the one

| corresponding to the URL.

|

| Please see the user guide for complete details:

|

|	https://codeigniter.com/user_guide/general/routing.html

|

| -------------------------------------------------------------------------

| RESERVED ROUTES

| -------------------------------------------------------------------------

|

| There are three reserved routes:

|

|	$route['default_controller'] = 'welcome';

|

| This route indicates which controller class should be loaded if the

| URI contains no data. In the above example, the "welcome" class

| would be loaded.

|

|	$route['404_override'] = 'errors/page_missing';

|

| This route will tell the Router which controller/method to use if those

| provided in the URL cannot be matched to a valid route.

|

|	$route['translate_uri_dashes'] = FALSE;

|

| This is not exactly a route, but allows you to automatically route

| controller and method names that contain dashes. '-' isn't a valid

| class or method name character, so it requires translation.

| When you set this option to TRUE, it will replace ALL dashes in the

| controller and method URI segments.

|

| Examples:	my-controller/index	-> my_controller/index

|		my-controller/my-method	-> my_controller/my_method

*/

//$route['default_controller'] = 'welcome';

//$route['404_override'] = '';

//$route['translate_uri_dashes'] = FALSE;





$route['default_controller'] = "show";

$route['404_override'] 		 = "show/show404";





$route['/admin/users'] = "admin/users";

$route['users'] = "show/members";





$route['list-business'] 		= "user/new_ad";

// 

$route['account/list-business'] = "account/new_ad";

$route['choose-package'] = "user/payment/choosepackage";

$route['create-ad'] 		= "user/create_ad";



$route['create-business'] 		= "account/create_ad";



//$route['edit-business/(:any)/(:any)'] = "user/editpost/$1/$2";
$route['edit-business/(:any)/(:any)'] = "admin/business/editpost/$1/$2";
$route['update-ad'] 		= "admin/business/updatepost";
//$route['update-ad'] 		= "user/updatepost";



$route['admin/business/locations']  = "admin/business/locations";

$route['locations'] 		= "show/location";

$route['location-posts/(.*)'] = "show/location_posts/$1/$2";

$route['profile/blog/(:any)'] = "show/user_blog_detail/$1";

$route['profile/(.*)'] = "show/memberposts/$1/$2";





$route['blog'] = "show/post";

$route['blog/(.*)'] = "show/post/$1";


$route['blog-detail/(.*)'] = "show/postdetail/$1/$2";





$route['admin/page/(:any)'] = "admin/page/$1";

$route['page/(:any)'] = "show/page/$1";

$route['about-me'] = "show/about_me";
$route['contact'] = "show/contact";




$route['contact'] = "show/contact";

$route['sendcontactemail'] = "show/sendcontactemail";



$route['advancesearch'] = "show/search";

$route['results'] = "show/result";

$route['results/(:any)'] = "show/result/$1";





$route['tags/(:any)'] = "show/tag/$1";



$route['ads/(.*)'] = "show/detail/$1";
//
$route['business/blog/(.*)'] = "show/business_blog_detail/$1";



$route['embed/(:any)'] = "show/embed/$1";







$route['meme/(:any)'] = "show/detail";



$route['video/(:any)'] = "tv/v";

/* End of file routes.php */

