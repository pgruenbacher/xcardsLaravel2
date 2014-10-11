<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';
/*
 *Cron Jobs
 * 
 */

Event::listen('cron.collectJobs', function() {
    Cron::add('deleteOldUsers', '0 0 * * *', function() {
		Log::info('cron1',array('interval',Cron::getRunInterval()));
	    // Delete guest users at midnight everyday
		$currentTime=time();
		$oldTime=date('Y-m-d H:i:s',$currentTime-60*60*24*2);
		$users=User::where('updated_at','<',$oldTime)->where('guest','=',1)->get();
		$users->each(function($user){
			DB::beginTransaction();
				try{
					$user->delete();
					DB::commit();
				}
				catch(\Exception $e){
					DB::rollback();
					echo 'exception';
					return $e;
				}		
		});
    });
	Cron::add('deleteOldManager','0 4 * * *',function(){
		Log::info('deleteOldManager',array('interval',Cron::getRunInterval()));
		try{
			$currentTime=time();
			$oldTime=date('Y-m-d H:i:s',$currentTime-60*60*24*2);
			$oldManager=DB::table('cron_manager')->where('rundate','<',$oldTime)->delete();
		}catch(Exception $e){
		}
		return null;
	});
    Cron::add('confirmCreditTransfers', '0 1 * * *', function() {
        // Do some crazy things at 0100 everyday
        Log::info('cron2',array('interval',Cron::getRunInterval()));
        try{
        	$currentTime=time();
			$oldTime=date('Y-m-d H:i:s',$currentTime-60*60*24*2);
        	$oldTransfers=Transfers::where('confirmed','=',0)->where('created_at','<',$oldTime)->get();
			foreach($oldTransfers as $oldTransfer){
				$oldTransfer->revert();
			}
        }catch(Exception $e){
        	
        }
        return null;
    });

});
