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
        $this->middleware('auth');
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
        DB::insert('insert into Todos (user_id, title) values (?, ?)', [$user_id, $todo]);
        return redirect()->route('home');
    }
    public function delete($id)
    {
        Todo::find($id)->delete();
        return redirect()->route('home');
    } 

    public function save($id,Request $request)
    {
        $code = $request->code;
        DB::table('Todos')->where("id", '=', $id)->update(['code'=> $code ]);
        $row = Todo::find($id);
        return view('edit')->with(['id'=>$id, 'code'=> $row->code,'input' =>  $request->input, 
        'response'=>  $request->response, 'value'=>$request->value,'line'=>$request->line, 'val'=>$request->val ]);
    } 



        
    public function run($id,Request $request)
    {
        $code = $request->code;
        DB::table('Todos')->where("id", '=', $id)->update(['code'=> $code ]);
        $row = Todo::find($id);
        $pid = Http::post('https://7c4c8575.compilers.sphere-engine.com/api/v4/submissions?access_token=8617797e8aa5b87b86878c267c0f1fae', 
        [
            'access_token' => '8617797e8aa5b87b86878c267c0f1fae',
            'source' => $row->code,
            'compilerId' => '1',
            'input' =>  $request->input
            
        ]);     
            $a = "https://7c4c8575.compilers.sphere-engine.com/api/v4/submissions/";
            $a.= $pid["id"]; 
            $a.= "/output?access_token=8617797e8aa5b87b86878c267c0f1fae"; 
            $b= $pid["id"]; 
            sleep(2);
            $response = Http::get( $a);
        return view('edit')->with(['id'=>$id, 'code'=> $row->code, 'input' =>  $request->input ,'response'=> $response ,
        'value'=> $request->value,'line'=>$request->line, 'val'=>$request->val ]);  
    } 










    
    public function find($id,Request $request)
    {
        

        $pro = Todo::find(1)->code;
        $input= $request->line;
        $input.= "\n";
        $input.= $request->val;
        $input.= "\n";
        $input.= $request->code;
        $input.= "\n";
        $input.= "This is the end";

        $pid = Http::post('https://7c4c8575.compilers.sphere-engine.com/api/v4/submissions?access_token=8617797e8aa5b87b86878c267c0f1fae', 
        [
            'access_token' => '8617797e8aa5b87b86878c267c0f1fae',
            'source' => $pro,
            'compilerId' => '116',
            'input' =>  $input
            
        ]);     
            $a = "https://7c4c8575.compilers.sphere-engine.com/api/v4/submissions/";
            $a.= $pid["id"]; 
            $a.= "/output?access_token=8617797e8aa5b87b86878c267c0f1fae"; 
           
        
            sleep(2);

            $response = Http::get( $a);


        
            $source=$response;


            $q='3';
            DB::table('Todos')->where("id", '=', $q)->update(['code'=> $source ]);
            $row = Todo::find($q);
            $w=$row->code;
            $pid = Http::post('https://7c4c8575.compilers.sphere-engine.com/api/v4/submissions?access_token=8617797e8aa5b87b86878c267c0f1fae', 
            [
                'access_token' => '8617797e8aa5b87b86878c267c0f1fae',
                'source' => $w,
                'compilerId' => '1',
                'input' =>  $request->input
                
            ]);     
                $a = "https://7c4c8575.compilers.sphere-engine.com/api/v4/submissions/";
                $a.= $pid["id"]; 
                $a.= "/output?access_token=8617797e8aa5b87b86878c267c0f1fae"; 
          
                sleep(2);
                $response = Http::get( $a);
           
                $f=strpos($response,"thevalis");
                $l=strrpos($response,"thevalis");
                $varval=mb_substr($response, $f+8, $l-$f-8);
            return view('edit')->with(['id'=>$id, 'code'=> $request->code, 'input' => $request->input,
            'response'=>  $request->output ,'value'=> $varval, 'line'=>$request->line, 'val'=>$request->val ]);  
    
        }





    //     public function find($id,Request $request)
    // {       

    //     $index=-1;
    //     for ($i = 0; $i < $request->line ; $i++) 
    //     {
    //         $index = strpos($request->code, "\n", 1 + $index );
    //     }
    //     $index
    //     $code=substr($request->code,0,$index+1);
    //     $code.=
    //     $code.=substr($request->code,$index,);








    
    }


