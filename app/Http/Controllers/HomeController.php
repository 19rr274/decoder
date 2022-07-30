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
        $this->middleware('auth')->except(['guest','runpro','find','loaddb']) ;
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
        $complierTable = DB::table('compilerTable')->get();
        return view('home')->with(['todos'=> $todos,'user_id'=> $user_id ,'complierTable'=> $complierTable]); 
    }   

    public function edit($id)
    {
        $row = Todo::find($id);
        $code = $row->code;
        $response = "";
        $input ="";
        $compilerId=$row->compilerId;
        $compilerName=$row->compilerName;
        return view('edit')->with(['id'=>$id, 'code'=> $code,'input' => $input, 'response'=> $response, 
        'value'=> "",'line'=>"", 'val'=>"" ,'compilerId'=> $compilerId,'compilerName'=> $compilerName]);
        
    } 

    public function upload(Request $request)
    {
        $todo = $request->title;
        $user_id = auth()->user()->id;
        $complierTable = DB::table('compilerTable')->get();
        foreach ($complierTable as $complierTable) {
            if($complierTable->compilerId == $request->compiler) {
                $compilerName=$complierTable->name;
            }
          }
         
        DB::insert('insert into todos (user_id, title,compilerId,compilerName) values (?, ?, ? ,? )', [$user_id, $todo, $request->compiler,$compilerName]);
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
            $response = Http::post('https://992fe1c1.compilers.sphere-engine.com/api/v4/submissions?access_token=559e61809a29b5159d4b789da515b0d5', 
            [
                'access_token' => '559e61809a29b5159d4b789da515b0d5',
                'source' => $result,
                'compilerId' => '1',
                'input' =>  $request->input
                
            ]);     

            sleep(1);

            $a = 'https://992fe1c1.compilers.sphere-engine.com/api/v4/submissions/';
            $a.= $response["id"];
            $a.= "?access_token=559e61809a29b5159d4b789da515b0d5"; 
            
            $response = Http::get( $a);
        
            while ($response['result']['status']['code']<4)
            {
                sleep(1);
                $response = Http::get( $a);
            }

            if($response['result']['status']['code']==15)
            {
                $a = "https://992fe1c1.compilers.sphere-engine.com/api/v4/submissions/";
                $a.= $response["id"]; 
                $a.= "/output?access_token=559e61809a29b5159d4b789da515b0d5"; 
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

                $a = "https://992fe1c1.compilers.sphere-engine.com/api/v4/submissions/";
                $a.= $pid["id"]; 
                $a.= "/output?access_token=559e61809a29b5159d4b789da515b0d5"; 
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
        
        $response = Http::post('https://992fe1c1.compilers.sphere-engine.com/api/v4/submissions?access_token=559e61809a29b5159d4b789da515b0d5', 
        [
            'access_token' => '559e61809a29b5159d4b789da515b0d5',
            'source' => $request->code,
            'compilerId' => $request->compilerId,
            'input' =>  $request->input
            
        ]);    
        
        sleep(1);

        $a = 'https://992fe1c1.compilers.sphere-engine.com/api/v4/submissions/';
        $a.= $response["id"];
        $a.= "?access_token=559e61809a29b5159d4b789da515b0d5"; 
        $response = Http::get( $a);
    
        while ($response['result']['status']['code']<4)
        {
            sleep(1);
            $response = Http::get( $a);
        }
        
        if($response['result']['status']['code']==11)
        {
            $a = "https://992fe1c1.compilers.sphere-engine.com/api/v4/submissions/";
            $a.= $response["id"]; 
            $a.= "/cmpinfo?access_token=559e61809a29b5159d4b789da515b0d5"; 
            $response = Http::get( $a);
            return  $response;
            
        }
        elseif($response['result']['status']['code']==12)
        {
            return "runtime error";
        }
         
        $a = "https://992fe1c1.compilers.sphere-engine.com/api/v4/submissions/";
        $a.= $response["id"]; 
        $a.= "/output?access_token=559e61809a29b5159d4b789da515b0d5"; 
        $response = Http::get( $a);
        return  $response;

    }

    
    public function guest()
    {
        $complierTable = DB::table('compilerTable')->get();
       
        return view('guest')->with(['id'=>" ", 'code'=> "",'input' => "", 'response'=> "", 
        'value'=> "",'line'=>"", 'val'=>"" ,'complierTable'=> $complierTable]);  
    } 


    public function loaddb()
    {
        DB::table('compilerTable')->insert([
            ['name' => 'C++ [Beginners]', 'compilerId' => 	1	 ],
            ['name' => '	AWK [GAWK]	 ', 'compilerId' => 	104	 ],
            ['name' => '	AWK [MAWK]	 ', 'compilerId' => 	105	 ],
            ['name' => '	Ada	 ', 'compilerId' => 	7	 ],
            ['name' => '	Assembler [GCC]	 ', 'compilerId' => 	45	 ],
            ['name' => '	Assembler [NASM 64bit]	 ', 'compilerId' => 	42	 ],
            ['name' => '	Assembler [NASM]	 ', 'compilerId' => 	13	 ],
            ['name' => '	Bash	 ', 'compilerId' => 	28	 ],
            ['name' => '	Brainf**k	 ', 'compilerId' => 	12	 ],
            ['name' => '	C	 ', 'compilerId' => 	11	 ],
            ['name' => '	C#	 ', 'compilerId' => 	86	 ],
            ['name' => '	C# [Mono]	 ', 'compilerId' => 	27	 ],
            ['name' => '	C++ 4.3.2	 ', 'compilerId' => 	41	 ],
           
            ['name' => '	C++14 [GCC]	 ', 'compilerId' => 	44	 ],
            ['name' => '	C99 strict	 ', 'compilerId' => 	34	 ],
            ['name' => '	CLIPS	 ', 'compilerId' => 	14	 ],
            ['name' => '	COBOL	 ', 'compilerId' => 	118	 ],
            ['name' => '	Clojure	 ', 'compilerId' => 	111	 ],
            ['name' => '	Common Lisp [CLISP]	 ', 'compilerId' => 	32	 ],
            ['name' => '	D [DMD]	 ', 'compilerId' => 	102	 ],
            ['name' => '	D [GDC]	 ', 'compilerId' => 	20	 ],
            ['name' => '	Dart	 ', 'compilerId' => 	48	 ],
            ['name' => '	Elixir	 ', 'compilerId' => 	96	 ],
            ['name' => '	Erlang	 ', 'compilerId' => 	36	 ],
            ['name' => '	F#	 ', 'compilerId' => 	124	 ],
            ['name' => '	Forth	 ', 'compilerId' => 	107	 ],
            ['name' => '	Fortran	 ', 'compilerId' => 	5	 ],
            ['name' => '	Go	 ', 'compilerId' => 	114	 ],
            ['name' => '	Groovy	 ', 'compilerId' => 	121	 ],
            ['name' => '	Haskell	 ', 'compilerId' => 	21	 ],
            ['name' => '	Icon	 ', 'compilerId' => 	16	 ],
            ['name' => '	Intercal	 ', 'compilerId' => 	9	 ],
            ['name' => '	Java	 ', 'compilerId' => 	10	 ],
            ['name' => '	Java - legacy	 ', 'compilerId' => 	55	 ],
            ['name' => '	JavaScript [Rhino]	 ', 'compilerId' => 	35	 ],
            ['name' => '	JavaScript [SpiderMonkey]	 ', 'compilerId' => 	112	 ],
            ['name' => '	Kotlin	 ', 'compilerId' => 	47	 ],
            ['name' => '	Lua	 ', 'compilerId' => 	26	 ],
            ['name' => '	Nemerle	 ', 'compilerId' => 	30	 ],
            ['name' => '	Nice	 ', 'compilerId' => 	25	 ],
            ['name' => '	Node.js	 ', 'compilerId' => 	56	 ],
            ['name' => '	Objective-C	 ', 'compilerId' => 	43	 ],
            ['name' => '	Ocaml	 ', 'compilerId' => 	8	 ],
            ['name' => '	Octave	 ', 'compilerId' => 	127	 ],
            ['name' => '	PHP	 ', 'compilerId' => 	29	 ],
            ['name' => '	Pascal [FPC]	 ', 'compilerId' => 	22	 ],
            ['name' => '	Pascal [GPC]	 ', 'compilerId' => 	2	 ],
            ['name' => '	Perl	 ', 'compilerId' => 	3	 ],
            ['name' => '	Perl 6	 ', 'compilerId' => 	54	 ],
            ['name' => '	Pike	 ', 'compilerId' => 	19	 ],
            ['name' => '	Prolog [GNU]	 ', 'compilerId' => 	108	 ],
            ['name' => '	Prolog [SWI]	 ', 'compilerId' => 	15	 ],
            ['name' => '	Python (Pypy)	 ', 'compilerId' => 	99	 ],
            ['name' => '	Python 2.x [Pypy]	 ', 'compilerId' => 	4	 ],
            ['name' => '	Python 3.x	 ', 'compilerId' => 	116	 ],
            ['name' => '	R	 ', 'compilerId' => 	117	 ],
            ['name' => '	Racket	 ', 'compilerId' => 	95	 ],
            ['name' => '	Ruby	 ', 'compilerId' => 	17	 ],
            ['name' => '	Rust	 ', 'compilerId' => 	93	 ],
            ['name' => '	SQLite - queries	 ', 'compilerId' => 	52	 ],
            ['name' => '	SQLite - schema	 ', 'compilerId' => 	40	 ],
            ['name' => '	Scala	 ', 'compilerId' => 	39	 ],
            ['name' => '	Scheme	 ', 'compilerId' => 	18	 ],
            ['name' => '	Scheme [Chicken]	 ', 'compilerId' => 	97	 ],
            ['name' => '	Scheme [Guile]	 ', 'compilerId' => 	33	 ],
            ['name' => '	Sed	 ', 'compilerId' => 	46	 ],
            ['name' => '	Smalltalk	 ', 'compilerId' => 	23	 ],
            ['name' => '	Swift	 ', 'compilerId' => 	85	 ],
            ['name' => '	Tcl	 ', 'compilerId' => 	38	 ],
            ['name' => '	Text	 ', 'compilerId' => 	62	 ],
            ['name' => '	TypeScript	 ', 'compilerId' => 	57	 ],
            ['name' => '	VB	 ', 'compilerId' => 	88	 ],
            ['name' => '	VB.NET	 ', 'compilerId' => 	50	 ],
            ['name' => '	Whitespace	 ', 'compilerId' => 	6	 ],
            ['name' => '	bc	 ', 'compilerId' => 	110	 ],
           

        ]);
        
        
    }
    }


