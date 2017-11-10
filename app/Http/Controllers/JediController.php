<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Jedi;

use App\Notifications\LightsaberUpdated;
use App\Jobs\SendMailJob;

use Mail;
use Log;

class JediController extends Controller
{
     // this pae will list all of the jedis in our database
    function index(){
        // get all the jedis
        $jedis = Jedi::all();
             
        return view('jedi.index')->with('jedis', $jedis);
    }
     
    function notifyJedi($id){
        // this is where the notification logic will be implemented
        $jedis = Jedi::all();

        foreach ($jedis as $jedi) {
            $jedi->notify(new LightsaberUpdated($jedi));
        }


        if($jedi->is_lightsaber_on){
	        return redirect()->route('home')
	            ->with('message', 'We have notified '.$jedi->name.' that their lightsaber is currently turned ON')
	            ->with('status', 'info');
	    }else{
	        return redirect()->route('home')
	            ->with('message', 'We have notified '.$jedi->name.' that their lightsaber is currently turned OFF')
	            ->with('status', 'info');
	    }
    }
     
    function getLightsaberStatus($id){
         
         // get the jedi and toggle his/her lightsaber
        $jedi = Jedi::findOrFail($id);
         
 
        if($jedi->is_lightsaber_on){
            return redirect()->route('home')
                ->with('message', 'The lighsaber for '.$jedi->name.' is currently turned ON')
                ->with('status', 'info');
        }else{
            return redirect()->route('home')
                ->with('message', 'The lighsaber for '.$jedi->name.' is currently turned OFF')
                ->with('status', 'info');
        }
 
    }
     
    function toggleLightsaberStatus($id){
         
         // get the jedi and toggle his/her lightsaber
        $jedi = Jedi::findOrFail($id);
         
        $jedi->is_lightsaber_on = !$jedi->is_lightsaber_on;
        $jedi->save();
         
        if($jedi->is_lightsaber_on){
            return redirect()->route('home')
                ->with('message', 'The lighsaber for '.$jedi->name.' is now turned ON')
                ->with('status', 'success');
        }else{
            return redirect()->route('home')
                ->with('message', 'The lighsaber for '.$jedi->name.' is now turned OFF')
                ->with('status', 'danger');
        }
 
    }

    function send(){

    	$job = new SendMailJob();

        $teste = $this->dispatch($job);
    }
}
