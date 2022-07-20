<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['guest','runpro','find']) ;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $todos = Todo::all(); 
        $user_id = auth()->user()->id;
        return view('home')->with(['todos'=> $todos,'user_id'=> $user_id]);
    }   

    public function edit($id)
    {
        $row = Todo::find($id);
        $code = $row->code;
        $response = " ";
        $input =" ";
        return view('edit')->with(['id'=>$id, 'code'=> $code,'input' => $input, 'response'=> $response, 
        'value'=> "",'line'=>"", 'val'=>"" ]);
        
    } 

    public function upload(Request $request)
    {
        $todo = $request->title;
        $user_id = auth()->user()->id;
        DB::insert('insert into todos (user_id, title) values (?, ?)', [$user_id, $todo]);
        return redirect()->route('home');
    }

    public function delete($id)
    {
        Todo::find($id)->delete();
        return redirect()->route('home');
    } 

    public function save(Request $request)
    {
        $code = $request->code;
        $id= $request->id;
        DB::table('todos')->where("id", '=', $id)->update(['code'=> $code ]);
        $row = Todo::find($id);
        return "hai";
        return view('edit')->with(['id'=>$id, 'code'=> $request->code,'input' =>  $request->input, 
        'response'=>  $request->response, 'value'=>$request->value,'line'=>$request->line, 'val'=>$request->val ]);
    } 

    public function find(Request $request)
    {
            $mystring =  $request->code;
            $findme   = "\n";
            $i=0;
            $pos=0;
            
            while ($i < $request->line)
            {
                $pos = strpos($mystring, $findme,$pos+1);
                $i=$i+1;
            }
            $result = substr($mystring, 0, $pos);
            $result.=' while(1){std::cout<<"thevalis"<<';
            $result.=$request->val;
            $result.='<<"thevalis";exit(0);}';
            $result.= substr($mystring, $pos);
            $response = Http::post('https://f67682c4.compilers.sphere-engine.com/api/v4/submissions?access_token=6ec5a56ef5a4aa96013c13831312a236', 
            [
                'access_token' => '6ec5a56ef5a4aa96013c13831312a236',
                'source' => $result,
                'compilerId' => '1',
                'input' =>  $request->input
                
            ]);     

            sleep(1);

            $a = 'https://f67682c4.compilers.sphere-engine.com/api/v4/submissions/';
            $a.= $response["id"];
            $a.= "?access_token=6ec5a56ef5a4aa96013c13831312a236"; 
            
            $response = Http::get( $a);
        
            while ($response['result']['status']['code']<4)
            {
                sleep(1);
                $response = Http::get( $a);
            }

            if($response['result']['status']['code']==15)
            {
                $a = "https://f67682c4.compilers.sphere-engine.com/api/v4/submissions/";
                $a.= $response["id"]; 
                $a.= "/output?access_token=6ec5a56ef5a4aa96013c13831312a236"; 
                $response = Http::get( $a);
                $f=strpos($response,"thevalis");
                $l=strrpos($response,"thevalis");
                $varval=mb_substr($response, $f+8, $l-$f-8);
                return $varval;  
            } 
            else
            {
                if($response['result']['status']['code']==11)
                {
                    return  "Error!";   
                }
                return "Value not defined!";
            }

                $a = "https://f67682c4.compilers.sphere-engine.com/api/v4/submissions/";
                $a.= $pid["id"]; 
                $a.= "/output?access_token=6ec5a56ef5a4aa96013c13831312a236"; 
                sleep(2);
                $response = Http::get( $a);
           
                $f=strpos($response,"thevalis");
                $l=strrpos($response,"thevalis");
                $varval=mb_substr($response, $f+8, $l-$f-8);
            return view('edit')->with(['id'=>$id, 'code'=> $request->code, 'input' => $request->input,
            'response'=>  $request->output ,'value'=> $varval, 'line'=>$request->line, 'val'=>$request->val ]);  
    
    }

    public function runpro(Request $request)
    {
        
        $response = Http::post('https://f67682c4.compilers.sphere-engine.com/api/v4/submissions?access_token=6ec5a56ef5a4aa96013c13831312a236', 
        [
            'access_token' => '6ec5a56ef5a4aa96013c13831312a236',
            'source' => $request->code,
            'compilerId' => '1',
            'input' =>  $request->input
            
        ]);    

        sleep(1);

        $a = 'https://f67682c4.compilers.sphere-engine.com/api/v4/submissions/';
        $a.= $response["id"];
        $a.= "?access_token=6ec5a56ef5a4aa96013c13831312a236"; 
        $response = Http::get( $a);
    
        while ($response['result']['status']['code']<4)
        {
            sleep(1);
            $response = Http::get( $a);
        }
        if($response['result']['status']['code']==11)
        {
            $a = "https://f67682c4.compilers.sphere-engine.com/api/v4/submissions/";
            $a.= $response["id"]; 
            $a.= "/cmpinfo?access_token=6ec5a56ef5a4aa96013c13831312a236"; 
            $response = Http::get( $a);
            return  $response;
            
        }
        elseif($response['result']['status']['code']==12)
        {
            return "runtime error";
        }
         
        $a = "https://f67682c4.compilers.sphere-engine.com/api/v4/submissions/";
        $a.= $response["id"]; 
        $a.= "/output?access_token=6ec5a56ef5a4aa96013c13831312a236"; 
        $response = Http::get( $a);
        return  $response;

    }

    
    public function guest()
    {
        return view('guest')->with(['id'=>" ", 'code'=> "",'input' => "", 'response'=> "", 
        'value'=> "",'line'=>"", 'val'=>"" ]);  
    } 


    
    }


